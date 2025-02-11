@extends('layouts.app')

@section('title', 'HR Dashboard')

@section('content')
<!-- Alpine.js component for toggling sidebar -->
<div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <div :class="{'-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen}"
         class="fixed inset-y-0 left-0 w-64 bg-white shadow transform transition-transform duration-200 ease-in-out md:static md:translate-x-0">
        <div class="p-4 border-b">
            <h2 class="text-xl font-bold">HR Navigation</h2>
        </div>
        <ul class="mt-4">
            <li class="mb-2">
                <a href="{{ route('hr.dashboard') }}" class="block py-2 px-4 hover:bg-gray-200">Dashboard Home</a>
            </li>
            <li class="mb-2">
                <a href="{{ route('hr.applications') }}" class="block py-2 px-4 hover:bg-gray-200">Application Tracking</a>
            </li>
            <li class="mb-2">
                <a href="{{ route('hr.reports') }}" class="block py-2 px-4 hover:bg-gray-200">Reports</a>
            </li>
            <form action="{{ route('hr.logout') }}" method="POST">
                @csrf
                <button type="submit" class="block py-2 px-4 hover:bg-gray-200">Logout</button>
            </form>
            
        </ul>
    </div>

    <!-- Main Content -->
    <div class="flex-1 md:ml-64 p-4">
        <!-- Mobile: Hamburger button -->
        <div class="md:hidden mb-4">
            <button @click="sidebarOpen = !sidebarOpen" class="text-gray-600 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
        
        <!-- Dashboard Content -->
        <h1 class="text-2xl font-bold mb-4">Dashboard Overview</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="p-4 bg-gray-100 rounded shadow">
                <p class="text-lg font-semibold">Total Job Postings</p>
                <p class="text-2xl">{{ $totalJobPostings }}</p>
            </div>
            <div class="p-4 bg-gray-100 rounded shadow">
                <p class="text-lg font-semibold">Applications Last 30 Days</p>
                <p class="text-2xl">{{ $applicationsLast30Days }}</p>
            </div>
            <div class="p-4 bg-gray-100 rounded shadow">
                <p class="text-lg font-semibold">Pending Applications</p>
                <p class="text-2xl">{{ $pendingApplications }}</p>
            </div>
            <div class="p-4 bg-gray-100 rounded shadow">
                <p class="text-lg font-semibold">Approved Applications</p>
                <p class="text-2xl">{{ $approvedApplications }}</p>
            </div>
            <div class="p-4 bg-gray-100 rounded shadow">
                <p class="text-lg font-semibold">Rejected Applications</p>
                <p class="text-2xl">{{ $rejectedApplications }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
