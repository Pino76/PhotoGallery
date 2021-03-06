<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 128);
            $table->text('description')->nullable();
            $table->integer('album_id')->unsigned();
            $table->foreign('album_id')->on('albums')->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->string('img_path', 128);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('photos');
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    }
}
