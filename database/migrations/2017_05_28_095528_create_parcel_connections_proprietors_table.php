<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParcelConnectionsProprietorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parcel_connection_proprietor', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parcel_connection_id');
            $table->integer('proprietor_id');
            $table->timestamps();
        });
        
        $results = DB::table('parcel_connections')->select('id', 'proprietor_id')->get();
        
        Schema::table('parcel_connections', function (Blueprint $table) {
            $table->integer('parcel_connection_proprietor_id')->unsigned()->nullable();
            $table->dropColumn('proprietor_id');
        });
        
        foreach ($results as $r) {
            if ($r->proprietor_id) {
                
                $insertID = DB::table('parcel_connection_proprietor')->insertGetId([
                    'parcel_connection_id' => $r->id,
                    'proprietor_id' => $r->proprietor_id
                ]);
                
                DB::table('parcel_connections')->where('id', $r->id)->update([
                    'parcel_connection_proprietor_id' => $insertID
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('parcel_connections', function (Blueprint $table) {
            $table->dropColumn('parcel_connection_proprietor_id');
            $table->integer('proprietor_id')->unsigned()->nullable();
        });
        
        Schema::drop('parcel_connection_proprietor');
    }
}
