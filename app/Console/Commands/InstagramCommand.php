<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Post;
use Bavix\Helpers\Arr;
use Bavix\Helpers\Dir;
use Bavix\Helpers\PregMatch;
use Bavix\Helpers\Str;
use Bavix\SDK\PathBuilder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use InstagramAPI\Instagram;
use InstagramAPI\Response\Model\CarouselMedia;
use InstagramAPI\Response\Model\Image_Versions2;
use InstagramAPI\Response\Model\ImageCandidate;
use InstagramAPI\Response\Model\Item;

class InstagramCommand extends Command
{

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
    protected $description = 'Instagram Importer';

    /***
     * @var Category
     */
    protected $category;

    protected $tags = [
        'фктипм', 
        'фктипмкубгу', 
        'кубгуфпм', 
        'кубгу',
        'kubsu',
    ];

    protected $blocked = [
        'applehelp_accessories',
        'elenashop_krasnodar',
        'nail_brow_lash',
        'krasnodar_resnichki',
        'lash_and_brow_krasnodar',
        'beauty_lashes23',
        'alisaiks_krasnodar',
        'titova_resnizy',
        'art_beauty_krd',
        'massage_zet',
        'massage_mix',
        'massage_krd__',
        'slim_massage_krd',
        'massage_stroinoetelo_krasnodar',
        'dr_baselmelhem',
        'orlov_ortho',
    ];

    /**
     * @return string
     */
    protected function path()
    {
        $builder = PathBuilder::sharedInstance();
        $name    = Str::random();
        $hash    = $builder->hash($name);

        return 'image/' . $hash . '/' . $name . '.jpg';
    }

    /**
     * @param Image_Versions2 $image
     *
     * @return string
     */
    public function storeImage(Image_Versions2 $image)
    {
        $candidates = $image->getCandidates();

        usort($candidates, function (ImageCandidate $obj1, ImageCandidate $obj2) {
            return $obj2->getWidth() <=> $obj1->getWidth();
        });

        /**
         * @var ImageCandidate $candidate
         */
        $candidate = \current($candidates);
        $path      = $this->path();

        $storage = \Storage::disk('public');

        Dir::make(\dirname($storage->path($path)));
        $storage->put($path, \fopen($candidate->getUrl(), 'rb'));

        return $path;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function category()
    {
        if (!$this->category)
        {
            $this->category = Category::query()
                ->where('title', 'Instagram')
                ->first();

            if (!$this->category)
            {
                $this->category = new Category();
                $this->category->title = 'Instagram';
                $this->category->save();
            }
        }

        return $this->category;
    }

    /**
     * @param Item $item
     *
     * @return bool
     */
    public function store(Item $item)
    {
        $model = Post::query()
            ->where('instagram_code', $item->getCode())
            ->first();

        if ($model)
        {
            $model->active = !Arr::in($this->blocked, $item->getUser()->getUsername());
            $model->save();

            // if post exists then skip
            return false;
        }

        // get images
        if ($item->getImageVersions2())
        {
            // image_versions2
            $images = [
                $this->storeImage($item->getImageVersions2())
            ];
        }
        else
        {
            // carousel_media
            $images = [];

            /**
             * @var $carouselMedia CarouselMedia
             */
            foreach ($item->getCarouselMedia() as $carouselMedia)
            {
                $images[] = $this->storeImage($carouselMedia->getImageVersions2());
            }
        }

        // get caption
        $content = '';
        $caption = $item->getCaption();

        if ($caption)
        {
            $content = $caption->getText();
        }

        // get tags
        $preg = PregMatch::all('~#([\wа-яё]+)~iu', $content);
        $tags = $preg->matches[1] ?? [];

        $image = Arr::shift($images);

        $post                 = new Post();
        $post->title          = Str::shorten('Пост ' . $item->getPk() . ' от ' . $item->getUser()->getFullName(), 150);
        $post->description    = Str::shorten($content, 590);
        $post->content        = '<p>' . $content . '</p>';
        $post->active         = !Arr::in($this->blocked, $item->getUser()->getUsername());
        $post->category_id    = $this->category()->id;
        $post->instagram_code = $item->getCode();

        $post->setTagsAttribute($tags);
        $post->setPictureAttribute($image);
        $post->setGalleryAttribute($images);

        return true;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $instagram = new Instagram(false, false);

        try {
            $instagram->login(
                config('instagram.username'),
                config('instagram.password')
            );
        } catch (\Throwable $throwable) {
            Log::error($throwable->getMessage(), $throwable->getTrace());
            return;
        }

        foreach ($this->tags as $tag)
        {
            $uuid = \InstagramAPI\Signatures::generateUUID();
            $items = $instagram->hashtag->getFeed($tag, $uuid)->getItems();

            $this->error('Tag #' . $tag);

            foreach ($items as $item)
            {
                if ($this->store($item))
                {
                    $this->info('Item #' . $item->getId() . '; code=' . $item->getCode());

                    continue;
                }

                $this->warn('Item #' . $item->getId() . '; code=' . $item->getCode());

//            $this->warn('broken');
//            break;
            }

            // sleep(120);
        }

        Cache::clear();

    }

}
