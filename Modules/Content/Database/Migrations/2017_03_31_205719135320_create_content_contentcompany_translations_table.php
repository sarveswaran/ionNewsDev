<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentContentCompanyTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content__contentcompany_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->integer('contentcompany_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['contentcompany_id', 'locale']);
            $table->foreign('contentcompany_id')->references('id')->on('content__contentcompanies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('content__contentcompany_translations', function (Blueprint $table) {
            $table->dropForeign(['contentcompany_id']);
        });
        Schema::dropIfExists('content__contentcompany_translations');
    }
}
