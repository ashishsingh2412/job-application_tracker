@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Reminder Details') }}</span>
                    <div>
                        <a href="{{ route('reminders.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Reminders
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
                        <h4 class="border-bottom pb-2">{{ $reminder->title }}</h4>
                        
                        <div class="row mb-3">
                            <div class="col-md-3 text-muted">Job Application:</div>
                            <div class="col-md-9">
                                <a href="{{ route('job-applications.show', $reminder->jobApplication) }}">
                                    {{ $reminder->jobApplication->company_name }} - {{ $reminder->jobApplication->position }}
                                </a>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3 text-muted">Date/Time:</div>
                            <div class="col-md-9 {{ $reminder->reminder_date->isPast() && !$reminder->is_completed ? 'text-danger' : '' }}">
                                {{ $reminder->reminder_date->format('M d, Y g:i A') }}
                                @if($reminder->reminder_date->isPast() && !$reminder->is_completed)
                                    <span class="badge bg-danger ms-2">Overdue</span>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3 text-muted">Priority:</div>
                            <div class="col-md-9">
                                <span class="badge bg-{{ 
                                    $reminder->priority == 'low' ? 'success' : 
                                    ($reminder->priority == 'medium' ? 'warning' : 'danger') 
                                }}">
                                    {{ ucfirst($reminder->priority) }}
                                </span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3 text-muted">Status:</div>
                            <div class="col-md-9">
                                <form action="{{ route('reminders.toggle-complete', $reminder) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm {{ $reminder->is_completed ? 'btn-success' : 'btn-outline-secondary' }}">
                                        {{ $reminder->is_completed ? 'Completed' : 'Mark as Complete' }}
                                    </button>
                                </form>
                            </div>
                        </div>

                        @if($reminder->description)
                            <div class="row mb-3">
                                <div class="col-md-3 text-muted">Description:</div>
                                <div class="col-md-9">
                                    {{ $reminder->description }}
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <div>
                            <a href="{{ route('reminders.edit', $reminder) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Edit Reminder
                            </a>
                        </div>
                        <div>
                            <form action="{{ route('reminders.destroy', $reminder) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this reminder?')">
                                    <i class="fas fa-trash"></i> Delete Reminder
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 