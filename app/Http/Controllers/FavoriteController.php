<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggle(Animal $animal)
    {
        $user = Auth::user();
        $user->favorites()->toggle($animal->id);

        return back()->with('status', 'Favorites updated!');
    }
}