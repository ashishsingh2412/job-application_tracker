@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Job Applications') }}</span>
                    <a href="{{ route('job-applications.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Add New Application
                    </a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($jobApplications->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Company</th>
                                        <th>Position</th>
                                        <th>Location</th>
                                        <th>Applied On</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jobApplications as $application)
                                        <tr>
                                            <td>{{ $application->company_name }}</td>
                                            <td>{{ $application->position }}</td>
                                            <td>{{ $application->location ?? 'N/A' }}</td>
                                            <td>{{ $application->application_date->format('M d, Y') }}</td>
                                            <td>
                                                <span class="badge bg-{{ 
                                                    $application->status == 'applied' ? 'secondary' : 
                                                    ($application->status == 'interview' ? 'info' : 
                                                    ($application->status == 'offer' ? 'success' : 
                                                    ($application->status == 'rejected' ? 'danger' : 
                                                    ($application->status == 'accepted' ? 'primary' : 'warning')))) 
                                                }}">
                                                    {{ ucfirst($application->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('job-applications.show', $application) }}" class="btn btn-info btn-sm">View</a>
                                                    <a href="{{ route('job-applications.edit', $application) }}" class="btn btn-primary btn-sm">Edit</a>
                                                    <form action="{{ route('job-applications.destroy', $application) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this application?')">Delete</button>
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
                            <h5>No job applications yet</h5>
                            <p>Start tracking your job search by adding your first application.</p>
                            <a href="{{ route('job-applications.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add Job Application
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 