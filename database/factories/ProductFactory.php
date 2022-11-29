<?php

namespace Database\Factories;

use App\Models\Producer;
use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'image_link'=>'https://source.unsplash.com/random',
            'type_id' => Type::inRandomOrder()->value('id'),
            'producer_id' => Producer::inRandomOrder()->value('id'),
            'price' => $this->faker->numberBetween(10000, 1000000000),
            'description' => $this->faker->text(500),
        ];
    }
}
