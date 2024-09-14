<?php

namespace App\Services;

use App\Models\Device;
use App\Models\Supply;
use Illuminate\Http\JsonResponse;

readonly class DeviceService
{
    public function __construct(protected RecordService $recordService)
    {
    }

    /**
     * Update the quantity of a supply in a device attaching it in case it doesn't exist or updating it if it does and
     * recording the changes in the record table of each
     *
     * @param Device $device
     * @param Supply $supply
     * @param int $quantity
     * @return JsonResponse
     */
    public function updateSupply(Device $device, Supply $supply, int $quantity): JsonResponse
    {
        $existingSupply = $device->supplies()->where('supply_id', $supply->id)->first();
        $supplyQuantity = $supply->quantity;

        if ($existingSupply) {
            $currentDeviceQuantity = $existingSupply->pivot->quantity;
            $difference            = $quantity - $currentDeviceQuantity;

            if ($difference > 0) {
                if ($supply->quantity >= $difference) {
                    $device->supplies()->updateExistingPivot($supply->id, ['quantity' => $quantity]);

                    $original = ['quantity' => $supplyQuantity];
                    $changes  = ['quantity' => $supplyQuantity - $supply->decrement('quantity', $difference)];

                    $this->recordService->createRecord(
                        $supply, 'Insumo retirado hacia '.$device->sku.', cantidad retirada: '. $difference, $changes, $original);

                    $this->recordService->createRecord($device, 'Insumo agregado: '. $supply->name . ' cantidad retirada: '. $difference);
                } else {
                    return response()->json(['error' => true, 'message' => 'No hay suficientes insumos en el inventario.'], 400);
                }
            } elseif ($difference < 0) {
                $device->supplies()->updateExistingPivot($supply->id, ['quantity' => $quantity]);

                $original = ['quantity' => $supplyQuantity];
                $changes  = ['quantity' => $supplyQuantity - $supply->increment('quantity', abs($difference))];

                $this->recordService->createRecord(
                    $supply, 'Insumo devuelto: '. $supply->name . ' cantidad devuelta:'. abs($difference),
                    $changes, $original
                );
                $this->recordService->createRecord($device, 'Insumo devuelto: '. $supply->name . ' cantidad devuelta:'. abs($difference));
            }

            return response()->json(['success' => true]);
        }

        return response()->json(['error' => true, 'message' => 'Insumo no encontrado en este dispositivo.'], 404);
    }
}
