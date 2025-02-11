@extends('layouts.app')

@section('title', 'Apply for Job')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Job Application</h1>
    <form action="{{ route('candidate.store') }}" method="POST" enctype="multipart/form-data" x-data="{ resumeName: '' }">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700">Name</label>
            <input type="text" name="name" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Email</label>
            <input type="email" name="email" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Job Designation</label>
            <input type="text" name="job_designation" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">City</label>
            <input type="text" name="city" class="w-full border rounded p-2">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">College/University</label>
            <input type="text" name="college" class="w-full border rounded p-2">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Graduation Year</label>
            <input type="text" name="graduation_year" class="w-full border rounded p-2">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Resume</label>
            <input type="file" name="resume" class="w-full" x-on:change="resumeName = $event.target.files[0].name" accept=".pdf,.doc,.docx" required>
            <span x-text="resumeName" class="text-sm text-gray-500"></span>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit Application</button>
    </form>
</div>
@endsection
