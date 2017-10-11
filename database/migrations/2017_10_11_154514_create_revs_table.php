<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRevsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revs', function (Blueprint $table) {
            $table->increments('id');

            $table->binary('patch'); // diff results
            $table->string('name'); // table name ($model->getTable())
            $table->string('column'); // table name ($model->getTable())
            $table->integer('item_id'); // id content message
            $table->integer('admin_id'); // id content message

            $table->timestamp('created_at')
                ->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->index(['name', 'column', 'item_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('revs');
    }
}
