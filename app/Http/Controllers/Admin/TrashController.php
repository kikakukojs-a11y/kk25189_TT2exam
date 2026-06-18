<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\Category;
use Illuminate\Http\Request;

class TrashController extends Controller
{
    public function index()
    {
        $deletedAnimals = Animal::onlyTrashed()->with('category')->latest('deleted_at')->get();
        $deletedCategories = Category::onlyTrashed()->latest('deleted_at')->get();

        return view('admin.trash.index', compact('deletedAnimals', 'deletedCategories'));
    }

    public function restoreAnimal($id)
    {
        $animal = Animal::onlyTrashed()->findOrFail($id);
        $animal->restore();

        return redirect()->back()->with('success', "Animal profile '{$animal->name}' has been successfully restored!");
    }

    public function forceDeleteAnimal($id)
    {
        $animal = Animal::onlyTrashed()->findOrFail($id);
        $animal->forceDelete();

        return redirect()->back()->with('success', "Animal profile '{$animal->name}' has been permanently deleted.");
    }

    public function restoreCategory($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->back()->with('success', "Species category '{$category->name}' has been successfully restored!");
    }

    public function forceDeleteCategory($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();

        return redirect()->back()->with('success', "Species category '{$category->name}' has been permanently deleted.");
    }
}