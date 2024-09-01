<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Configuration;
use App\Models\Supply;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class SupplyController extends Controller
{
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

        $categories = Category::all();
        $supplies = $query->orderBy('name')->paginate(Configuration::first()->default_per_page);
        return view('supply.index', [
            'supplies' => $supplies,
            'categories' => $categories,
            'selectedCategory' => $categoryId,
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

        Supply::create($request->all());
        return redirect()->route('supplies.index')->with('success', 'Supply created successfully!');
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
            'quantity'     => 'required|integer|min:1',
            'description'  => 'nullable|string',
            'observations' => 'nullable|string',
        ]);

        $supply->update($validated);

        return redirect()->route('supplies.show', $supply->id)
            ->with('success', 'Supply updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supply $supply)
    {
        $supply->delete();
        return redirect()->route('supplies.index')
            ->with('success', 'Supply deleted successfully!');
    }
}
