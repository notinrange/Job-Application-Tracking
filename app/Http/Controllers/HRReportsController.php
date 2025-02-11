<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use Carbon\Carbon;
use DB;

class HRReportsController extends Controller
{
    public function index()
    {
        // Calculate the average time (in seconds) from submission (created_at) to action (updated_at)
        // for candidates that have been approved or rejected.
        $avgTimeInSeconds = Candidate::whereIn('status', ['approved', 'rejected'])
            ->select(DB::raw('AVG(TIMESTAMPDIFF(SECOND, created_at, updated_at)) as avg_seconds'))
            ->value('avg_seconds');

        // Convert average time to hours (round to 2 decimal places) or 0 if no data exists.
        $averageTimeInHours = $avgTimeInSeconds ? round($avgTimeInSeconds / 3600, 2) : 0;

        // Get the job designation trend data: number of applications per job designation in the last 30 days.
        $jobTrendData = Candidate::where('created_at', '>=', Carbon::now()->subDays(30))
            ->select('job_designation', DB::raw('COUNT(*) as count'))
            ->groupBy('job_designation')
            ->get();

        // Prepare arrays for Chart.js.
        $jobLabels = $jobTrendData->pluck('job_designation');
        $jobCounts = $jobTrendData->pluck('count');

        return view('hr.reports', compact('averageTimeInHours', 'jobLabels', 'jobCounts'));
    }
}
