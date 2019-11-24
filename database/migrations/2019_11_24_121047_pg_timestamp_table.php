<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PgTimestampTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('admin_config');
        Schema::dropIfExists('admin_menu');
        Schema::dropIfExists('admin_operation_log');
        Schema::dropIfExists('admin_permissions');
        Schema::dropIfExists('admin_role_menu');
        Schema::dropIfExists('admin_role_permissions');
        Schema::dropIfExists('admin_role_users');
        Schema::dropIfExists('admin_roles');
        Schema::dropIfExists('admin_user_permissions');
        Schema::dropIfExists('admin_users');
        Schema::dropIfExists('notifies');

        $tables = [
            'categories',
            'counters',
            'couples',
            'departments',
            'downloads',
            'faculties',
            'files',
            'images',
            'links',
            'posts',
            'professors',
            'tags',
            'users',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dateTime('created_at')->nullable()->change();
                $table->dateTime('updated_at')->nullable()->change();
            });
        }

        Schema::table('password_resets', function (Blueprint $table) {
            $table->dateTime('created_at')->nullable()->change();
        });
    }

}
