<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Received</title>
</head>
<body>
    <h1>Thank You for Your Application!</h1>
    <p>Dear {{ $candidate->name }},</p>
    <p>We have received your application for the position of {{ $candidate->job_designation }}. Our team will review your application and get back to you soon.</p>
    <p>Best regards,</p>
    <p>The Hiring Team</p>
</body>
</html>
