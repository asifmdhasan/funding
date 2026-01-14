<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
// use App\Models\BusinessCategory;

class CategoryController extends Controller
{
    public function index()
    {
        // $categories = BusinessCategory::latest()->paginate(10);
        $categories = Category::latest()->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name'   => 'required|string|max:255',
            'image'  => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048', // validate as image
            'status' => 'required|in:0,1',
        ]);

        // Prepare data
        $data = $request->only('name', 'status');

        // Handle IMAGE upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName(); // unique name
            $image->move(public_path('assets/uploads/business/categories'), $imageName); // move to public folder
            $data['image'] = 'uploads/business/categories/' . $imageName;
        }

        // Create the category
        Category::create($data);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource.
     */
    public function update(Request $request, Category $category)
    {
        // Validate the request
        $request->validate([
            'name'   => 'required|string|max:255',
            'image'  => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048', // image validation
            'status' => 'required|in:0,1',
        ]);

        $data = $request->only('name', 'status');

        // Handle IMAGE upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image && file_exists(public_path('assets/' . $category->image))) {
                unlink(public_path('assets/' . $category->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('assets/uploads/business/categories'), $imageName);

            $data['image'] = 'uploads/business/categories/' . $imageName;
        }

        // Update the category
        $category->update($data);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }


    /**
     * Remove the specified resource.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
