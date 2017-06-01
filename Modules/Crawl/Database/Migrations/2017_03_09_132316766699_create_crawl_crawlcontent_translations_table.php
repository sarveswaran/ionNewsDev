<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrawlCrawlContentTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crawl__crawlcontent_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->integer('crawlcontent_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['crawlcontent_id', 'locale']);
            $table->foreign('crawlcontent_id')->references('id')->on('crawl__crawlcontents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('crawl__crawlcontent_translations', function (Blueprint $table) {
            $table->dropForeign(['crawlcontent_id']);
        });
        Schema::dropIfExists('crawl__crawlcontent_translations');
    }
}
