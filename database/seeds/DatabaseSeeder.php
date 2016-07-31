<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $relations = ['frère', 'fils', 'fille', 'père', 'épouse', 'mari', 'veuve', 'héritier', 'gendre', 'jeune fils', 'jeune fille', 'sœur', 'mère', 'héritiers', 'neveu', 'nièce', 'beaufils'];
        
        foreach ($relations as $relation)
            DB::table('family_relations')->insert(['name' => $relation]);
        
        $types = ['Bassecourt', 'Bois', 'Borde', 'Boutique', 'Boutique de forge', 'Cantier', 'Causses', 'Chay', 'Château', 'Chenerier', 'Colombier', 'Garenne', 'Grange', 'Jardin', 'Maison', 'Métérie', 'Moulin à vent', 'Partie de maison', 'Patus', 'Pesquier', 'Pigeonnier', 'Plantier', 'Pré', 'Sol', 'Terre', 'Tuillerie', 'Verger', 'Vigne', 'Vignette'];
        
        foreach ($types as $type)
            DB::table('parcel_types')->insert(['name' => $type]);
    }
}
