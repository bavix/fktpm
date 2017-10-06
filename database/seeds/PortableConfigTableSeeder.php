<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Schema;

class PortableConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * @var $config Builder
         */
        $config = DB::table('configs');

        /**
         * @var $admin Builder
         */
        $admin = DB::table('admin_config');

        $data = $config
            ->select(['name', 'value'])
            ->get()
            ->all();

        foreach ($data as $key => $datum)
        {
            $datum          = (array)$datum;
            $datum['value'] = \Bavix\Helpers\JSON::decode($datum['value']);
            $data[$key]     = $datum;
        }

        $admin->truncate();
        $admin->insert($data);

        Schema::drop('configs');
    }
}
