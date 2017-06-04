<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUncertainToParcelConnectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parcel_connections', function (Blueprint $table) {
            $table->tinyInteger('uncertain')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('parcel_connections', function (Blueprint $table) {
            $table->dropColumn('uncertain');
        });
    }
}
