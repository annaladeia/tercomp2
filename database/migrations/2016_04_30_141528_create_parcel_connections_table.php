<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParcelConnectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parcel_connections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parcel_id');
            $table->integer('proprietor_id');
            $table->integer('reference_id');
            $table->tinyInteger('orientation');
            $table->string('comments');
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
        Schema::drop('parcel_connections');
    }
}
