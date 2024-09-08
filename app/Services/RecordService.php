<?php

namespace App\Services;

use App\Models\Device;
use App\Models\Supply;

class RecordService
{
    public function createRecord(Device|Supply $device, string $message, ?array $changes = null, ?array $original = null): void
    {
        $data = [
            'message' => $message,
            'changes' => $this->formatChanges($changes, $original),
        ];

        $device->record()->create([
            'data' => json_encode($data),
        ]);
    }

    private function formatChanges(?array $changes, ?array $original): array
    {
        $formatted = [];
        if ($changes && $original) {
            foreach ($changes as $key => $newValue) {
                if ($key !== 'updated_at') {
                    $oldValue = $original[$key] ?? null;
                    $formatted[] = [
                        'key'      => $key,
                        'oldValue' => $oldValue,
                        'newValue' => $newValue,
                    ];
                }
            }
        }
        return $formatted;
    }
}
