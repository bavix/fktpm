<?php

namespace App\Console\Commands;

use function Bavix\AdvancedHtmlDom\strGetHtml;
use Bavix\Helpers\PregMatch;
use Illuminate\Console\Command;

class DownloaderCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fktpm:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'fktpm-files importer';

    public function handle()
    {
        $site = 'https://fktpm.ru/';

        $dom = \bavix\AdvancedHtmlDom\fileGetHtml($site);

        $panels = $dom->find('.col-md-4 .panel.lm-table');

        foreach ($panels as $panel)
        {
            $heading = $panel->find('.panel-heading .col-md-12');

            $title = PregMatch::first('~\n([\s\wа-яё()-]+) \<span~iu', $heading->innertext)
                ->matches[1];

            $this->info('found block: ' . $title);

            $links = $panel->find('.panel-body a');

            foreach ($links as $link)
            {
                $attributes = $link->attributes();

                $name = $link->text();
                $href = $attributes['href'];

                $this->warn(
                    'There is a loading of the file `' . $name . '` from ' . $site . $href
                );
            }

        }
    }

}
