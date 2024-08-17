<?php

namespace Database\Factories;

use App\Models\Monitor;
use App\Models\Printer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Monitor>
 */
class MonitorFactory extends BaseDeviceFactory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'has_hdmi' => $this->faker->boolean(),
            'has_vga'  => $this->faker->boolean(),
            'has_dp'   => $this->faker->boolean(),
        ];
    }

    public function configure(): Factory|MonitorFactory
    {
        return $this->afterCreating(function (Monitor $monitor) {
            $this->createDevice($monitor);
        });
    }
}
