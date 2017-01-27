<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsVoteTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions__vote_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->integer('vote_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['vote_id', 'locale']);
            $table->foreign('vote_id')->references('id')->on('questions__votes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questions__vote_translations', function (Blueprint $table) {
            $table->dropForeign(['vote_id']);
        });
        Schema::dropIfExists('questions__vote_translations');
    }
}
