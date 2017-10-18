<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (['pages', 'albums', 'polls', 'posts', 'links', 'counters', 'notifies', 'types'] as $item)
        {
            Schema::table($item, function (Blueprint $table) {
                $table->boolean('active')
                    ->default(0)
                    ->change();
            });
        }

        Schema::table('pages', function (Blueprint $table) {
            $table->boolean('main_page')
                ->default(0)
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // todo
    }
}
