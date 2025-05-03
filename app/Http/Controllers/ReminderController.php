<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReminderController extends Controller
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
        $reminders = Auth::user()->reminders()
            ->with('jobApplication')
            ->orderBy('reminder_date', 'asc')
            ->get();
            
        return view('reminders.index', compact('reminders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jobApplications = Auth::user()->jobApplications()->get();
        return view('reminders.create', compact('jobApplications'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_application_id' => 'required|exists:job_applications,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'reminder_date' => 'required|date',
            'priority' => 'required|in:low,medium,high',
        ]);

        $jobApplication = JobApplication::findOrFail($validated['job_application_id']);
        
        // Check if the user owns the job application
        $this->authorize('view', $jobApplication);

        $validated['user_id'] = Auth::id();
        $reminder = Reminder::create($validated);

        return redirect()->route('job-applications.show', $jobApplication)
            ->with('success', 'Reminder created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reminder $reminder)
    {
        $this->authorize('view', $reminder);
        
        return view('reminders.show', compact('reminder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reminder $reminder)
    {
        $this->authorize('update', $reminder);
        
        $jobApplications = Auth::user()->jobApplications()->get();
        
        return view('reminders.edit', compact('reminder', 'jobApplications'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reminder $reminder)
    {
        $this->authorize('update', $reminder);
        
        $validated = $request->validate([
            'job_application_id' => 'required|exists:job_applications,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'reminder_date' => 'required|date',
            'priority' => 'required|in:low,medium,high',
            'is_completed' => 'boolean',
        ]);

        // Check if the user owns the job application
        $jobApplication = JobApplication::findOrFail($validated['job_application_id']);
        $this->authorize('view', $jobApplication);

        $reminder->update($validated);

        return redirect()->route('reminders.show', $reminder)
            ->with('success', 'Reminder updated successfully.');
    }

    /**
     * Toggle the completion status of a reminder.
     */
    public function toggleComplete(Reminder $reminder)
    {
        $this->authorize('update', $reminder);
        
        $reminder->update([
            'is_completed' => !$reminder->is_completed,
        ]);

        return back()->with('success', 'Reminder status updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reminder $reminder)
    {
        $this->authorize('delete', $reminder);
        
        $jobApplication = $reminder->jobApplication;
        $reminder->delete();

        return redirect()->route('job-applications.show', $jobApplication)
            ->with('success', 'Reminder deleted successfully.');
    }
}
