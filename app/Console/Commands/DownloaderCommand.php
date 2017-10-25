<?php

namespace App\Console\Commands;

use App\Models\File;
use function Bavix\AdvancedHtmlDom\strGetHtml;
use Bavix\Helpers\Dir;
use Bavix\Helpers\PregMatch;
use Bavix\Helpers\Str;
use Bavix\Helpers\Stream;
use Bavix\SDK\PathBuilder;
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

    /**
     * @var string
     */
    protected $tag;

    protected function download($from, $name, $type)
    {
        $file = File::query()
            ->where('title', $name)
            ->where('type', $type)
            ->first();

        if ($file)
        {
            $this->warn('File found: ' . $name . '.' . $type);
            return;
        }

        $random = Str::random();
        $path = PathBuilder::sharedInstance()
            ->hash($random) . '/' . $random . '.' . $type;

        $to = \Storage::disk('admin')->path(
            $path
        );

        Dir::make(dirname($to));

        Stream::download($from, $to);

        if (\Storage::disk('admin')->exists($path))
        {
            $file = new File();

            $file->title = $name;
            $file->file = $path;
            $file->tags = [$this->tag];

            $file->save();

            $this->info('The file is successfully loaded');
        }
    }

    public function handle()
    {
        $site = 'https://fktpm.ru';

        $dom = \bavix\AdvancedHtmlDom\fileGetHtml($site);

        $panels = $dom->find('.col-md-4 .panel.lm-table');

        foreach ($panels as $panel)
        {
            $heading = $panel->find('.panel-heading .col-md-12');

            $this->tag = PregMatch::first('~\n([\s\wа-яё()-]+) \<span~iu', $heading->innertext)
                ->matches[1];

            $this->info('found block: ' . $this->tag);

            $links = $panel->find('.panel-body a');

            foreach ($links as $link)
            {
                $attributes = $link->attributes();

                $name = $link->text();
                $href = $attributes['href'];
                $type = $attributes['type'];

                $this->warn(
                    'There is a loading of the file `' . $name . '` from ' . $site . $href
                );

                $this->download($site . $href, $name, $type);
            }

        }
    }

}
