<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->string('archive');
            $table->string('code');
            $table->text('authors');
            $table->text('representatives');
            $table->text('comments');
            $table->string('year')->change();
        });   
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn('archive');
            $table->dropColumn('code');
            $table->dropColumn('authors');
            $table->dropColumn('representatives');
            $table->dropColumn('comments');
            $table->int('year')->change();
        });   
    }
}
