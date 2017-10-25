<?php

namespace App\Console\Commands;

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
        $dom = \bavix\AdvancedHtmlDom\fileGetHtml('https://fktpm.ru');

        $panels = $dom->find('.col-md-4 .panel.lm-table');

        foreach ($panels as $panel)
        {
            var_dump($panel->find('.panel-heading'));die;
        }
    }

}
