<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowingsTable extends Migration
{

    /**
     * @var array
     */
    protected $followings = [
        'фктипм',
        'фктипмкубгу',
        'кубгуфпм',
        'кубгу',
        'kubsu',
        'veresk_art_krd',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('followings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->timestamps();
        });

        $followings = [];
        foreach (array_unique($this->followings) as $name) {
            $followings[] = compact('name');
        }

        \Illuminate\Support\Facades\DB::table('followings')
            ->insert($followings);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('followings');
    }

}
