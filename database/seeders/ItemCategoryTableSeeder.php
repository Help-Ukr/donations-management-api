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
            [ 'id' => 1, 'parent_id' => NULL, 'icon' => "🥼", 'name' => "Wear" ],
            [ 'id' => 2, 'parent_id' => NULL, 'icon' => "📟", 'name' => "Electronics" ],

            [ 'id' => 3, 'parent_id' => 1, 'icon' => "🦺", 'name' => "Military Vest" ],
            [ 'id' => 4, 'parent_id' => 1, 'icon' => "🩲", 'name' => "Thermo Underwear" ],

            [ 'id' => 5, 'parent_id' => 2, 'icon' => "🔋", 'name' => "Powerbank" ],
            [ 'id' => 6, 'parent_id' => 2, 'icon' => "📳", 'name' => "Phone Chargers" ],
            [ 'id' => 7, 'parent_id' => 2, 'icon' => "✨", 'name' => "AAA Batteries" ],
            [ 'id' => 8, 'parent_id' => 2, 'icon' => "🔦", 'name' => "Flashlight" ],
        ]);
    }
}