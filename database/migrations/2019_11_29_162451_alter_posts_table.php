<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPostsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', static function (Blueprint $table) {
            $table->string('user_name')
                ->nullable()
                ->after('instagram_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', static function (Blueprint $table) {
            $table->dropColumn('user_name');
        });
    }

}
