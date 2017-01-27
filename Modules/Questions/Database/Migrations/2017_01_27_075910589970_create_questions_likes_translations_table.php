<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsLikesTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions__likes_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->integer('likes_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['likes_id', 'locale']);
            $table->foreign('likes_id')->references('id')->on('questions__likes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questions__likes_translations', function (Blueprint $table) {
            $table->dropForeign(['likes_id']);
        });
        Schema::dropIfExists('questions__likes_translations');
    }
}
