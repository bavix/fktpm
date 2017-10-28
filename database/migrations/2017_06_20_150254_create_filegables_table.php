<?php

use Illuminate\Support\Facades\Schema;
use Bavix\Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilegablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filegables', function (Blueprint $table) {
            $table->increments('id');
            $table->string('filegable_type');
            $table->integer('filegable_id');
            $table->integer('file_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('filegables');
    }
}
