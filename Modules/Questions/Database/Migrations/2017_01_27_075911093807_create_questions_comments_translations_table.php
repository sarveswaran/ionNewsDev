<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsCommentsTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions__comments_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->integer('comments_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['comments_id', 'locale']);
            $table->foreign('comments_id')->references('id')->on('questions__comments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questions__comments_translations', function (Blueprint $table) {
            $table->dropForeign(['comments_id']);
        });
        Schema::dropIfExists('questions__comments_translations');
    }
}
