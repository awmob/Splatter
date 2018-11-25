<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Following extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('following', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('user_id');
        $table->integer('following_user_id');
        $table->timestamps();
      });

      Schema::create('followers', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('user_id');
        $table->integer('follower_user_id');
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
        //
    }
}
