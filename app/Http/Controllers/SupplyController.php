<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Configuration;
use App\Models\Supply;
use App\Services\RecordService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SupplyController extends Controller
{

    public function __construct(readonly RecordService $recordService)
    {
    }

    public function getSupplyRecord(Request $request, Supply $supply): View
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
    public function index(Request $request)
    {
        $query = Supply::query();

        if ($categoryId = $request->input('category_id')) {
            $query->where('category_id', $categoryId);
        }

        if ($search = $request->input('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($lowStock = $request->input('low_stock')) {
            $query->where('quantity', '<=', Configuration::first()->low_stock_alert);
        }

        if ($noStock = $request->input('no_stock')) {
            $query->where('quantity', '=', 0);
        }

        $categories = Category::all();
        $supplies = $query->orderBy('name')->paginate(Configuration::first()->default_per_page);

        return view('supply.index', [
            'supplies'         => $supplies,
            'categories'       => $categories,
            'selectedCategory' => $categoryId,
            'search'           => $search,
            'noStockSearch'    => $noStock,
            'lowStockSearch'   => $lowStock, // corrected typo
            'lowStock'         => Configuration::first()->low_stock_alert,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('supply.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'category_id'  => 'nullable|exists:categories,id',
            'quantity'     => 'required|integer|min:1',
            'description'  => 'nullable|string',
            'observations' => 'nullable|string',
        ]);

        $supply = Supply::create($request->all());

        $this->recordService->createRecord($supply, 'Insumo creado');

        return redirect()->route('supplies.index')->with('success', 'Insumo creado!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Supply $supply)
    {
        // Show the specific supply
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
    public function update(Request $request, Supply $supply)
    {
        // Validate the request data
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'category_id'  => 'nullable|exists:categories,id',
            'quantity'     => 'required|integer|min:0',
            'description'  => 'nullable|string',
            'observations' => 'nullable|string',
        ]);

        $original = $supply->getOriginal();
        $supply->update($validated);
        $changes  = $supply->getChanges();
        $this->recordService->createRecord($supply, 'Insumo editado ', $changes, $original);
        return redirect()->route('supplies.show', $supply->id)
            ->with('success', 'Insumo actualizado!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supply $supply)
    {
        foreach ($supply->devices as $device) {
            $device->supplies()->detach($supply->id);
            $this->recordService->createRecord($device, 'Insumo eliminado '. $supply->name .'. Se retiro dicho insumo del dispositivo');
        }
        $supply->delete();
        return redirect()->route('supplies.index')
            ->with('success', trans('messages.supply.supply_deleted'));
    }
}
