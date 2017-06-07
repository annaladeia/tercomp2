<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHeritierOppositeToFamilyRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('family_relations')->insert([
            'id' => 16,
            'name_masc' => 'donateur',
            'name_fem' => 'donatrice',
            'opposite_id' => 15
        ]);
        
        DB::table('family_relations')->where('id', 15)->update(['opposite_id' => 16]);
        
        $relations = DB::table('proprietor_relation')->where('family_relation_id', 15)->get();
        foreach ($relations as $r) {
            DB::table('proprietor_relation')->insert([
                'proprietor_id' => $r->related_proprietor_id,
                'related_proprietor_id' => $r->proprietor_id,
                'family_relation_id' => 16,
                'created_at' => $r->created_at,
                'updated_at' => $r->updated_at
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
