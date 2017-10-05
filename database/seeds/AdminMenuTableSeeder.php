<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;

class AdminMenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = array(
            array('id' => '1','parent_id' => '0','order' => '1','title' => 'Приборная панель','icon' => 'fa-bar-chart','uri' => '/','created_at' => NULL,'updated_at' => NULL),
            array('id' => '2','parent_id' => '0','order' => '16','title' => 'Admin','icon' => 'fa-tasks','uri' => '','created_at' => NULL,'updated_at' => '2017-07-05 15:32:01'),
            array('id' => '3','parent_id' => '2','order' => '17','title' => 'Users','icon' => 'fa-users','uri' => 'auth/users','created_at' => NULL,'updated_at' => '2017-07-05 15:32:01'),
            array('id' => '4','parent_id' => '2','order' => '18','title' => 'Roles','icon' => 'fa-user','uri' => 'auth/roles','created_at' => NULL,'updated_at' => '2017-07-05 15:32:01'),
            array('id' => '5','parent_id' => '2','order' => '19','title' => 'Permission','icon' => 'fa-user','uri' => 'auth/permissions','created_at' => NULL,'updated_at' => '2017-07-05 15:32:01'),
            array('id' => '6','parent_id' => '2','order' => '20','title' => 'Menu','icon' => 'fa-bars','uri' => 'auth/menu','created_at' => NULL,'updated_at' => '2017-07-05 15:32:01'),
            array('id' => '7','parent_id' => '2','order' => '21','title' => 'Operation log','icon' => 'fa-history','uri' => 'auth/logs','created_at' => NULL,'updated_at' => '2017-07-05 15:32:01'),
//            array('id' => '8','parent_id' => '0','order' => '25','title' => 'Helpers','icon' => 'fa-gears','uri' => '','created_at' => NULL,'updated_at' => '2017-07-05 15:32:01'),
//            array('id' => '9','parent_id' => '8','order' => '26','title' => 'Scaffold','icon' => 'fa-keyboard-o','uri' => 'helpers/scaffold','created_at' => NULL,'updated_at' => '2017-07-05 15:32:01'),
//            array('id' => '10','parent_id' => '8','order' => '27','title' => 'Database terminal','icon' => 'fa-database','uri' => 'helpers/terminal/database','created_at' => NULL,'updated_at' => '2017-07-05 15:32:01'),
//            array('id' => '11','parent_id' => '8','order' => '28','title' => 'Laravel artisan','icon' => 'fa-terminal','uri' => 'helpers/terminal/artisan','created_at' => NULL,'updated_at' => '2017-07-05 15:32:01'),
            array('id' => '12','parent_id' => '0','order' => '7','title' => 'Контент','icon' => 'fa-newspaper-o','uri' => '/posts','created_at' => NULL,'updated_at' => NULL),
            array('id' => '13','parent_id' => '0','order' => '14','title' => 'Альбомы','icon' => 'fa-picture-o','uri' => '/albums','created_at' => NULL,'updated_at' => NULL),
            array('id' => '14','parent_id' => '0','order' => '11','title' => 'Опросник','icon' => 'fa-question-circle','uri' => '/polls','created_at' => NULL,'updated_at' => NULL),
            array('id' => '15','parent_id' => '0','order' => '3','title' => 'Подача заявлений','icon' => 'fa-user-plus','uri' => '/statements','created_at' => NULL,'updated_at' => NULL),
            array('id' => '16','parent_id' => '12','order' => '9','title' => 'Категории','icon' => 'fa-hashtag','uri' => '/categories','created_at' => NULL,'updated_at' => NULL),
            array('id' => '17','parent_id' => '15','order' => '5','title' => 'Кружки','icon' => 'fa-child','uri' => '/types','created_at' => NULL,'updated_at' => NULL),
            array('id' => '18','parent_id' => '15','order' => '4','title' => 'Заявления','icon' => 'fa-user-plus','uri' => '/statements','created_at' => NULL,'updated_at' => NULL),
            array('id' => '19','parent_id' => '12','order' => '8','title' => 'Посты','icon' => 'fa-newspaper-o','uri' => '/posts','created_at' => NULL,'updated_at' => NULL),
            array('id' => '20','parent_id' => '0','order' => '2','title' => 'Ссылки','icon' => 'fa-link','uri' => '/links','created_at' => NULL,'updated_at' => NULL),
            array('id' => '21','parent_id' => '14','order' => '12','title' => 'Опросы','icon' => 'fa-area-chart','uri' => '/polls','created_at' => NULL,'updated_at' => NULL),
            array('id' => '22','parent_id' => '14','order' => '13','title' => 'Вопросы','icon' => 'fa-question-circle','uri' => '/questions','created_at' => NULL,'updated_at' => NULL),
            array('id' => '23','parent_id' => '12','order' => '10','title' => 'Страницы','icon' => 'fa-file-text','uri' => '/pages','created_at' => NULL,'updated_at' => NULL),
            array('id' => '24','parent_id' => '0','order' => '6','title' => 'Обратная связь','icon' => 'fa-feed','uri' => '/feedback','created_at' => NULL,'updated_at' => NULL),
            array('id' => '25','parent_id' => '2','order' => '22','title' => 'Конфигурации','icon' => 'fa-sliders','uri' => '/config','created_at' => NULL,'updated_at' => '2017-07-05 15:32:01'),
            array('id' => '26','parent_id' => '2','order' => '23','title' => 'Счётчики','icon' => 'fa-area-chart','uri' => '/counters','created_at' => NULL,'updated_at' => '2017-07-05 15:32:01'),
            array('id' => '27','parent_id' => '2','order' => '24','title' => 'Трекер','icon' => 'fa-bar-chart','uri' => '/trackers','created_at' => NULL,'updated_at' => '2017-07-05 15:32:01'),
            array('id' => '28','parent_id' => '0','order' => '15','title' => 'Уведомления','icon' => 'fa-bell','uri' => '/notifies','created_at' => '2017-07-05 15:31:54','updated_at' => '2017-07-05 15:32:01')
        );

        /**
         * @var $builder Builder
         */
        $builder = DB::table('admin_menu');
        $builder->truncate();
        $builder->insert($array);
    }
}
