<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('votes',function(Blueprint $table){
            $table->increments('id');
            $table->integer('post_id')->unsigned();
            $table->string('type', 128)->nullable();
            $table->integer('object_id')->unsigned();
            $table->string('object_type', 128);
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
        Schema::drop('votes');
    }
}
