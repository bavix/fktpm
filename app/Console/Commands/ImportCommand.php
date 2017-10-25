<?php

namespace App\Console\Commands;

use App\Models\File;
use Bavix\Helpers\Arr;
use Bavix\Helpers\Dir;
use Bavix\Helpers\PregMatch;
use Bavix\Helpers\Str;
use Bavix\Helpers\Stream;
use Bavix\SDK\PathBuilder;
use cijic\phpMorphy\Facade\Morphy;
use Illuminate\Console\Command;

/**
 * Class FileParserCommand
 *
 * @package App\Console\Commands
 *
 *          // automatic show blocks
 *          UPDATE `tags` SET `is_block`=1 WHERE id in (select tag_id from (
 * select tag_id, count(distinct taggable_id) cnt
 * from taggables
 * group by tag_id) t where t.cnt > 3)
 */
class ImportCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fktpm:import {task}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'fktpm importer';

    /**
     * @var string
     */
    protected $key;

    protected $tags = [
        '8й-семестр'       => ['Семестр №8'],
        '7й-семестр'       => ['Семестр №7'],
        '6й-семестр'       => ['Семестр №6'],
        '5й-семестр'       => ['Семестр №5'],
        '4й-семестр'       => ['Семестр №4'],
        '3й-семестр'       => ['Семестр №3'],
        '2й-семестр'       => ['Семестр №2'],
        '1й-семестр'       => ['Семестр №1'],
        'Архив'            => ['Архив'],
        'Книги (Учебники)' => ['Книги']
    ];

    protected $words = [
        'кратко'        => 'Краткий',
        'спый'          => 'СПО',
        'год'           => null,
        'весь'          => null,
        'колотье'       => 'Колотий',
        'глава'         => null,
        'fixed'         => null,
        '5_0_170_04'    => null,
        'ioproc'        => ['IO', 'Процедура', 'Input', 'Output', 'Ассемблер'],
        'физик'         => 'Физика',
        'winapi'        => ['Windows', 'API'],
        'статистик'     => 'Статистика',
        'книга'         => 'Книги',
        'чм'            => ['Численный', 'Метод'],
        'кубановедение' => ['История', 'Кубань'],
        'вержбицкия'    => 'Вержбицкий',
        'гортинский'    => 'Гортинская',
        'бессараб'      => 'Бессарабов',
        'самарския'      => 'Самарский',
        'практик'       => 'Практика',
        'html'          => 'HTML',
        'css'           => 'CSS',
        'php'           => ['PHP', 'Hypertext Preprocessor'],
        'js'            => ['JavaScript', 'JS'],
        'oraclebd'      => ['Бессарабов', 'Oracle', 'Database', 'DB', 'База', 'Данный'],
        'математик'     => 'Математика',
        'методичок'     => ['Методический', 'Пособие'],
        'умф'           => ['УМФ', 'Уравнение', 'Математический', 'Физика'],
    ];

    protected $site = 'https://fktpm.ru';

    protected $tasks = [
        'files',
        'tags'
    ];

    protected function downloadFile($from, $name, $type)
    {
        $file = File::query()
            ->where('hash', basename($from))
            ->first();

        if (!$file)
        {

            $random = Str::random();
            $path   = PathBuilder::sharedInstance()
                    ->hash($random) . '/' . $random . '.' . $type;

            $to = \Storage::disk('admin')->path(
                $path
            );

            Dir::make(dirname($to));

            Stream::download($from, $to);

            if (!\Storage::disk('admin')->exists($path))
            {
                $this->error('Error of loading of the file');

                return;
            }

            $file = new File();

            $file->title = $name;
            $file->file  = $path;
            $file->hash  = basename($from);

            $file->save();

            $this->info('The file is successfully loaded');
        }

        $file->attachTags($this->tags[$this->key]);
        $file->save();
    }

    /**
     * @return \Bavix\AdvancedHtmlDom\AdvancedHtmlDom
     */
    protected function dom()
    {
        return \bavix\AdvancedHtmlDom\fileGetHtml($this->site);
    }

    protected function files()
    {
        $dom = $this->dom();

        $panels = $dom->find('.col-md-4 .panel.lm-table');

        foreach ($panels as $panel)
        {
            $heading = $panel->find('.panel-heading .col-md-12');

            $this->key = PregMatch::first('~\n([\s\wа-яё()-]+) \<span~iu', $heading->innertext)
                             ->matches[1];

            $this->info('found block: ' . $this->key);

            $links = $panel->find('.panel-body a');

            foreach ($links as $link)
            {
                $attributes = $link->attributes();

                $name = $link->text();
                $href = $attributes['href'];
                $type = $attributes['type'];

                $this->warn(
                    'There is a loading of the file `' . $name .
                    '` from ' . $this->site . $href
                );

                $this->downloadFile($this->site . $href, $name, $type);
            }

        }
    }

    protected function tags()
    {
        /**
         * @var File $file
         */
        foreach (File::all() as $file)
        {
            $tags = keywords($file->title, true);

            $tags = Arr::filter($tags, function ($tag) {
                return !is_numeric($tag) && mb_strlen($tag) > 2;
            });

            $morphies = [
                new \vladkolodka\phpMorphy\Morphy('en'),
                new \vladkolodka\phpMorphy\Morphy('ru'),
            ];

            $tags = Arr::map($tags, function ($tag) use ($morphies) {

                if (is_numeric($tag))
                {
                    return $tag;
                }

                $lang = (int)!PregMatch::first('~[a-z]~i', $tag)->result;

                /**
                 * @var \vladkolodka\phpMorphy\Morphy $morphy
                 */
                $morphy = $morphies[$lang];

                $upper  = Str::upp($tag);
                $result = $morphy->getBaseForm($upper);

                if (\is_array($result))
                {
                    $result = $result[0];
                }

                if ($result)
                {
                    $lower = Str::low($result);
                    $tag   = $upper === $tag ?
                        $result : Str::ucFirst($lower);
                }

                if (Arr::keyExists($this->words, Str::low($tag)))
                {
                    return $this->words[Str::low($tag)];
                }

                return $tag;
            });

            $_tags = [];

            Arr::walkRecursive($tags, function ($tag) use (&$_tags) {
                $_tags[] = $tag;
            });

            $_tags = array_filter($_tags);
            $_tags = array_unique($_tags);

            $file->syncTags($_tags);
        }
    }

    public function handle()
    {
        $task = $this->argument('task');

        if (!Arr::in($this->tasks, $task))
        {
            $this->error('Task not found!');

            return;
        }

        $this->{$task}();
    }

}
