<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Image;
use App\Models\Post;
use Bavix\Helpers\Arr;
use Bavix\Helpers\Dir;
use Bavix\Helpers\JSON;
use Bavix\Helpers\PregMatch;
use Bavix\Helpers\Str;
use Bavix\SDK\PathBuilder;
use Illuminate\Console\Command;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
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
        $candidates = $image->candidates;

        usort($candidates, function (ImageCandidate $obj1, ImageCandidate $obj2) {
            return $obj2->width <=> $obj1->width;
        });

        /**
         * @var ImageCandidate $candidate
         */
        $candidate = current($candidates);
        $path      = $this->path();

        $storage = \Storage::disk('public');

        Dir::make(\dirname($storage->path($path)));
        $storage->put($path, \fopen($candidate->url, 'rb'));

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
                $this->category        = new Category();
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
            // if post exists then skip
            return false;
        }

        // get images
        if ($item->image_versions2)
        {
            // image_versions2
            $images = [
                $this->storeImage($item->image_versions2)
            ];
        }
        else
        {
            // carousel_media
            $images = [];

            /**
             * @var $carouselMedia CarouselMedia
             */
            foreach ($item->carousel_media as $carouselMedia)
            {
                $images[] = $this->storeImage($carouselMedia->image_versions2);
            }
        }

        // get caption
        $content = '';
        $caption = $item->caption;

        if ($caption)
        {
            $content = $caption->getText();
        }

        // get tags
        $preg = PregMatch::all('~#([\wа-яё]+)~iu', $content);
        $tags = $preg->matches[1] ?? [];

        $image = Arr::shift($images);

        $post                 = new Post();
        $post->title          = Str::shorten('Пост ' . $item->pk . ' от ' . $item->user->getFullName(), 150);
        $post->description    = Str::shorten($content, 590);
        $post->content        = '<p>' . $content . '</p>';
        $post->active         = 1;
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
        $instagram = new Instagram(
            false,
            false,
            config('instagram.config')
        );

        $instagram->login(
            config('instagram.username'),
            config('instagram.password')
        );

        $items = $instagram->hashtag->getFeed('фктипм')->getItems();

        foreach ($items as $item)
        {
            $this->info('Item #' . $item->id . '; code=' . $item->getCode());

            if ($this->store($item))
            {
                continue;
            }

            $this->warn('broken');
            break;
        }
    }

}
