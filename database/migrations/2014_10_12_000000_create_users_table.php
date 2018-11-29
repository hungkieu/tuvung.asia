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
            $table->string('name', 191);
            $table->string('email', 191)->unique();
            $table->string('password', 191);
            $table->string('avatar', 191)->default('/images/avatar_default.png');
            $table->string('fullname')->nullable();
            $table->date('birthday')->nullable();
            $table->integer('gender')->default(0);
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->text('description')->nullable();
            $table->integer('role')->default('0');
            $table->integer('target_score')->default(0);
            $table->integer('score')->default(0);
            $table->datetime('last_login')->nullable();
            $table->boolean('is_newbie')->default(true);
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
        Schema::dropIfExists('users');
    }
}
