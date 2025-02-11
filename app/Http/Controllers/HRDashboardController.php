<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use Carbon\Carbon;

class HRDashboardController extends Controller
{
    public function index()
    {
        // For "Total Job Postings", we’ll count distinct job designations from candidate applications.
        // (In a real app you might have a separate JobPosting model.)
        $totalJobPostings = Candidate::distinct('job_designation')->count('job_designation');
        $applicationsLast30Days = Candidate::where('created_at', '>=', Carbon::now()->subDays(30))->count();
        $pendingApplications = Candidate::where('status', 'pending')->count();
        $approvedApplications = Candidate::where('status', 'approved')->count();
        $rejectedApplications = Candidate::where('status', 'rejected')->count();

        return view('hr.dashboard', compact(
            'totalJobPostings',
            'applicationsLast30Days',
            'pendingApplications',
            'approvedApplications',
            'rejectedApplications'
        ));
    }
}
