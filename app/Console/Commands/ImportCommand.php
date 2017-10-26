<?php

namespace App\Console\Commands;

use App\Models\Couple;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\File;
use App\Models\Professor;
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
        'самарския'     => 'Самарский',
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

    protected $couples = array(
        array('id' => '30', 'name' => 'Oracle'),
        array('id' => '33', 'name' => 'XML'),
        array('id' => '31', 'name' => 'Автоматизация бухгалтерского учёта'),
        array('id' => '24', 'name' => 'Администрирование локальных сетей'),
        array('id' => '19', 'name' => 'Алгебра и аналитическая геометрия'),
        array('id' => '15', 'name' => 'Базы данных'),
        array('id' => '29', 'name' => 'Базы знаний'),
        array('id' => '35', 'name' => 'Вариационное исчисление и ОУ'),
        array('id' => '12', 'name' => 'Д/С'),
        array('id' => '23', 'name' => 'Дискретная математика и математическая логика'),
        array('id' => '10', 'name' => 'Дискретное программирование'),
        array('id' => '3', 'name' => 'Дифференциальные уравнения'),
        array('id' => '2', 'name' => 'Иностранный язык'),
        array('id' => '4', 'name' => 'Комплексный анализ'),
        array('id' => '7', 'name' => 'Компьютерная графика (OpenGL)'),
        array('id' => '38', 'name' => 'Математическая экономика'),
        array('id' => '41', 'name' => 'Математические модели экологических, экономических и технических процессов'),
        array('id' => '22', 'name' => 'Математический анализ'),
        array('id' => '26', 'name' => 'Методы оптимизации'),
        array('id' => '36', 'name' => 'Многомерный анализ данных'),
        array('id' => '20', 'name' => 'Основы информатики'),
        array('id' => '32', 'name' => 'Основы механики в сплошной среде'),
        array('id' => '18', 'name' => 'Основы психологии и педагогики'),
        array('id' => '40', 'name' => 'Параллельные вычисления'),
        array('id' => '39', 'name' => 'ППО'),
        array('id' => '6', 'name' => 'Программирование в Windows'),
        array('id' => '27', 'name' => 'Программирование в СВП Delphi'),
        array('id' => '34', 'name' => 'Программирование на Java'),
        array('id' => '28', 'name' => 'Сети ЭВМ'),
        array('id' => '37', 'name' => 'Сеточные методы'),
        array('id' => '1', 'name' => 'Системное программное обеспечение'),
        array('id' => '11', 'name' => 'Теория вероятности и математическая статистика'),
        array('id' => '25', 'name' => 'Теория игр и исследование операций'),
        array('id' => '14', 'name' => 'Уравнения математической физики'),
        array('id' => '8', 'name' => 'Физика'),
        array('id' => '5', 'name' => 'Физическая культура'),
        array('id' => '17', 'name' => 'Физические основы построения ЭВМ'),
        array('id' => '13', 'name' => 'Функциональный анализ'),
        array('id' => '16', 'name' => 'Численные методы')
    );

    protected $departments = array(
        array('id' => '1', 'name' => 'Кафедра информационных технологий', 'abbreviated' => 'inftech', 'faculty_id' => '2'),
        array('id' => '2', 'name' => 'Kафедра математического моделирования', 'abbreviated' => 'mathmod', 'faculty_id' => '2'),
        array('id' => '3', 'name' => 'Кафедра вычислительных технологий', 'abbreviated' => 'kvt', 'faculty_id' => '2'),
        array('id' => '4', 'name' => 'Кафедра прикладной математики', 'abbreviated' => 'appmath', 'faculty_id' => '2'),
        array('id' => '5', 'name' => 'Kафедра интеллектуальных информационных систем', 'abbreviated' => 'hightech', 'faculty_id' => '2'),
        array('id' => '6', 'name' => 'Кафедра физического воспитания', 'abbreviated' => 'kaf_fv', 'faculty_id' => '18'),
        array('id' => '7', 'name' => 'Кафедра истории и культурологии', 'abbreviated' => 'kaf_histkult', 'faculty_id' => '18'),
        array('id' => '8', 'name' => 'Кафедра иностранных языков для естественных специальностей', 'abbreviated' => 'kaf_estspec', 'faculty_id' => '18'),
        array('id' => '9', 'name' => 'Кафедра иностранных языков для гуманитарных специальностей', 'abbreviated' => 'kaf_gumspec', 'faculty_id' => '18'),
        array('id' => '10', 'name' => 'Кафедра социальной психологии и социологии управления', 'abbreviated' => 'kaf_spasom', 'faculty_id' => '10')
    );

    protected $faculties = array(
        array('id' => '18', 'name' => 'Межфакультетские кафедры'),
        array('id' => '15', 'name' => 'Факультет архитектуры и дизайна'),
        array('id' => '5', 'name' => 'Факультет биологический'),
        array('id' => '6', 'name' => 'Факультет географический'),
        array('id' => '7', 'name' => 'Факультет геологический'),
        array('id' => '16', 'name' => 'Факультет журналистики'),
        array('id' => '11', 'name' => 'Факультет истории, социологии и международных отношений'),
        array('id' => '2', 'name' => 'Факультет компьютерных технологий и прикладной математики'),
        array('id' => '1', 'name' => 'Факультет математики и компьютерных наук'),
        array('id' => '17', 'name' => 'Факультет педагогики, психологии и коммуникативистики'),
        array('id' => '13', 'name' => 'Факультет романо-германской филологии'),
        array('id' => '10', 'name' => 'Факультет управления и психологии'),
        array('id' => '3', 'name' => 'Факультет физико-технический'),
        array('id' => '12', 'name' => 'Факультет филологический'),
        array('id' => '4', 'name' => 'Факультет химии и высоких технологий'),
        array('id' => '14', 'name' => 'Факультет художественно-графический'),
        array('id' => '8', 'name' => 'Факультет экономический'),
        array('id' => '9', 'name' => 'Факультет юридический')
    );

    protected $professors = array(
        array('id' => '1', 'name' => 'Кольцов Юрий Владимирович', 'department_id' => '1', 'deleted' => '0', 'professorrating' => '46228'),
        array('id' => '2', 'name' => 'Гаркуша Олег Васильевич', 'department_id' => '1', 'deleted' => '0', 'professorrating' => '46206'),
        array('id' => '3', 'name' => 'Осипян Валерий Осипович', 'department_id' => '1', 'deleted' => '0', 'professorrating' => '46245'),
        array('id' => '4', 'name' => 'Подколзин Вадим Владиславович', 'department_id' => '1', 'deleted' => '0', 'professorrating' => '46248'),
        array('id' => '5', 'name' => 'Гарнага Валерий Владимирович', 'department_id' => '1', 'deleted' => '0', 'professorrating' => '0'),
        array('id' => '6', 'name' => 'Синица Сергей Геннадьевич', 'department_id' => '1', 'deleted' => '0', 'professorrating' => '0'),
        array('id' => '7', 'name' => 'Полупанов Алексей Александрович', 'department_id' => '1', 'deleted' => '0', 'professorrating' => '0'),
        array('id' => '8', 'name' => 'Лукащик Елена Павловна', 'department_id' => '1', 'deleted' => '0', 'professorrating' => '46237'),
        array('id' => '9', 'name' => 'Добровольская Наталья Юрьевна', 'department_id' => '1', 'deleted' => '0', 'professorrating' => '0'),
        array('id' => '10', 'name' => 'Харченко Анна Владимировна', 'department_id' => '1', 'deleted' => '0', 'professorrating' => '46266'),
        array('id' => '11', 'name' => 'Михайличенко Анна Александровна', 'department_id' => '1', 'deleted' => '0', 'professorrating' => '0'),
        array('id' => '12', 'name' => 'Уварова Анастасия Викторовна', 'department_id' => '1', 'deleted' => '0', 'professorrating' => '0'),
        array('id' => '13', 'name' => 'Бабешко Владимир Андреевич', 'department_id' => '2', 'deleted' => '0', 'professorrating' => '46199'),
        array('id' => '14', 'name' => 'Бессарабов Николай Васильевич', 'department_id' => '2', 'deleted' => '0', 'professorrating' => '46201'),
        array('id' => '15', 'name' => 'Капустин Михаил Сергеевич', 'department_id' => '2', 'deleted' => '0', 'professorrating' => '46221'),
        array('id' => '16', 'name' => 'Павлова Алла Владимировна', 'department_id' => '2', 'deleted' => '0', 'professorrating' => '46246'),
        array('id' => '17', 'name' => 'Рубцов Сергей Евгеньевич', 'department_id' => '2', 'deleted' => '0', 'professorrating' => '46251'),
        array('id' => '18', 'name' => 'Сыромятников Павел Викторович', 'department_id' => '2', 'deleted' => '0', 'professorrating' => '0'),
        array('id' => '19', 'name' => 'Тажкенов Денис Альбертович', 'department_id' => '2', 'deleted' => '0', 'professorrating' => '0'),
        array('id' => '20', 'name' => 'Миков Александр Иванович', 'department_id' => '3', 'deleted' => '0', 'professorrating' => '0'),
        array('id' => '21', 'name' => 'Борисов Александр Николаевич', 'department_id' => '3', 'deleted' => '0', 'professorrating' => '0'),
        array('id' => '22', 'name' => 'Воробьев Всеволод Вадимович', 'department_id' => '3', 'deleted' => '0', 'professorrating' => '0'),
        array('id' => '23', 'name' => 'Глушков Евгений Викторович', 'department_id' => '3', 'deleted' => '0', 'professorrating' => '46209'),
        array('id' => '24', 'name' => 'Гортинская Виктория Викторовна', 'department_id' => '3', 'deleted' => '0', 'professorrating' => '46210'),
        array('id' => '25', 'name' => 'Данилов Евгений Александрович', 'department_id' => '3', 'deleted' => '0', 'professorrating' => '46212'),
        array('id' => '26', 'name' => 'Ерёмин Артем Александрович', 'department_id' => '3', 'deleted' => '0', 'professorrating' => '0'),
        array('id' => '27', 'name' => 'Ермоленко Сергей Сергеевич', 'department_id' => '3', 'deleted' => '0', 'professorrating' => '0'),
        array('id' => '28', 'name' => 'Кособуцкая Екатерина Владимировна', 'department_id' => '3', 'deleted' => '0', 'professorrating' => '46229'),
        array('id' => '29', 'name' => 'Кузнецова Вероника Владимировна', 'department_id' => '3', 'deleted' => '0', 'professorrating' => '0'),
        array('id' => '30', 'name' => 'Лапина Ольга Николаевна', 'department_id' => '3', 'deleted' => '0', 'professorrating' => '46233'),
        array('id' => '31', 'name' => 'Малыхин Константин Владимирович', 'department_id' => '3', 'deleted' => '0', 'professorrating' => '46239'),
        array('id' => '32', 'name' => 'Моспан Надежда Вадимовна', 'department_id' => '3', 'deleted' => '0', 'professorrating' => '0'),
        array('id' => '33', 'name' => 'Пекшева Марина Владимировна', 'department_id' => '3', 'deleted' => '0', 'professorrating' => '0'),
        array('id' => '34', 'name' => 'Фоменко Сергей Иванович', 'department_id' => '3', 'deleted' => '0', 'professorrating' => '0'),
        array('id' => '35', 'name' => 'Храмцова Виктория Викторовна', 'department_id' => '3', 'deleted' => '0', 'professorrating' => '0'),
        array('id' => '36', 'name' => 'Черных Наталья Михайловна', 'department_id' => '3', 'deleted' => '0', 'professorrating' => '46272'),
        array('id' => '37', 'name' => 'Уртенов Махамет Али Хусеевич', 'department_id' => '4', 'deleted' => '0', 'professorrating' => '46263'),
        array('id' => '38', 'name' => 'Казаковцева Екатерина Васильевна', 'department_id' => '4', 'deleted' => '0', 'professorrating' => '0'),
        array('id' => '39', 'name' => 'Калайдина Галина Вениаминовна', 'department_id' => '4', 'deleted' => '0', 'professorrating' => '0'),
        array('id' => '40', 'name' => 'Кармазин Владимир Николаевич', 'department_id' => '4', 'deleted' => '0', 'professorrating' => '46222'),
        array('id' => '41', 'name' => 'Коваленко Анна Владимировна', 'department_id' => '4', 'deleted' => '0', 'professorrating' => '46226'),
        array('id' => '42', 'name' => 'Колотий Александр Дмитриевич', 'department_id' => '4', 'deleted' => '0', 'professorrating' => '46227'),
        array('id' => '43', 'name' => 'Лебедев Константин Андреевич', 'department_id' => '4', 'deleted' => '0', 'professorrating' => '46234'),
        array('id' => '44', 'name' => 'Письменский Александр Владимирович', 'department_id' => '4', 'deleted' => '0', 'professorrating' => '46247'),
        array('id' => '45', 'name' => 'Сеидова Наталья Михайловна', 'department_id' => '4', 'deleted' => '0', 'professorrating' => '46255'),
        array('id' => '46', 'name' => 'Халафян Алексан Альбертович', 'department_id' => '4', 'deleted' => '0', 'professorrating' => '46264'),
        array('id' => '47', 'name' => 'Шаповаленко Василий Всеволодович', 'department_id' => '4', 'deleted' => '0', 'professorrating' => '46274'),
        array('id' => '48', 'name' => 'Юнов Сергей Владленович', 'department_id' => '4', 'deleted' => '0', 'professorrating' => '46276'),
        array('id' => '49', 'name' => 'Костенко Константин Иванович', 'department_id' => '5', 'deleted' => '0', 'professorrating' => '46230'),
        array('id' => '50', 'name' => 'Васильев Юрий Петрович', 'department_id' => '5', 'deleted' => '0', 'professorrating' => '46204'),
        array('id' => '51', 'name' => 'Грушко Галина Владимировна', 'department_id' => '5', 'deleted' => '0', 'professorrating' => '46211'),
        array('id' => '52', 'name' => 'Зарецкая Марина Валерьевна', 'department_id' => '5', 'deleted' => '0', 'professorrating' => '0'),
        array('id' => '53', 'name' => 'Лебедева Анастасия Павловна', 'department_id' => '5', 'deleted' => '0', 'professorrating' => '0'),
        array('id' => '54', 'name' => 'Мазин Василий Александрович', 'department_id' => '5', 'deleted' => '0', 'professorrating' => '46238'),
        array('id' => '55', 'name' => 'Пряхина Ольга Донатовна', 'department_id' => '5', 'deleted' => '0', 'professorrating' => '46250'),
        array('id' => '56', 'name' => 'Смирнова Алла Васильевна', 'department_id' => '5', 'deleted' => '0', 'professorrating' => '46257'),
        array('id' => '57', 'name' => 'Степаненко Евгений Антонович', 'department_id' => '5', 'deleted' => '0', 'professorrating' => '0'),
        array('id' => '58', 'name' => 'Стоян Владимир Петрович', 'department_id' => '5', 'deleted' => '0', 'professorrating' => '46260'),
        array('id' => '59', 'name' => 'Терешенков Владимир Александрович', 'department_id' => '5', 'deleted' => '0', 'professorrating' => '46261'),
        array('id' => '60', 'name' => 'Логинов Владимир Викторович', 'department_id' => '6', 'deleted' => '0', 'professorrating' => '0'),
        array('id' => '61', 'name' => 'Марьяненко Дарья Александровна', 'department_id' => '10', 'deleted' => '0', 'professorrating' => '0'),
        array('id' => '62', 'name' => 'Привал Данил Андреевич', 'department_id' => '2', 'deleted' => '0', 'professorrating' => '0'),
        array('id' => '63', 'name' => 'Пантелеева Алина Михайловна', 'department_id' => '1', 'deleted' => '0', 'professorrating' => '0'),
        array('id' => '64', 'name' => 'Белкин Виктор Юрьевич', 'department_id' => '5', 'deleted' => '0', 'professorrating' => '0')
    );

    protected $site = 'https://fktpm.ru';

    protected $tasks = [
        'professors',
        'couples',
        'files',
        'tags',
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

            $file->attachTags($_tags);
        }
    }

    protected function couples()
    {
        foreach ($this->couples as $couple)
        {
            $model = Couple::query()
                ->where('name', $couple['name'])
                ->first();

            if ($model)
            {
                $this->warn('Couple found: ' . $couple['name']);
                continue;
            }

            $model       = new Couple();
            $model->name = $couple['name'];
            $model->save();


            $this->info('Add couple: ' . $couple['name']);
        }
    }

    protected function faculties()
    {
        $this->info(__FUNCTION__);

        foreach ($this->faculties as $faculty)
        {
            $model = Faculty::query()
                ->where('name', $faculty['name'])
                ->first();

            if ($model)
            {
                $this->warn('Faculty found: ' . $faculty['name']);
                continue;
            }

            $model       = new Faculty();
            $model->name = $faculty['name'];
            $model->save();


            $this->info('Add faculty: ' . $faculty['name']);
        }
    }

    protected function departments()
    {
        $this->faculties();

        $this->info(__FUNCTION__);

        foreach ($this->departments as $department)
        {
            $model = Department::query()
                ->where('name', $department['name'])
                ->first();

            if ($model)
            {
                $this->warn('Department found: ' . $department['name']);
                continue;
            }

            $name = null;

            foreach ($this->faculties as $item)
            {
                /**
                 * @var $item array
                 */
                if ((int)$item['id'] === (int)$department['faculty_id'])
                {
                    $name = $item['name'];
                }
            }

            $faculty = Faculty::query()
                ->where('name', $name)
                ->first();

            if (!$faculty)
            {
                $this->warn('Faculty `' . $name . '` not found!');
                continue;
            }

            $model             = new Department();
            $model->name       = $department['name'];
            $model->faculty_id = $faculty->id;
            $model->save();

            $this->info('Add department: ' . $department['name']);
        }
    }

    protected function professors()
    {
        $this->departments();

        $this->info(__FUNCTION__);

        foreach ($this->professors as $professor)
        {
            list ($last, $first, $middle) = explode(' ', $professor['name'], 3);

            $model = Professor::query()
                ->where('last_name', $last)
                ->where('first_name', $first)
                ->where('middle_name', $middle)
                ->first();

            if ($model)
            {
                $this->warn('Professor found: ' . $professor['name']);
                continue;
            }

            $name = null;

            foreach ($this->departments as $item)
            {
                /**
                 * @var $item array
                 */
                if ((int)$item['id'] === (int)$professor['department_id'])
                {
                    $name = $item['name'];
                }
            }

            $department = Department::query()
                ->where('name', $name)
                ->first();

            if (!$department)
            {
                $this->warn('Department `' . $name . '` not found!');
                continue;
            }

            $model = new Professor();

            $model->last_name       = $last;
            $model->first_name      = $first;
            $model->middle_name     = $middle;
            $model->department_id   = $department->id;
            $model->professorrating = $professor['professorrating'] > 0 ? $professor['professorrating'] : null;
            $model->active          = (int)($professor['deleted'] === '0');

            $model->save();

            $this->info('Add professor: ' . $professor['name']);
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
