<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobApplicationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobApplications = Auth::user()->jobApplications()->orderBy('created_at', 'desc')->get();
        return view('job_applications.index', compact('jobApplications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('job_applications.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'salary_range' => 'nullable|string|max:255',
            'application_date' => 'required|date',
            'status' => 'required|in:applied,interview,offer,rejected,accepted,withdrawn',
            'contact_name' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $jobApplication = Auth::user()->jobApplications()->create($validated);

        return redirect()->route('job-applications.show', $jobApplication)
            ->with('success', 'Job application created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(JobApplication $jobApplication)
    {
        $this->authorize('view', $jobApplication);
        
        $reminders = $jobApplication->reminders()->orderBy('reminder_date', 'asc')->get();
        
        return view('job_applications.show', compact('jobApplication', 'reminders'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobApplication $jobApplication)
    {
        $this->authorize('update', $jobApplication);
        
        return view('job_applications.edit', compact('jobApplication'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobApplication $jobApplication)
    {
        $this->authorize('update', $jobApplication);
        
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'salary_range' => 'nullable|string|max:255',
            'application_date' => 'required|date',
            'status' => 'required|in:applied,interview,offer,rejected,accepted,withdrawn',
            'contact_name' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $jobApplication->update($validated);

        return redirect()->route('job-applications.show', $jobApplication)
            ->with('success', 'Job application updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobApplication $jobApplication)
    {
        $this->authorize('delete', $jobApplication);
        
        $jobApplication->delete();

        return redirect()->route('job-applications.index')
            ->with('success', 'Job application deleted successfully.');
    }
}
