<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::withCount('animals')->get();
        return view('admin.categories.index', compact('categories'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:categories,name|max:255',
        ]);

        Category::create($validated);

        return redirect()->back()->with('success', 'New species category added successfully!');
    }

 
    public function destroy(Category $category)
    {

        if ($category->animals()->exists()) {
            return redirect()->back()->with('error', 'Cannot delete species. There are animal profiles linked to it.');
        }

        $category->delete();
        return redirect()->back()->with('success', 'Species deleted successfully!');
    }
}