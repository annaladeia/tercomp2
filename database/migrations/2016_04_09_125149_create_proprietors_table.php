<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProprietorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proprietors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('first_name');
            $table->string('nickname');
            $table->string('residence');
            $table->string('occupation');
            $table->text('comments');
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
        Schema::drop('proprietors');
    }
}
