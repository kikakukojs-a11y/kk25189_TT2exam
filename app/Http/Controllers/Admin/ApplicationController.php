<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Mail\ApplicationAccepted;
use App\Mail\ApplicationDeclined;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

        $application->load(['user', 'animal']);


        if ($application->status === 'Approved') {
            Mail::to($application->user->email)->send(new ApplicationAccepted($application));
        } elseif ($application->status === 'Rejected') {
            Mail::to($application->user->email)->send(new ApplicationDeclined($application));
        }

        return redirect()->back()->with('success', 'Pieteikuma statuss atjaunināts un lietotājam nosūtīts e-pasts');
    }
}