<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Sector;
use App\State;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Device>
 */
class DeviceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sku'        => $this->faker->unique()->numerify('SKU-#####'),
            'entry_year' => $this->faker->dateTimeThisDecade(),
            'state'      => $this->faker->randomElement(State::cases())->value,
            'brand_id'   => Brand::factory(),
            'sector_id'  => Sector::factory(),
        ];
    }
}
