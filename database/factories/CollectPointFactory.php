<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CollectPoint>
 */
class CollectPointFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'phone' => $this->faker->e164PhoneNumber(),
            'telegram' => str_replace('-', '_', '@' . $this->faker->slug(3)),
            'image' => $this->faker->imageUrl(640, 480, 'animals', true),
            'location' => [
                'address' => $this->faker->address(),
                'latitude' => $this->faker->latitude(),
                'longitude' => $this->faker->longitude(),
            ],
            'available_items' => $this->getAvailableItems(),
            'needed_items' => $this->getNeededItems(),
        ];
    }

    private function getNeededItems()
    {
        $i = rand(1, 3);
        $result = [];

        while($i > 0){
            $result[] = ['item_category_id' => rand(0, 10)];
            $i--;
        }

        return $result;
    }

    private function getAvailableItems()
    {
        $i = rand(1, 3);
        $result = [];

        while($i > 0){
            $result[] = [
                'item_category_id' => rand(0, 10),
                'quantity' => rand(0, 100),
            ];
            $i--;
        }

        return $result;
    }
}
