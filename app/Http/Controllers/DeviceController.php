<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\Device;
use App\Models\Monitor;
use App\Models\PC;
use App\Models\Printer;
use App\Models\Sector;
use App\Models\Supply;
use App\Services\DeviceService;
use App\Services\RecordService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public static array $deviceTypes
        = [
            'pc'      => 'PC',
            'monitor' => 'Monitor',
            'printer' => 'Impresora',
        ];

    public function __construct(
        readonly RecordService $recordService,
        readonly DeviceService $deviceService
    )
    {
    }

    public function getDeviceRecord(Request $request, Device $device): View
    {
        $records = $device->record()->orderBy('created_at', 'desc')->paginate(Configuration::first()->default_per_page);
        return view('device.record', [
            'device'  => $device,
            'records' => $records,
        ]);
    }

    public function storeSupplies(Request $request): JsonResponse
    {
        $device = Device::find($request->input('device_id'));

        if (!$device) {
            return response()->json(['success' => false, 'message' => trans('messages.device.device_not_found')], 404);
        }

        $supplies = $request->input('supplies', []);

        foreach ($supplies as $supply) {
            $existingSupply = Supply::find($supply['id']);

            if (!$existingSupply) {
                return response()->json(['success' => false, 'message' => trans('messages.supply.supply_not_found')], 404);
            }

            $existingPivot = $device->supplies()->where('supply_id', $supply['id'])->first();

            if ($existingPivot) {
                $newQuantity = $existingPivot->pivot->quantity + $supply['quantity'];
                $device->supplies()->updateExistingPivot($supply['id'], ['quantity' => $newQuantity]);
            } else {
                $device->supplies()->attach($supply['id'], [
                    'quantity'   => $supply['quantity'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $existingSupply->quantity -= $supply['quantity'];
            $existingSupply->save();

            $this->recordService->createRecord($device, 'Insumo agregado '.$existingSupply->name.' cantidad: '. $supply['quantity']);
            $this->recordService->createRecord($existingSupply, 'Insumo agregado '. $device->sku . ' cantidad: '. $supply['quantity']);
        }

        return response()->json(['success' => true]);
    }

    // Method to remove a supply from the device
    public function removeSupply(Device $device, Supply $supply): JsonResponse
    {
        $existingSupply = $device->supplies()->where('supply_id', $supply->id)->first();
        $supplyQuantity = $supply->quantity;

        if (!$existingSupply) {
            return response()->json(['success' => false, 'message' => trans('message.device.supply_not_found')], 404);
        }

        $original = ['quantity' => $supplyQuantity];
        $changes  = ['quantity' => $supplyQuantity +
            $supply->increment('quantity', $existingSupply->pivot->quantity)
        ];

        $device->supplies()->detach($supply->id);

        $this->recordService->createRecord(
            $supply, 'Insumo eliminado de ' . $device->sku . ' cantidad devuelta: ' . $existingSupply->pivot->quantity,
            $changes, $original);

        $this->recordService->createRecord($device, 'Insumo devuelto: '. $supply->name . ' cantidad devuelta: '. $existingSupply->pivot->quantity);

        return response()->json(['success' => true]);
    }

    public function updateSupply(Request $request, Device $device, Supply $supply): JsonResponse
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);
        $quantity       = (int)$request->input('quantity');

        return $this->deviceService->updateSupply($device, $supply, $quantity);
    }

    public function getSupplyDevice(Request $request, Device $device, Supply $supply): JsonResponse
    {
        $existingSupply = $device->supplies()->where('supply_id', $supply->id)->first();

        if ($existingSupply) {
            return response()->json($existingSupply->pivot);
        }

        return response()->json(['error' => false, 'message' => 'Insumo no encontrado.'], 404);
    }

    public function selectType(): Application|Factory|View
    {
        return view('device.select-type', ['deviceTypes' => self::$deviceTypes]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Application|Factory|View
    {
        $sectorId = $request->input('sector_id');
        $state    = $request->input('state');
        $search   = $request->input('search');
        $type     = $request->input('type');

        $devices = Device::query()
            ->when($sectorId, fn($query) => $query->where('sector_id', $sectorId))
            ->when($state, fn($query) => $query->where('state', $state))
            ->when($search, fn($query) => $query->where('sku', 'like', '%' . $search . '%'))
            ->when($type, fn($query) => $query->where('deviceable_type', 'App\Models\\' . $type))
            ->orderBy('sku')
            ->paginate(Configuration::first()->default_per_page);

        return view('device.index', [
            'devices'        => $devices,
            'sectors'        => Sector::all(),
            'selectedSector' => $sectorId,
            'selectedState'  => $state ?? null,
            'search'         => $search,
            'selectedType'   => $type,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): Factory|Application|View|RedirectResponse
    {
        $type = $request->input('type');

        if (!array_key_exists($type, self::$deviceTypes)) {
            return redirect()->route('devices.selectType')->with('error', 'Invalid device type selected.');
        }

        return view('device.create-' . $type, [
            'sectors' => Sector::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate general device fields
        $validatedDevice = $request->validate([
            'sku'        => 'required|string|max:255',
            'entry_year' => 'required|date',
            'state'      => 'required|string',
            'brand_id'   => 'nullable|exists:brands,id',
            'sector_id'  => 'nullable|exists:sectors,id',
        ]);

        $type = $request->input('type');

        $deviceable = match ($type) {
            'pc' => PC::create(),
            'printer' => Printer::create(),
            'monitor' => function () use ($request) {
                $validatedMonitor = $request->validate([
                    'has_vga'  => 'nullable|boolean',
                    'has_dp'   => 'nullable|boolean',
                    'has_hdmi' => 'nullable|boolean',
                ]);
                return Monitor::create($validatedMonitor);
            },
            default => abort(404),
        };

        if (is_callable($deviceable)) {
            $deviceable = $deviceable();
        }

        try {
            $device = Device::create(array_merge($validatedDevice, [
                'deviceable_type' => get_class($deviceable),
                'deviceable_id'   => $deviceable->id,
            ]));
        } catch (\Exception $e) {
            $message = "Hubo un error al guardar";

            if ($e->getCode() === '23000') { {
                $message = 'Hubo un error al guardar, verifique que su SKU sea unico';
            }

            return redirect()->back()->withErrors($message)->withInput();
        }
}
        $this->recordService->createRecord($device, 'Dispositivo creado');

        return redirect()->route('devices.index')->with('success', 'Monitor created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Device $device)
    {
        $suppliesByCategory = $device->supplies()
            ->with('category')
            ->get()
            ->groupBy('category.name')
            ->sortKeys();

        return view('device.show', [
            'device'             => $device,
            'suppliesByCategory' => $suppliesByCategory,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Device $device): Application|Factory|View
    {
        return view('device.edit', [
            'device'  => $device,
            'sectors' => Sector::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Device $device): RedirectResponse
    {
        $validatedDevice = $request->validate([
            'sku'        => 'required|string|max:255',
            'entry_year' => 'required|date',
            'state'      => 'required|string',
            'brand_id'   => 'nullable|exists:brands,id',
            'sector_id'  => 'nullable|exists:sectors,id',
        ]);

        if ($device->deviceable_type === Monitor::class) {
            $validatedMonitor = $request->merge([
                'has_vga'  => $request->boolean('has_vga'),
                'has_dp'   => $request->boolean('has_dp'),
                'has_hdmi' => $request->boolean('has_hdmi'),
            ])->validate([
                'has_vga'  => 'boolean',
                'has_dp'   => 'boolean',
                'has_hdmi' => 'boolean',
            ]);
            $device->deviceable->update($validatedMonitor);
        }

        $original = $device->getOriginal();

        try {

            $device->update($validatedDevice);
        } catch (\Exception $e) {
            $message = "Hubo un error al guardar";
            if ($e->getCode() === '23000') {
                {
                    $message = 'El SKU debe ser unico';
                }
                return redirect()->back()->withErrors($message)->withInput();
            }
        }
        $changes  = $device->getChanges();
        $this->recordService->createRecord($device, 'Dispositivo modificado ', $changes, $original);

        return redirect()->route('devices.index')
            ->with('success', 'Dispositivo actualizado correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     * If it has supplies attached, they will be detached and the quantity will be incremented.
     */
    public function destroy(Device $device): RedirectResponse
    {
        $supplies = $device->supplies;

        foreach ($supplies as $supply) {
            $device->supplies()->detach($supply->id);
            $supply->increment('quantity', $supply->pivot->quantity);
            $this->recordService->createRecord($supply, 'Insumo devuelto desde dispositivo '. $device->sku.'.Ya que fue eliminado');
        }

        $device->delete();
        return redirect()->route('devices.index')
            ->with('success', 'Dispositivo eliminado correctamente!');
    }
}
