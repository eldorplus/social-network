<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFriendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('friends',function(Blueprint $table){
            $table->increments('id');
            $table->integer('user1_id')->unsigned();
            $table->foreign('user1_id')->references('id')->on('users');
            $table->integer('user2_id')->unsigned();
            $table->foreign('user2_id')->references('id')->on('users');
            $table->boolean('is_accepted')->default(false);
            $table->integer('invited_by')->unsigned();
            $table->foreign('invited_by')->references('id')->on('users');
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
        Schema::drop('friends');
    }
}
