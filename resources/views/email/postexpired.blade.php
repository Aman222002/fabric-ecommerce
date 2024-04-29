<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Expiry Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        p {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <p>Dear {{ $user->name }},</p>
        <p>Your posted job "<strong>{{ $title }}</strong>" has expired today. Please repost your job to keep it active and visible to potential candidates. It will be deleted in the next 5 days.</p>
        <p>Thank you for using our platform.</p>
        <p>Sincerely,<br>{{ config('app.name') }}</p>
    </div>
</body>
</html>
