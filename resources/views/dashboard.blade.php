@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">Job Applications</h5>
                                </div>
                                <div class="card-body">
                                    <h6 class="card-title">Manage Your Job Applications</h6>
                                    <p class="card-text">Track all your job applications in one place.</p>
                                    <a href="{{ route('job-applications.index') }}" class="btn btn-primary">View Applications</a>
                                    <a href="{{ route('job-applications.create') }}" class="btn btn-outline-primary">Add New</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0">Reminders</h5>
                                </div>
                                <div class="card-body">
                                    <h6 class="card-title">Stay on Track</h6>
                                    <p class="card-text">Never miss a follow-up with reminders.</p>
                                    <a href="{{ route('reminders.index') }}" class="btn btn-success">View Reminders</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0">Statistics</h5>
                                </div>
                                <div class="card-body">
                                    <h6 class="card-title">Your Job Search Status</h6>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Applications
                                            <span class="badge bg-primary rounded-pill">{{ Auth::user()->jobApplications()->count() }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Interviews
                                            <span class="badge bg-primary rounded-pill">{{ Auth::user()->jobApplications()->where('status', 'interview')->count() }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Offers
                                            <span class="badge bg-primary rounded-pill">{{ Auth::user()->jobApplications()->where('status', 'offer')->count() }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-warning">
                                    <h5 class="mb-0">Upcoming Reminders</h5>
                                </div>
                                <div class="card-body">
                                    @php
                                        $upcomingReminders = Auth::user()->reminders()
                                            ->where('is_completed', false)
                                            ->orderBy('reminder_date', 'asc')
                                            ->limit(5)
                                            ->get();
                                    @endphp

                                    @if($upcomingReminders->count() > 0)
                                        <ul class="list-group">
                                            @foreach($upcomingReminders as $reminder)
                                                <li class="list-group-item">
                                                    <div class="d-flex w-100 justify-content-between">
                                                        <h6 class="mb-1">{{ $reminder->title }}</h6>
                                                        <small class="{{ $reminder->reminder_date->isPast() ? 'text-danger' : 'text-muted' }}">
                                                            {{ $reminder->reminder_date->format('M d, Y') }}
                                                        </small>
                                                    </div>
                                                    <p class="mb-1">{{ Str::limit($reminder->description, 100) }}</p>
                                                    <small>
                                                        <a href="{{ route('job-applications.show', $reminder->jobApplication) }}">
                                                            {{ $reminder->jobApplication->company_name }} - {{ $reminder->jobApplication->position }}
                                                        </a>
                                                    </small>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-center">No upcoming reminders</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="mb-0">Recent Applications</h5>
                                </div>
                                <div class="card-body">
                                    @php
                                        $recentApplications = Auth::user()->jobApplications()
                                            ->orderBy('created_at', 'desc')
                                            ->limit(5)
                                            ->get();
                                    @endphp

                                    @if($recentApplications->count() > 0)
                                        <ul class="list-group">
                                            @foreach($recentApplications as $app)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <a href="{{ route('job-applications.show', $app) }}" class="text-decoration-none">
                                                            <strong>{{ $app->company_name }}</strong> - {{ $app->position }}
                                                        </a>
                                                        <br>
                                                        <small class="text-muted">Applied on {{ $app->application_date->format('M d, Y') }}</small>
                                                    </div>
                                                    <span class="badge bg-{{ 
                                                        $app->status == 'applied' ? 'secondary' : 
                                                        ($app->status == 'interview' ? 'info' : 
                                                        ($app->status == 'offer' ? 'success' : 
                                                        ($app->status == 'rejected' ? 'danger' : 
                                                        ($app->status == 'accepted' ? 'primary' : 'warning')))) 
                                                    }}">
                                                        {{ ucfirst($app->status) }}
                                                    </span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-center">No job applications yet</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 