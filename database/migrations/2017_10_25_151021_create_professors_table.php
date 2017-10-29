<?php

use Bavix\Illuminate\Support\Facades\Schema;
use Bavix\Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfessorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professors', function (Blueprint $table) {
            $table->increments('id');

            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name');

            $table->integer('professorrating')->nullable();

            $table->integer('department_id');
            $table->integer('active')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('professors');
    }
}
