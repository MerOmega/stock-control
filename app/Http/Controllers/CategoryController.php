<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Configuration;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request): View|Factory|Application
    {
        $query = Category::query();

        if ($search = $request->input('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $categories = $query->orderBy('name')->paginate(Configuration::first()->default_per_page);

        return view('category.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new category.
     * @return Application|Factory|View
     */
    public function create(): Application|Factory|View
    {
        return view('category.create');
    }

    /**
     * Store a newly created category in storage.
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $category      = Category::create([
            'name' => $validatedData['name'],
        ]);
        $category->save();
        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified category.
     * @param string $id
     * @return Application|Factory|View
     */
    public function show(string $id): Application|Factory|View
    {
        $category = Category::find($id);

        if (!$category) {
            abort(404, 'Category not found');
        }

        return view('category.show', ['category' => $category]);
    }

    /**
     * Show the form for editing the category.
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit(int $id): Application|Factory|View
    {
        $category = Category::findOrFail($id);

        return view('category.edit', ['category' => $category]);
    }

    /**
     * Update the category resource in storage.
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::findOrFail($id);
        $category->update($validatedData);

        // Redirect to the categories index with a success message
        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the category from storage.
     * @param Category $category
     * @return RedirectResponse
     */
    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
