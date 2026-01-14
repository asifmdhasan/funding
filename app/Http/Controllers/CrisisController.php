<?php

namespace App\Http\Controllers;

use App\Models\Crisis;
use App\Models\Category;
use Illuminate\Http\Request;

class CrisisController extends Controller
{
        public function index()
    {
        $crises = Crisis::with('category')->latest()->get();
        return view('crises.index', compact('crises'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('crises.create', compact('categories'));
    }

    /**
     * Store a newly created resource.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id'   => 'required|exists:categories,id',
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'city'          => 'nullable|string|max:255',
            'target_amount' => 'required|numeric|min:1',
        ]);

        Crisis::create($request->all());

        return redirect()
            ->route('crises.index')
            ->with('success', 'Crisis created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Crisis $crisis)
    {
        $categories = Category::all();
        return view('crises.edit', compact('crisis', 'categories'));
    }

    /**
     * Update the specified resource.
     */
    public function update(Request $request, Crisis $crisis)
    {
        $request->validate([
            'category_id'   => 'required|exists:categories,id',
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'city'          => 'nullable|string|max:255',
            'target_amount' => 'required|numeric|min:1',
        ]);

        $crisis->update($request->all());

        return redirect()
            ->route('crises.index')
            ->with('success', 'Crisis updated successfully.');
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(Crisis $crisis)
    {
        $crisis->delete();

        return redirect()
            ->route('crises.index')
            ->with('success', 'Crisis deleted successfully.');
    }
}
