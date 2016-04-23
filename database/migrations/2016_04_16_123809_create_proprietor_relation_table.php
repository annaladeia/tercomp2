<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProprietorRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proprietor_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('proprietor_id')->unsigned();
            $table->integer('related_proprietor_id')->unsigned();
            $table->integer('family_relation_id')->unsigned();
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
        Schema::drop('proprietor_relation');
    }
}
