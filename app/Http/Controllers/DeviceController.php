<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\Device;
use App\Models\Monitor;
use App\Models\PC;
use App\Models\Printer;
use App\Models\Sector;
use App\Models\Supply;
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
            'printer' => 'Printer',
        ];

    public function storeSupplies(Request $request): JsonResponse
    {
        $device = Device::find($request->input('device_id'));

        if (!$device) {
            return response()->json(['success' => false, 'message' => 'Device not found.'], 404);
        }

        $supplies = $request->input('supplies', []);

        foreach ($supplies as $supply) {
            $existingSupply = Supply::find($supply['id']);

            if (!$existingSupply) {
                return response()->json(['success' => false, 'message' => 'Supply not found.'], 404);
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
        }

        return response()->json(['success' => true]);
    }

    // Method to remove a supply from the device
    public function removeSupply(Device $device, Supply $supply): JsonResponse
    {
        $existingSupply = $device->supplies()->where('supply_id', $supply->id)->first();

        if ($existingSupply) {
            $supply->increment('quantity', $existingSupply->pivot->quantity);
            $device->supplies()->detach($supply->id);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Supply not found on device.'], 404);
    }

    public function updateSupply(Request $request, Device $device, Supply $supply): JsonResponse
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $quantity       = (int)$request->input('quantity');
        $existingSupply = $device->supplies()->where('supply_id', $supply->id)->first();

        if ($existingSupply) {
            $currentDeviceQuantity = $existingSupply->pivot->quantity;
            $difference            = $quantity - $currentDeviceQuantity;

            if ($difference > 0) {
                if ($supply->quantity >= $difference) {
                    $device->supplies()->updateExistingPivot($supply->id, ['quantity' => $quantity]);
                    $supply->decrement('quantity', $difference);
                } else {
                    return response()->json(['success' => false, 'message' => 'Not enough supply available in inventory.'], 400);
                }
            } elseif ($difference < 0) {
                $device->supplies()->updateExistingPivot($supply->id, ['quantity' => $quantity]);
                $supply->increment('quantity', abs($difference));
            }

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Supply not found on device.'], 404);
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
        $query = Device::query();

        if ($search = $request->input('search')) {
            $query->where('sku', 'like', '%' . $search . '%');
        }

        $devices = $query->orderBy('sku')->paginate(Configuration::first()->default_per_page);

        return view('device.index', [
            'devices' => $devices,
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

        Device::create(array_merge($validatedDevice, [
            'deviceable_type' => get_class($deviceable),
            'deviceable_id'   => $deviceable->id,
        ]));

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
            'device' => $device,
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

        $device->update($validatedDevice);
        return redirect()->route('devices.index')
            ->with('success', 'Dispositivo actualizado correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Device $device): RedirectResponse
    {
        $device->delete();
        return redirect()->route('devices.index')
            ->with('success', 'Dispositivo eliminado correctamente!');
    }
}
