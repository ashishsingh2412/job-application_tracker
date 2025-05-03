@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Reminder') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('reminders.update', $reminder) }}">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <label for="job_application_id" class="col-md-4 col-form-label text-md-end">{{ __('Job Application') }}</label>

                            <div class="col-md-6">
                                <select id="job_application_id" class="form-select @error('job_application_id') is-invalid @enderror" name="job_application_id" required>
                                    <option value="">-- Select Job Application --</option>
                                    @foreach($jobApplications as $application)
                                        <option value="{{ $application->id }}" {{ (old('job_application_id') ?? $reminder->job_application_id) == $application->id ? 'selected' : '' }}>
                                            {{ $application->company_name }} - {{ $application->position }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('job_application_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="title" class="col-md-4 col-form-label text-md-end">{{ __('Title') }}</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') ?? $reminder->title }}" required autocomplete="title" autofocus>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description') ?? $reminder->description }}</textarea>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="reminder_date" class="col-md-4 col-form-label text-md-end">{{ __('Reminder Date/Time') }}</label>

                            <div class="col-md-6">
                                <input id="reminder_date" type="datetime-local" class="form-control @error('reminder_date') is-invalid @enderror" name="reminder_date" value="{{ old('reminder_date') ?? $reminder->reminder_date->format('Y-m-d\TH:i') }}" required>

                                @error('reminder_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="priority" class="col-md-4 col-form-label text-md-end">{{ __('Priority') }}</label>

                            <div class="col-md-6">
                                <select id="priority" class="form-select @error('priority') is-invalid @enderror" name="priority" required>
                                    <option value="low" {{ (old('priority') ?? $reminder->priority) == 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ (old('priority') ?? $reminder->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ (old('priority') ?? $reminder->priority) == 'high' ? 'selected' : '' }}>High</option>
                                </select>

                                @error('priority')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="is_completed" class="col-md-4 col-form-label text-md-end">{{ __('Status') }}</label>

                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_completed" id="is_completed" value="1" {{ (old('is_completed') ?? $reminder->is_completed) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_completed">
                                        Mark as completed
                                    </label>
                                </div>

                                @error('is_completed')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update Reminder') }}
                                </button>
                                <a href="{{ route('reminders.show', $reminder) }}" class="btn btn-secondary">
                                    {{ __('Cancel') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 