<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('relations',function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_1')->unsigned();
            $table->foreign('user_1')->references('id')->on('users')->onDelete('cascade');
            $table->integer('user_2')->unsigned();
            $table->foreign('user_2')->references('id')->on('users')->onDelete('cascade');
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
        Schema::drop('relations');
    }
}
