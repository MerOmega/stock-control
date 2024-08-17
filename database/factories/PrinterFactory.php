<?php

namespace Database\Factories;

use App\Models\Printer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Printer>
 */
class PrinterFactory extends BaseDeviceFactory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'toner'      => $this->faker->word(),
            'toner_code' => $this->faker->unique()->bothify('TNR-####'),
        ];
    }

    public function configure(): Factory|PrinterFactory
    {
        return $this->afterCreating(function (Printer $printer) {
            $this->createDevice($printer);
        });
    }
}
