<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Animal;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index()
    {

        $applications = Application::with('animal')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('applications.index', compact('applications'));
    }

    public function create($animalId)
    {
        $animal = Animal::findOrFail($animalId);
        return view('applications.create', compact('animal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'animal_id' => 'required|exists:animals,id'
        ]);

        Application::create([
            'user_id' => auth()->id(),
            'animal_id' => $request->animal_id,
            'status' => 'pending',
        ]);

        return redirect()->route('animals.index')->with('success', 'Your application has been submitted!');
    }
}