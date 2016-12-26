<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Proprietor;
use App\Profession;


class MigrateProfessions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (Proprietor::get() as $p) {
            $occupation = trim($p->occupation);
            if ($occupation) {
                
                foreach (Profession::where('name', $occupation)->get() as $profession) {
                    $professionID = $profession->id;
                }
                
                if (! isset($professionID)) {
                    $profession = new Profession;
                    $profession->name = $occupation;
                    $profession->save();
                    $professionID = $profession->id;
                }
                
                if (isset($professionID)) {
                    $p->professions()->sync([$professionID]);
                }
                
            }
        }
        
        Schema::table('proprietors', function($table) {
            $table->dropColumn('occupation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proprietors', function($table) {
            $table->string('occupation');
        });
    }
}
