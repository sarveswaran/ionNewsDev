<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestinomialsTestinomialsTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('testinomials__testinomials_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->integer('testinomials_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['testinomials_id', 'locale']);
            $table->foreign('testinomials_id')->references('id')->on('testinomials__testinomials')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('testinomials__testinomials_translations', function (Blueprint $table) {
            $table->dropForeign(['testinomials_id']);
        });
        Schema::dropIfExists('testinomials__testinomials_translations');
    }
}
