<?php

namespace Database\Factories;

use App\Models\Device;
use App\Models\Printer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
abstract class BaseDeviceFactory extends Factory
{
    protected function createDevice($model): void
    {
        $device = Device::factory()->create([
            'deviceable_type' => get_class($model),
            'deviceable_id'   => $model->id,
        ]);

        $model->setRelation('device', $device);
    }
}
