@extends('layouts.app')

@section('title', 'HR Reports')

@section('content')
<div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <div :class="{'-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen}"
         class="fixed inset-y-0 left-0 w-64 bg-white shadow transform transition-transform duration-200 ease-in-out z-50 md:static md:translate-x-0">
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
            <li class="mb-2">
                <form action="{{ route('hr.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left py-2 px-4 hover:bg-gray-200">Logout</button>
                </form>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="flex-1 md:ml-64 p-4 overflow-y-auto">
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
        
        <h1 class="text-2xl font-bold mb-4">HR Reports</h1>
        
        <!-- Average Time Report -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold">Average Time to Action (Approval/Rejected)</h2>
            <p class="text-lg">{{ $averageTimeInHours }} hours</p>
        </div>

        <!-- Job Designation Trend Report -->
        <div>
            <h2 class="text-xl font-semibold mb-4">Job Designation Trend (Applications in Last 30 Days)</h2>
            <div class="w-full overflow-x-auto">
                <canvas id="jobTrendChart" class="w-full"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('jobTrendChart').getContext('2d');
    const jobTrendChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($jobLabels) !!},
            datasets: [{
                label: 'Number of Applications',
                data: {!! json_encode($jobCounts) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
});
</script>
@endsection
