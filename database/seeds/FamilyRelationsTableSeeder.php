<?php

use Illuminate\Database\Seeder;

class FamilyRelationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $relations = ['frère', 'fils', 'fille', 'père', 'épouse', 'mari', 'veuve', 'héritier', 'gendre', 'jeune fils', 'jeune fille', 'sœur', 'mère'];
        
        foreach ($relations as $relation)
            DB::table('family_relations')->insert(['name' => $relation]);
    }
}
