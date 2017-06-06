<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('documents')) {
        
            Schema::create('documents', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->integer('year');
                $table->tinyInteger('type');
                $table->timestamps();
            });
        }
        
        $insertID = DB::table('documents')->insertGetId([
            'type' => 1
        ]);
        
        if (!Schema::hasColumn('parcels', 'document_id')) {
        
            Schema::table('parcels', function (Blueprint $table) {
                $table->integer('document_id');
            });   
        }
        
        if (!Schema::hasColumn('proprietors', 'document_id')) {
        
            Schema::table('proprietors', function (Blueprint $table) {
                $table->integer('document_id');
            });
        }
        
        DB::table('proprietors')->update(['document_id' => $insertID]);
        DB::table('parcels')->update(['document_id' => $insertID]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proprietors', function (Blueprint $table) {
            $table->dropColumn('document_id');
        });
        
        Schema::table('parcels', function (Blueprint $table) {
            $table->dropColumn('document_id');
        });
        
        Schema::drop('documents');
    }
}
