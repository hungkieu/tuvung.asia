<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuggestStructureCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suggest_structure_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->text('description')->nullable();;
            $table->string('name', 191)->nullable();;
            $table->string('image', 191)->nullable();;
            $table->text('content')->nullable();;
            $table->integer('parent_id')->nullable();;
            $table->integer('user_id')->nullable();;
            $table->text('pedigree')->nullable();;

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
        Schema::dropIfExists('suggest_structure_categories');
    }
}
