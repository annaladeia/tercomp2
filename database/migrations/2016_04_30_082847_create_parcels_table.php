<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParcelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parcels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('page_number');
            $table->tinyInteger('front');
            $table->integer('parcel_number');
            $table->double('canne', 15, 8);
            $table->double('coup', 15, 8);
            $table->double('pugnerade', 15, 8);
            $table->double('seteree', 15, 8);
            $table->double('denier', 15, 8);
            $table->double('sous', 15, 8);
            $table->double('livre', 15, 8);
            $table->string('canne_input');
            $table->string('coup_input');
            $table->string('pugnerade_input');
            $table->string('seteree_input');
            $table->string('denier_input');
            $table->string('sous_input');
            $table->string('livre_input');
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
        Schema::drop('parcels');
    }
}
