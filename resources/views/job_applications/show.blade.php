@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Job Application Details') }}</span>
                    <div>
                        <a href="{{ route('job-applications.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Applications
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <h4 class="border-bottom pb-2">{{ $jobApplication->company_name }} - {{ $jobApplication->position }}</h4>
                        
                        <div class="row mb-3">
                            <div class="col-md-3 text-muted">Status:</div>
                            <div class="col-md-9">
                                <span class="badge bg-{{ 
                                    $jobApplication->status == 'applied' ? 'secondary' : 
                                    ($jobApplication->status == 'interview' ? 'info' : 
                                    ($jobApplication->status == 'offer' ? 'success' : 
                                    ($jobApplication->status == 'rejected' ? 'danger' : 
                                    ($jobApplication->status == 'accepted' ? 'primary' : 'warning')))) 
                                }}">
                                    {{ ucfirst($jobApplication->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3 text-muted">Applied On:</div>
                            <div class="col-md-9">
                                {{ $jobApplication->application_date->format('M d, Y') }}
                            </div>
                        </div>

                        @if($jobApplication->location)
                            <div class="row mb-3">
                                <div class="col-md-3 text-muted">Location:</div>
                                <div class="col-md-9">
                                    {{ $jobApplication->location }}
                                </div>
                            </div>
                        @endif

                        @if($jobApplication->salary_range)
                            <div class="row mb-3">
                                <div class="col-md-3 text-muted">Salary Range:</div>
                                <div class="col-md-9">
                                    {{ $jobApplication->salary_range }}
                                </div>
                            </div>
                        @endif

                        @if($jobApplication->description)
                            <div class="row mb-3">
                                <div class="col-md-3 text-muted">Job Description:</div>
                                <div class="col-md-9">
                                    {{ $jobApplication->description }}
                                </div>
                            </div>
                        @endif

                        @if($jobApplication->contact_name)
                            <div class="row mb-3">
                                <div class="col-md-3 text-muted">Contact:</div>
                                <div class="col-md-9">
                                    {{ $jobApplication->contact_name }}
                                    @if($jobApplication->contact_email)
                                        <br><a href="mailto:{{ $jobApplication->contact_email }}">{{ $jobApplication->contact_email }}</a>
                                    @endif
                                    @if($jobApplication->contact_phone)
                                        <br>{{ $jobApplication->contact_phone }}
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if($jobApplication->notes)
                            <div class="row mb-3">
                                <div class="col-md-3 text-muted">Notes:</div>
                                <div class="col-md-9">
                                    {{ $jobApplication->notes }}
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <div>
                            <a href="{{ route('job-applications.edit', $jobApplication) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Edit Application
                            </a>
                        </div>
                        <div>
                            <form action="{{ route('job-applications.destroy', $jobApplication) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this application?')">
                                    <i class="fas fa-trash"></i> Delete Application
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reminders Section -->
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Reminders') }}</span>
                    <a href="{{ route('reminders.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Add Reminder
                    </a>
                </div>

                <div class="card-body">
                    @if($reminders->count() > 0)
                        <div class="list-group">
                            @foreach($reminders as $reminder)
                                <div class="list-group-item list-group-item-action {{ $reminder->is_completed ? 'text-muted' : ($reminder->reminder_date->isPast() ? 'list-group-item-danger' : '') }}">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{ $reminder->title }}</h5>
                                        <small>
                                            <span class="badge bg-{{ 
                                                $reminder->priority == 'low' ? 'success' : 
                                                ($reminder->priority == 'medium' ? 'warning' : 'danger') 
                                            }}">
                                                {{ ucfirst($reminder->priority) }}
                                            </span>
                                        </small>
                                    </div>
                                    <p class="mb-1">{{ $reminder->description }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small>{{ $reminder->reminder_date->format('M d, Y g:i A') }}</small>
                                        <div>
                                            <form action="{{ route('reminders.toggle-complete', $reminder) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm {{ $reminder->is_completed ? 'btn-success' : 'btn-outline-secondary' }}">
                                                    {{ $reminder->is_completed ? 'Completed' : 'Mark Complete' }}
                                                </button>
                                            </form>
                                            <a href="{{ route('reminders.edit', $reminder) }}" class="btn btn-sm btn-primary">
                                                Edit
                                            </a>
                                            <form action="{{ route('reminders.destroy', $reminder) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this reminder?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center p-4">
                            <p>No reminders for this job application yet.</p>
                            <a href="{{ route('reminders.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add Reminder
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 