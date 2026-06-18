<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Category;
use App\Models\Characteristic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnimalController extends Controller
{
    public function index(Request $request)
    {
        $all_species = Category::all();

        $animals = Animal::query()
            ->whereDoesntHave('applications') 
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(function($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('breed', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->filled('species'), function ($query) use ($request) {
                $query->where('category_id', $request->species); 
            })
            ->get();

        return view('animals.index', compact('animals', 'all_species'));
    }

    public function show($id)
    {
        $animal = Animal::with(['category', 'characteristics'])->findOrFail($id);
        return view('animals.show', compact('animal'));
    }

    public function showFavorites()
    {
        $animals = auth()->user()->favorites()->with('category')->get();
        return view('favorites.index', compact('animals'));
    }

    public function toggleFavorite(Animal $animal)
    {
        $user = auth()->user();
        
        if ($user->favoriteAnimals()->where('animal_id', $animal->id)->exists()) {
            $user->favoriteAnimals()->detach($animal->id);
            $status = 'removed from favorites';
        } else {
            $user->favoriteAnimals()->attach($animal->id);
            $status = 'added to favorites';
        }

        return redirect()->back()->with('success', "Animal $status!");
    }

    public function create() 
    {
        $categories = Category::all();
        $characteristics = Characteristic::all();
        return view('admin.animals.create', compact('categories', 'characteristics'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'breed' => 'nullable|string|max:255',
            'age' => 'required|integer',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('animals');
        }

        $animal = Animal::create($validated);

        if ($request->has('characteristics')) {
            $animal->characteristics()->attach($request->characteristics);
        }

        return redirect()->route('animals.index')->with('success', 'Animal profile created!');
    }

    public function edit(Animal $animal) 
    {
        $categories = Category::all();
        $characteristics = Characteristic::all();
        return view('admin.animals.edit', compact('animal', 'categories', 'characteristics'));
    }

    public function update(Request $request, $id)
    {
        $animal = Animal::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'breed' => 'nullable|string|max:255',
            'age' => 'required|integer',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($animal->image) {
                Storage::delete($animal->image);
            }
            $validated['image'] = $request->file('image')->store('animals');
        }

        $animal->update($validated);

        $animal->characteristics()->sync($request->input('characteristics', []));

        return redirect()->route('animals.index')->with('success', 'Animal profile updated!');
    }

    public function destroy(Animal $animal) 
    {
        if ($animal->image) {
            Storage::delete($animal->image);
        }

        $animal->delete();
        return redirect()->route('animals.index')->with('success', 'Animal profile deleted!');
    }
}