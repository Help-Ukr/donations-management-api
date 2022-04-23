<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ItemCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('item_categories')->truncate();

        \DB::table('item_categories')->insert([
            [ 'id' => 1, 'parent_id' => NULL, 'icon' => "🍜🥫🥔🥕", 'name' => "Lebensmittel" ],
            [ 'id' => 2, 'parent_id' => NULL, 'icon' => "🪥🧻", 'name' => "Hygieneartikel" ],
            [ 'id' => 3, 'parent_id' => NULL, 'icon' => "👚👖", 'name' => "Textilien und Kleider" ],
            [ 'id' => 4, 'parent_id' => NULL, 'icon' => "🛏️🪑", 'name' => "Möbelstücke" ],
            [ 'id' => 5, 'parent_id' => NULL, 'icon' => "🔌🔦📟", 'name' => "Elektronik" ],
            [ 'id' => 6, 'parent_id' => NULL, 'icon' => "🥄🍴", 'name' => "Küchengeräte" ],
            [ 'id' => 7, 'parent_id' => NULL, 'icon' => "🍽️", 'name' => "Geschirr" ],
            [ 'id' => 8, 'parent_id' => NULL, 'icon' => "🏐🥊⛸️🏓", 'name' => "Sportartausrüstung" ],
            [ 'id' => 9, 'parent_id' => NULL, 'icon' => "🩺🚑🌡️", 'name' => "Medizinische Ausrüstung" ],
            [ 'id' => 10, 'parent_id' => NULL, 'icon' => "🛌", 'name' => "Matratzen" ],
            [ 'id' => 11, 'parent_id' => NULL, 'icon' => "💉💊", 'name' => "Medikamente" ],
            [ 'id' => 12, 'parent_id' => NULL, 'icon' => "🪖🦺🛡️", 'name' => "Militärausrüstung" ],
            [ 'id' => 13, 'parent_id' => NULL, 'icon' => "🗿🖨️", 'name' => "Großgeräte" ],
        ]);
    }
}