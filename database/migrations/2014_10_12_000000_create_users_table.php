<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('register_from')->default('web_form')->index();
            $table->integer('github_id')->index()->nullable(true);
            $table->string('github_name')->index()->nullable(true);
            $table->string('website')->nullable(true);
            $table->string('real_name')->nullable(true);
            $table->string('description')->nullable(true);
            $table->text('meta')->nullable(true);
            $table->string('avatar')->nullable(true);
            $table->string('profile_image')->nullable(true);
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
