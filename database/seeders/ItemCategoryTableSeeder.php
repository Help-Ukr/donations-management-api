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
            [ 'id' => 1, 'icon' => "🦺", 'name' => "Military Vest" ],
            [ 'id' => 2, 'icon' => "🔋", 'name' => "Powerbank" ],
            [ 'id' => 3, 'icon' => "📳", 'name' => "Phone Chargers" ],
            [ 'id' => 4, 'icon' => "✨", 'name' => "AAA Batteries" ],
            [ 'id' => 5, 'icon' => "🩲", 'name' => "Thermo Underwear" ],
            [ 'id' => 6, 'icon' => "🔦", 'name' => "Flashlight" ],
        ]);
    }
}