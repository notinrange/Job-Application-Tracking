<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Status Update</title>
</head>
<body class="bg-gray-100 p-4">
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">
            @if($candidate->status === 'approved')
                Congratulations!
            @else
                Application Update
            @endif
        </h1>
        <p>Dear {{ $candidate->name }},</p>
        @if($candidate->status === 'approved')
            <p>We are pleased to inform you that your application for the position of <strong>{{ $candidate->job_designation }}</strong> has been approved.</p>
        @else
            <p>We regret to inform you that your application for the position of <strong>{{ $candidate->job_designation }}</strong> has been rejected.</p>
        @endif
        <p>Thank you for your interest.</p>
        <p>Best regards,</p>
        <p>The Hiring Team</p>
    </div>
</body>
</html>
