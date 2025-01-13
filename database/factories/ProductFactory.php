<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        $genres = [
            'Action',
            'Adventure',
            'Role-Playing Games (RPG)',
            'Simulation',
            'Strategy',
            'Sports',
            'Racing',
            'Puzzle',
            'Horror',
            'Platformer',
            'Shooter',
            'MMORPG (Massively Multiplayer Online RPG)',
            'Sandbox',
            'Fighting',
            'Idle Games',
            'Battle Royale',
            'Card Games',
            'Educational',
        ];

        return [
            'name' => $this->faker->word() . ' ' . $this->faker->word(),
            'price' => $this->faker->randomFloat(2, 10, 60),
            'genre' => $this->faker->randomElement($genres),
            'release_date' => $this->faker->date(),
        ];
    }
}

