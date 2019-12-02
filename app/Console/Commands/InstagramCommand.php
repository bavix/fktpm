<?php

namespace App\Console\Commands;

use App\Models\Blacklist;
use App\Models\Category;
use App\Models\Following;
use App\Models\Image;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use InstagramAPI\Instagram;
use InstagramAPI\Response\Model\Image_Versions2;
use InstagramAPI\Response\Model\ImageCandidate;
use InstagramAPI\Response\Model\Item;
use InstagramAPI\Signatures;

class InstagramCommand extends Command
{

    protected const CATEGORY_INSTAGRAM = 'Instagram';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bx:instagram';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Instagram import';

    /***
     * @var Category
     */
    protected $category;

    /**
     * @var array
     */
    protected $tags;

    /**
     * @var array
     */
    protected $blacklist;

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $service = new Instagram(false, false);

        try {
            $service->login(
                config('instagram.username'),
                config('instagram.password')
            );
        } catch (\Throwable $throwable) {
            Log::error($throwable->getMessage(), $throwable->getTrace());
            return;
        }

        $this->category = app(PostService::class)
            ->getCategory(self::CATEGORY_INSTAGRAM);

        /**
         * @var Following $following
         */
        foreach (Following::cursor() as $following) {
            $items = $service->hashtag
                ->getFeed($following->name, Signatures::generateUUID())
                ->getItems();

            $this->error('Tag #' . $following->name);
            foreach ($items as $item) {
                if ($this->putPost($item)) {
                    $this->info('Item #' . $item->getId() . '; code=' . $item->getCode());
                    continue;
                }

                $this->warn('Item #' . $item->getId() . '; code=' . $item->getCode());
            }
        }
    }

    /**
     * @param Item $item
     *
     * @return bool
     */
    public function putPost(Item $item): bool
    {
        $model = app(PostService::class)
            ->byInstagramCode($item->getCode());

        $userName = $item->getUser()->getUsername();
        if (in_array($userName, $this->getBlacklist(), true)) {
            if ($model && $model->active) {
                $model->update(['active' => false]);
            }
            return false;
        }

        if ($model) {
            if (!$model->user_name) {
                $model->update(['user_name' => $userName]);
            }
            return false;
        }

        /**
         * @var string[] $images
         * @var Image[] $modelImages
         */
        $images = $this->getGallery($item);
        $modelImages = app(PostService::class)
            ->upload($images);

        if (empty($modelImages)) {
            return false;
        }

        $caption = $this->getCaption($item);
        $post = Post::create([
            'title' => Str::limit(
                'Пост ' . $item->getPk() . ' от ' . $item->getUser()->getFullName(),
                150,
                '...'
            ),
            'description' => Str::limit($caption, 590, '...'),
            'content' => "<p>$caption</p>",
            'active' => true,
            'category_id' => $this->category->id,
            'instagram_code' => $item->getCode(),
            'user_name' => $userName,
        ]);

        $tags = $this->getTags($caption);
        $post->setTagsAttribute($tags);

        app(PostService::class)
            ->setImage($post, array_shift($modelImages));

        if (!empty($modelImages)) {
            app(PostService::class)
                ->addImages($post, $modelImages);
        }

        return true;
    }

    /**
     * @param string $caption
     * @return array
     */
    protected function getTags(string $caption): array
    {
        preg_match_all('~#([\wа-яё]+)~iu', $caption, $matches);
        if (!empty($matches[1])) {
            return $matches[1];
        }

        return [];
    }

    /**
     * @param Item $item
     * @return string
     */
    protected function getCaption(Item $item): string
    {
        $caption = $item->getCaption();
        if ($caption) {
            return $caption->getText();
        }

        return '';
    }

    /**
     * @param Image_Versions2 $image
     * @return string
     */
    protected function getImageUrl(Image_Versions2 $image): string
    {
        /**
         * @var ImageCandidate[] $candidates
         */
        $candidates = $image->getCandidates();
        usort($candidates, static function (ImageCandidate $obj1, ImageCandidate $obj2) {
            return $obj2->getWidth() <=> $obj1->getWidth();
        });

        return \current($candidates)->getUrl();
    }

    /**
     * @param Item $item
     * @return array
     */
    protected function getGallery(Item $item): array
    {
        if ($item->getImageVersions2()) {
            return [
                $this->getImageUrl($item->getImageVersions2())
            ];
        }

        $images = [];
        foreach ($item->getCarouselMedia() as $carouselMedia) {
            $images[] = $this->getImageUrl($carouselMedia->getImageVersions2());
        }

        return $images;
    }

    /**
     * @return array
     */
    protected function getBlacklist(): array
    {
        if (!$this->blacklist) {
            $this->blacklist = Blacklist::all()
                ->pluck('name')
                ->toArray();
        }

        return $this->blacklist;
    }

}
