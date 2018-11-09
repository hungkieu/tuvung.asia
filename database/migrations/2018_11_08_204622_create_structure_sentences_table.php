<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStructureSentencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('structure_sentences', function (Blueprint $table) {
            $table->increments('id');
            $table->text('structure')->nullable();
            $table->text('description')->nullable();
            $table->text('examples')->nullable();
            $table->text('image')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('parent_id')->nullable();
            $table->text('pedigree')->nullable();
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('structure_sentences');
    }
}
