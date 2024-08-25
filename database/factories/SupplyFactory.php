<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Nette\Utils\Random;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supply>
 */
class SupplyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'         => $this->faker->name(),
            'category_id'  => Category::find(Random::generate(1, 10)),
            'quantity'     => $this->faker->randomNumber(),
            'description'  => $this->faker->text(),
            'observations' => $this->faker->text(),
        ];
    }
}
