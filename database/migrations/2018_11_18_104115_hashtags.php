<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Hashtags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('hashtags', function (Blueprint $table) {
          $table->increments('id');
          $table->string('hashtag');
          $table->timestamps();
      });

      Schema::create('hashtagsplats', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('hashtag_id');
          $table->integer('splat_id');
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
        Schema::dropIfExists('hashtags');
        Schema::dropIfExists('hashtagsplats');
    }
}
