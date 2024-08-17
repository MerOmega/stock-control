<?php

namespace Database\Factories;

use App\Models\PC;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PC>
 */
class PCFactory extends BaseDeviceFactory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

        ];
    }

    public function configure(): Factory|PCFactory
    {
        return $this->afterCreating(function (PC $pc) {
            $this->createDevice($pc);
        });
    }
}
