<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CandidateSubmissionMail;
use App\Mail\ApplicationActionMail;

class CandidateController extends Controller
{
    /**
     * Display the candidate application form.
     */
    public function create()
    {
        return view('candidate.apply');
    }

    /**
     * Store a new candidate application.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'             => 'required|string',
            'email'            => 'required|email',
            'job_designation'  => 'required|string',
            'city'             => 'nullable|string',
            'college'          => 'nullable|string',
            'graduation_year'  => 'nullable|string',
            'resume'           => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('resume')) {
            $path = $request->file('resume')->store('resumes', 'public');
            $validated['resume_path'] = $path;
        }

        $candidate = Candidate::create($validated);

        // Send a thank-you email to the candidate
        Mail::to($candidate->email)->send(new CandidateSubmissionMail($candidate));

        return redirect()->route('candidate.thankyou')
            ->with('success', 'Application submitted successfully.');
    }

    /**
     * List all candidate applications (for HR dashboard).
     */
    public function index(Request $request)
    {
        $query = Candidate::query();

        if ($request->filled('job')) {
            $query->where('job_designation', 'like', '%' . $request->job . '%');
        }
        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }
        if ($request->filled('college')) {
            $query->where('college', 'like', '%' . $request->college . '%');
        }
        if ($request->filled('graduation_year')) {
            $query->where('graduation_year', $request->graduation_year);
        }

        $applications = $query->get();

        return view('hr.applications', compact('applications'));
    }

    /**
     * Display the details of a single candidate application.
     */
    public function show($id)
    {
        $candidate = Candidate::findOrFail($id);
        return view('hr.application_detail', compact('candidate'));
    }

    /**
     * Update a candidate's status (approve/reject) and send notification.
     */
    public function update(Request $request, $id)
    {
        $candidate = Candidate::findOrFail($id);
        $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);

        $candidate->update(['status' => $request->status]);

        // Send an email based on the new status
        Mail::to($candidate->email)->send(new ApplicationActionMail($candidate));

        return redirect()->route('hr.applications')
            ->with('success', 'Application updated successfully.');
    }
}
