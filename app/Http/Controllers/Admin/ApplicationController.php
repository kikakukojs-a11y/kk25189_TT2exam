<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;


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
        $request->validate(['status' => 'required|in:Approved,Rejected']);
        
        $application = Application::findOrFail($id);
        $application->update(['status' => $request->status]);
        $application->load(['user', 'animal']);

        $view = ($application->status === 'Approved') ? 'emails.application-accepted' : 'emails.application-declined';
        $subject = ($application->status === 'Approved') ? 'Your Application Approved' : 'Your Application Declined';

        $htmlContent = View::make($view, ['application' => $application])->render();

        $response = Http::withHeaders([
            'api-key' => config('services.brevo.key'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post('https://api.brevo.com/v3/smtp/email', [
            'sender' => ['email' => 'kikakukojs0@gmail.com', 'name' => 'Pet Adoption Shelter'],
            'to' => [['email' => $application->user->email]],
            'subject' => $subject,
            'htmlContent' => $htmlContent,
        ]);

        if ($response->failed()) {
            Log::error('Brevo API Error: ' . $response->body());
        }

        return redirect()->back()->with('success', 'Status updated and email sent.');
    }
}