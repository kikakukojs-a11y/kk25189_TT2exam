<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Log;
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
    Log::info('--- Update method triggered for Application ID: ' . $id);
    
    $request->validate([
        'status' => 'required|in:Approved,Rejected'
    ]);

    $application = Application::findOrFail($id);
    $application->update([
        'status' => $request->status
    ]);
    
    Log::info('--- Status updated to: ' . $request->status);

    $application->load(['user', 'animal']);

    if ($application->status === 'Approved') {
        Log::info('--- Attempting to send APPROVED email to: ' . $application->user->email);
        Mail::to($application->user->email)->send(new ApplicationAccepted($application));
    } elseif ($application->status === 'Rejected') {
        Log::info('--- Attempting to send REJECTED email to: ' . $application->user->email);
        Mail::to($application->user->email)->send(new ApplicationDeclined($application));
    } else {
        Log::info('--- Logic skipped: Status was not Approved or Rejected. Value was: ' . $application->status);
    }

    return redirect()->back()->with('success', 'Status updated.');
}
}