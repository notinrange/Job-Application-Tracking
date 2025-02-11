@extends('layouts.app')

@section('title', 'Application Detail')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-4 sm:p-6 md:p-8 rounded shadow">
    <h1 class="text-xl sm:text-2xl font-bold mb-4">Application Detail</h1>
    <div class="space-y-2 text-base sm:text-lg">
        <p><strong>Name:</strong> {{ $candidate->name }}</p>
        <p><strong>Email:</strong> {{ $candidate->email }}</p>
        <p><strong>Job Designation:</strong> {{ $candidate->job_designation }}</p>
        <p><strong>City:</strong> {{ $candidate->city }}</p>
        <p><strong>College/University:</strong> {{ $candidate->college }}</p>
        <p><strong>Graduation Year:</strong> {{ $candidate->graduation_year }}</p>
        <p><strong>Status:</strong> {{ ucfirst($candidate->status) }}</p>
        <p>
            <strong>Resume:</strong>
            <a href="{{ asset('storage/' . $candidate->resume_path) }}" target="_blank" class="text-blue-500 hover:underline">
                View Resume
            </a>
        </p>
    </div>
    <a href="{{ route('hr.applications') }}" class="mt-6 inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-colors">
        Back to Applications
    </a>
</div>
@endsection
