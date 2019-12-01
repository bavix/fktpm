<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\File;
use App\Models\Post;
use App\Models\Tag;
use App\Services\RouteService;
use App\Services\TagService;
use Illuminate\Console\Command;
use Laravelium\Sitemap\Sitemap;

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
     * Execute the console command.
     *
     * @return string
     * @throws
     */
    public function handle(): string
    {
        ini_set('memory_limit', -1);

        // route
        request()->server->set('HTTPS', true);
        app()->setLocale('ru');

        /**
         * @var $map Sitemap
         */
        $map = app()->make('sitemap');

        // add items to the sitemap (url, date, priority, freq)
        $map->add(route('post'), null, 1., 'always');
        $map->add(route('professor'), null, .9, 'monthly');
        $map->add(route('couple'), null, .9, 'monthly');
        $map->add(route('helper'), null, .9, 'monthly');

        /**
         * @var File[] $files
         */
        $files = File::where('active', 1)->cursor();
        foreach ($files as $file) {
            $map->add(
                app(RouteService::class)->file($file),
                null,
                .9,
                'yearly'
            );
        }

        $fileTagIds = app(TagService::class)
            ->getIdsBy(File::class)
            ->get()
            ->pluck('id')
            ->toArray();

        $tags = Tag::whereKey($fileTagIds)->cursor();

        /**
         * @var Tag[] $tags
         */
        foreach ($tags as $tag) {
            $map->add(
                app(RouteService::class)->fileTag($tag),
                null,
                .6 + ($tag->is_block / 10),
                'daily'
            );
        }

        /**
         * @var Post[] $posts
         */
        $posts = Post::where('active', 1)->cursor();
        foreach ($posts as $post) {
            $map->add(
                app(RouteService::class)->post($post),
                null,
                .9,
                'weekly'
            );
        }

        /**
         * @var Tag $tag
         */
        foreach (Tag::cursor() as $tag) {
            $map->add(
                app(RouteService::class)->postTag($tag),
                null,
                .6 + ($tag->is_block / 10),
                'daily'
            );
        }

        /**
         * @var Category $category
         */
        foreach (Category::cursor() as $category) {
            $map->add(
                app(RouteService::class)->postCategory($category),
                null,
                .8,
                'daily'
            );
        }

        $map->store();

        return 'The file is successfully generated!';
    }

}
