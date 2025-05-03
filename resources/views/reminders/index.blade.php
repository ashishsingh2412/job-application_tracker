@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Reminders') }}</span>
                    <div>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm me-2">
                            <i class="fas fa-arrow-left"></i> Back to Dashboard
                        </a>
                        <a href="{{ route('reminders.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add New Reminder
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($reminders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Job Application</th>
                                        <th>Date/Time</th>
                                        <th>Priority</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reminders as $reminder)
                                        <tr class="{{ $reminder->is_completed ? 'text-muted' : ($reminder->reminder_date->isPast() ? 'table-danger' : '') }}">
                                            <td>{{ $reminder->title }}</td>
                                            <td>
                                                <a href="{{ route('job-applications.show', $reminder->jobApplication) }}">
                                                    {{ $reminder->jobApplication->company_name }} - {{ $reminder->jobApplication->position }}
                                                </a>
                                            </td>
                                            <td>{{ $reminder->reminder_date->format('M d, Y g:i A') }}</td>
                                            <td>
                                                <span class="badge bg-{{ 
                                                    $reminder->priority == 'low' ? 'success' : 
                                                    ($reminder->priority == 'medium' ? 'warning' : 'danger') 
                                                }}">
                                                    {{ ucfirst($reminder->priority) }}
                                                </span>
                                            </td>
                                            <td>
                                                <form action="{{ route('reminders.toggle-complete', $reminder) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm {{ $reminder->is_completed ? 'btn-outline-success' : 'btn-outline-secondary' }}">
                                                        {{ $reminder->is_completed ? 'Completed' : 'Mark Complete' }}
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('reminders.show', $reminder) }}" class="btn btn-info btn-sm">View</a>
                                                    <a href="{{ route('reminders.edit', $reminder) }}" class="btn btn-primary btn-sm">Edit</a>
                                                    <form action="{{ route('reminders.destroy', $reminder) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this reminder?')">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center p-5">
                            <h5>No reminders yet</h5>
                            <p>Create reminders to help you follow up on job applications.</p>
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