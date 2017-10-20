<?php

namespace App\Console\Commands;

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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $rules = ['cp', 'upload'];
        $path = public_path('sitemap.xml');

        SitemapGenerator::create(config('app.url'))
            ->shouldCrawl(function (Url $url) use ($rules) {
                return !Arr::in($rules, $url->segment(1));
            })
            ->writeToFile($path);

        return 'The file is successfully generated!';
    }

}
