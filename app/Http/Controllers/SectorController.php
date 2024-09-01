<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\Sector;
use Illuminate\Http\Request;

class SectorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Sector::query();

        if ($search = $request->input('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $sectors = $query->orderBy('name')->paginate(Configuration::first()->default_per_page);

        return view('sector.index', ['sectors' => $sectors]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sector.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Sector::create([
           'name' => $request['name']
        ]);
        return redirect()->route('sectors.index')->with('success', 'Sector created successfully.');
    }

    /**
     * TODO Might add a new functionality later.
     * Display the specified resource.
     */
    public function show(Sector $sector)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sector $sector)
    {
        return view('sector.edit', ['sector' => $sector]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sector $sector)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $sector->update([
            'name' => $request['name']
        ]);
        return redirect()->route('sectors.index')->with('success', 'Sector updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sector $sector)
    {
        $sector->delete();
        return redirect()->route('sectors.index')->with('success', 'Sector deleted successfully.');
    }
}
