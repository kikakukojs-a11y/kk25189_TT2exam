<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index()
    {

        $applications = Application::with('user', 'animal')
            ->latest()
            ->paginate(20);

        return view('admin.applications.index', compact('applications'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Approved,Rejected'
        ]);

        $application = Application::findOrFail($id);
        $application->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Pieteikuma statuss atjaunināts!');
    }
}