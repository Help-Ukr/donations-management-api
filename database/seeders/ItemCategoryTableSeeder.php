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
            [ 'id' => 1, 'parent_id' => NULL, 'icon' => "🪥🧻", 'name' => "Hygieneartikel" ],
            [ 'id' => 1, 'parent_id' => NULL, 'icon' => "👚👖", 'name' => "Textilien und Kleider" ],
            [ 'id' => 1, 'parent_id' => NULL, 'icon' => "🛏️🪑", 'name' => "Möbelstücke" ],
            [ 'id' => 1, 'parent_id' => NULL, 'icon' => "🔌🔦📟", 'name' => "Elektronik" ],
            [ 'id' => 1, 'parent_id' => NULL, 'icon' => "🥄🍴", 'name' => "Küchengeräte" ],
            [ 'id' => 1, 'parent_id' => NULL, 'icon' => "🍽️", 'name' => "Geschirr" ],
            [ 'id' => 1, 'parent_id' => NULL, 'icon' => "🏐🥊⛸️🏓", 'name' => "Sportartausrüstung" ],
            [ 'id' => 1, 'parent_id' => NULL, 'icon' => "🩺🚑🌡️", 'name' => "Medizinische Ausrüstung" ],
            [ 'id' => 1, 'parent_id' => NULL, 'icon' => "🛌", 'name' => "Matratzen" ],
            [ 'id' => 1, 'parent_id' => NULL, 'icon' => "💉💊", 'name' => "Medikamente" ],
            [ 'id' => 1, 'parent_id' => NULL, 'icon' => "🪖🦺🛡️", 'name' => "Militärausrüstung" ],
            [ 'id' => 1, 'parent_id' => NULL, 'icon' => "🗿🖨️", 'name' => "Großgeräte" ],
        ]);
    }
}