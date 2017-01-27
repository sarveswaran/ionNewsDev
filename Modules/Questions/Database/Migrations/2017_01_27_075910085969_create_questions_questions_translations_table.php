<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsQuestionsTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions__questions_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->integer('questions_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['questions_id', 'locale']);
            $table->foreign('questions_id')->references('id')->on('questions__questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questions__questions_translations', function (Blueprint $table) {
            $table->dropForeign(['questions_id']);
        });
        Schema::dropIfExists('questions__questions_translations');
    }
}
