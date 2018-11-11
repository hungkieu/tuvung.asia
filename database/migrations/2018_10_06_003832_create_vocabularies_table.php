<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVocabulariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vocabularies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('en', 191)->nullable();
            $table->string('vi', 191)->nullable();
            $table->string('type', 191)->nullable();
            $table->string('image', 191)->nullable();
            $table->text('description')->nullable();
            $table->integer('parent_id')->default(0);
            $table->text('pedigree')->nullable();
            $table->datetime('last_practice')->nullable();
            $table->integer('user_id');
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
        Schema::dropIfExists('vocabularies');
    }
}
