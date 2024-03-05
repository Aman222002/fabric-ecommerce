<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Expiry Notification</title>
</head>
<body>
    <p>Dear {{ $user->name }},</p>
    <p>Your posted job "{{ $title }}" has expired today. Please repost your job to keep it active and visible to potential candidates. It will be delted in next 5 days</p>
    <p>Thank you for using our platform.</p>
    <p>Sincerely,<br>{{ config('app.name') }}</p>
</body>
</html>