@extends('layouts.app')

@section('title', 'Application Tracking')

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
    <div class="flex-1 md:ml-64 p-4" x-data="filterApps({{ $applications->toJson() }})">
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
        
        <h1 class="text-2xl font-bold mb-4">Application Tracking</h1>
        
        <!-- Filters (responsive grid) -->
        <div class="mb-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <input type="text" x-model="filters.job" placeholder="Filter by Job" class="border p-2 rounded">
            <input type="text" x-model="filters.city" placeholder="Filter by City" class="border p-2 rounded">
            <input type="text" x-model="filters.college" placeholder="Filter by College/University" class="border p-2 rounded">
            <input type="text" x-model="filters.graduation_year" placeholder="Filter by Graduation Year" class="border p-2 rounded">
        </div>
        
        <!-- Application Table (scrollable on small screens) -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border">Name</th>
                        <th class="py-2 px-4 border">Email</th>
                        <th class="py-2 px-4 border">Job Designation</th>
                        <th class="py-2 px-4 border">Status</th>
                        <th class="py-2 px-4 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Use Alpine's template directive to loop through the filtered applications -->
                    <template x-for="app in filteredApplications" :key="app.id">
                        <tr>
                            <td class="py-2 px-4 border" x-text="app.name"></td>
                            <td class="py-2 px-4 border" x-text="app.email"></td>
                            <td class="py-2 px-4 border" x-text="app.job_designation"></td>
                            <td class="py-2 px-4 border" x-text="app.status.charAt(0).toUpperCase() + app.status.slice(1)"></td>
                            <td class="py-2 px-4 border">
                                <a :href="'{{ url('/hr/application') }}/' + app.id" class="text-blue-500 mr-2">View</a>
                                <!-- Show action buttons only if status is pending -->
                                <template x-if="app.status === 'pending'">
                                    <div class="inline">
                                        <!-- Approve Form -->
                                        <form :action="'{{ url('/hr/application') }}/' + app.id + '/update'" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="text-green-500 mr-2">Approve</button>
                                        </form>
                                        <!-- Reject Form -->
                                        <form :action="'{{ url('/hr/application') }}/' + app.id + '/update'" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="text-red-500">Reject</button>
                                        </form>
                                    </div>
                                </template>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Alpine.js component for filtering -->
<script>
function filterApps(applications) {
    return {
        // All applications passed from the server as JSON
        applications: applications,
        // Filter criteria
        filters: {
            job: '',
            city: '',
            college: '',
            graduation_year: ''
        },
        // Computed property that filters applications based on current filters
        get filteredApplications() {
            return this.applications.filter(app => {
                let matchesJob = this.filters.job === '' || app.job_designation.toLowerCase().includes(this.filters.job.toLowerCase());
                let matchesCity = this.filters.city === '' || (app.city && app.city.toLowerCase().includes(this.filters.city.toLowerCase()));
                let matchesCollege = this.filters.college === '' || (app.college && app.college.toLowerCase().includes(this.filters.college.toLowerCase()));
                let matchesGraduation = this.filters.graduation_year === '' || (app.graduation_year && app.graduation_year.toLowerCase().includes(this.filters.graduation_year.toLowerCase()));
                return matchesJob && matchesCity && matchesCollege && matchesGraduation;
            });
        }
    }
}
</script>
@endsection
