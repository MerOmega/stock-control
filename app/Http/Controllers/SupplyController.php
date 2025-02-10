<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupplyRequest;
use App\Http\Requests\UpdateSupplyRequest;
use App\Models\Category;
use App\Models\Configuration;
use App\Models\Supply;
use App\Services\RecordService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SupplyController extends Controller
{
    public function __construct(readonly RecordService $recordService)
    {
    }

    public function getSupplyRecord(Supply $supply): View
    {
        $records = $supply->record()->orderBy('created_at', 'desc')->paginate(Configuration::first()->default_per_page);
        return view('supply.record', [
            'supply'  => $supply,
            'records' => $records,
        ]);
    }

    public function search(Request $request): JsonResponse
    {
        $search   = $request->input('q');
        $supplies = Supply::where('name', 'like', '%' . $search . '%')
            ->where('quantity', '>', 0)->get();
        return response()->json($supplies);
    }

    public function getSupply(int $id): JsonResponse
    {
        $supply = Supply::find($id);
        return response()->json($supply);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|Factory|Application
    {
        $config = Configuration::first();
        $supplies = Supply::query()
            ->when($request->input('category_id'), fn($query, $categoryId) => $query->where('category_id', $categoryId))
            ->when($request->input('search'), fn($query, $search) => $query->where('name', 'like', "%$search%"))
            ->when($request->input('low_stock'), fn($query) => $query->where('quantity', '<=', $config->low_stock_alert))
            ->when($request->input('no_stock'), fn($query) => $query->where('quantity', 0))
            ->orderBy('name')
            ->paginate($config->default_per_page);

        return view('supply.index', [
            'supplies'         => $supplies,
            'categories'       => Category::all(),
            'selectedCategory' => $request->input('category_id'),
            'search'           => $request->input('search'),
            'noStockSearch'    => $request->input('no_stock'),
            'lowStockSearch'   => $request->input('low_stock'),
            'lowStock'         => $config->low_stock_alert,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|Factory|Application
    {
        $categories = Category::all();
        return view('supply.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplyRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('supplies', 'public');
        }

        $supply = Supply::create($data);
        $this->recordService->createRecord($supply, 'Insumo creado');

        return redirect()->route('supplies.index')->with('success', 'Insumo creado!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Supply $supply): View|Factory|Application
    {
        return view('supply.show', ['supply' => $supply]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supply $supply): Application|Factory|View
    {
        $categories = Category::all();
        return view('supply.edit', ['supply' => $supply, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplyRequest $request, Supply $supply): RedirectResponse
    {
        $original = $supply->getOriginal();
        $data     = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('supplies', 'public');
        }

        $supply->update($data);
        $changes  = $supply->getChanges();
        $this->recordService->createRecord($supply, 'Insumo editado ', $changes, $original);
        return redirect()->route('supplies.show', $supply->id)
            ->with('success', 'Insumo actualizado!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supply $supply): RedirectResponse
    {
        if ($supply->image) {
            Storage::disk('public')->delete($supply->image);
        }

        foreach ($supply->devices as $device) {
            $device->supplies()->detach($supply->id);
            $this->recordService->createRecord($device, 'Insumo eliminado '. $supply->name .'. Se retiro dicho insumo del dispositivo');
        }
        $supply->delete();
        return redirect()->route('supplies.index')
            ->with('success', trans('messages.supply.supply_deleted'));
    }
}
