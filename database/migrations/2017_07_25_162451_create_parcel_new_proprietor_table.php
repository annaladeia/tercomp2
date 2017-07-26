<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParcelNewProprietorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parcel_mutation_proprietor', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parcel_mutation_id');
            $table->integer('proprietor_id');
            $table->timestamps();
        });
        
        Schema::create('parcel_mutations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parcel_id');
            $table->integer('parcel_mutation_proprietor_id')->unsigned()->nullable();
            $table->integer('year');
            $table->integer('month');
            $table->integer('day');
            $table->text('share');
            $table->text('reason');
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
        Schema::drop('parcel_mutation_proprietor');
        Schema::drop('parcel_mutations');
    }
}
