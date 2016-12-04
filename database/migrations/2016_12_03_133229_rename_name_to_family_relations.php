<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameNameToFamilyRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('family_relations', function (Blueprint $table) {
            $table->renameColumn('name', 'name_masc');
            $table->string('name_fem');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('family_relations', function (Blueprint $table) {
            $table->renameColumn('name_masc', 'name');
            $table->dropColumn('name_fem');
        });
    }
}
