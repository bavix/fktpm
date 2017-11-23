<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\File;
use App\Models\Post;
use App\Models\Tag;
use Bavix\Helpers\Arr;
use Illuminate\Console\Command;
use Spatie\Crawler\Url;
use Spatie\Sitemap\SitemapGenerator;

class SitemapCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bx:sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create and generate sitemaps with ease';

    /**
     * @var array
     */
    protected $urls = [];

    /**
     * @param $date
     *
     * @return false|string
     */
    protected function getLastModifiedDate($date)
    {
        return date('c', strtotime($date));
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $self = $this;

        // route
        request()->server->set('HTTPS', true);
        app()->setLocale('ru');

        /**
         * @var $map \Roumen\Sitemap\Sitemap
         */
        $map = app()->make('sitemap');

        // add items to the sitemap (url, date, priority, freq)
        $map->add(route('post'), null, 1., 'always');
        $map->add(route('professor'), null, .9, 'monthly');
        $map->add(route('couple'), null, .9, 'monthly');
        $map->add(route('helper'), null, .9, 'monthly');

        /**
         * files
         *
         * @var $tags Tag[]
         */
        $tags = Tag::blocks();

        foreach ($tags as $tag)
        {
            /**
             * @var $file File
             * @var $_tag Tag
             */
            foreach ($tag->files as $file)
            {
                $map->add($file->url(), null, .9, 'yearly');

                foreach ($file->tags as $_tag)
                {
                    $route = route('file.tag', [$_tag->slug]);

                    if (isset($this->urls[$route]))
                    {
                        continue;
                    }

                    $this->urls[$route] = true;

                    // add file tags
                    $map->add($route, null, .6 + ($tag->is_block / 10), 'daily');
                }
            }
        }

        // posts
        $posts = Post::query()
            ->where('active', 1);

        $posts->chunk(1000, function ($posts) use ($map, $self) {
            /**
             * @var $posts Post[]
             */
            foreach ($posts as $post)
            {
                $map->add($post->url(), null, .9, 'weekly');

                foreach ($post->tags as $_tag)
                {
                    $route = $post->routeTag($_tag->slug);

                    if (isset($self->urls[$route]))
                    {
                        continue;
                    }

                    $self->urls[$route] = true;

                    // add file tags
                    $map->add($route, null, .6, 'daily');
                }
            }
        });

        // categories
        foreach (Category::all() as $category)
        {
            $map->add($category->url(), null, .8, 'daily');
        }

        $map->store();

        return 'The file is successfully generated!';
    }

}
