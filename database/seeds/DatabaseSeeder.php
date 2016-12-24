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
        $relations = array(
            [1, 'frère', 'sœur', 1],
            [2, 'fils', 'fille', 3],
            [3, 'père', 'mère',  2],
            [4, 'mari', 'épouse', 4],
            [5, 'grand-père', 'grand-mère', 6],
            [6, 'petit-fils', 'petite-fille', 5],
            [7, 'beau-père', 'belle-mère', 8],
            [8, 'beau-fils', 'belle-fille', 7],
            [9, 'oncle', 'tante', 10],
            [10, 'neveu', 'nièce', 9],
            [11, 'cousin', 'cousine', 11],
            [12, 'beau-frère', 'belle-sœur', 12],
            [13, 'veuf', 'veuve', 14],
            [14, 'mari ✝', 'épouse ✝', 13],
            [15, 'héritier(s)', 'héritier(s)', null]
        );
        
        foreach ($relations as $relation)
            DB::table('family_relations')->insert(['id' => $relation[0], 'name_masc' => $relation[1], 'name_fem' => $relation[2], 'opposite_id' => $relation[3]]);
        
        $types = ['Bassecourt', 'Bois', 'Borde', 'Boutique', 'Boutique de forge', 'Cantier', 'Causses', 'Chay', 'Château', 'Chenerier', 'Colombier', 'Garenne', 'Grange', 'Jardin', 'Maison', 'Métérie', 'Moulin à vent', 'Partie de maison', 'Patus', 'Pesquier', 'Pigeonnier', 'Plantier', 'Pré', 'Sol', 'Terre', 'Tuillerie', 'Verger', 'Vigne', 'Vignette'];
        
        foreach ($types as $type)
            DB::table('parcel_types')->insert(['name' => $type]);
    }
}
