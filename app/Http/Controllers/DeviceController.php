<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\Device;
use App\Models\Monitor;
use App\Models\PC;
use App\Models\Printer;
use App\Models\Sector;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
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
    public function show(Device $device): Application|Factory|View
    {
        return view('device.show', ['device' => $device]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Device $device): Application|Factory|View
    {
        return view('device.edit', [
            'device' => $device,
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
                'has_vga' => $request->boolean('has_vga'),
                'has_dp'  => $request->boolean('has_dp'),
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
