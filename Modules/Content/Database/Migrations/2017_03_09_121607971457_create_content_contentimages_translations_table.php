<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentContentImagesTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content__images_trans', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->integer('contentimages_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['contentimages_id', 'locale']);
            $table->foreign('contentimages_id')->references('id')->on('content__contentimages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('content__contentimages_translations', function (Blueprint $table) {
            $table->dropForeign(['contentimages_id']);
        });
        Schema::dropIfExists('content__contentimages_translations');
    }
}
