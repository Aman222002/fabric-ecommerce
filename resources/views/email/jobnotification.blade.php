<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Notification Email</title>
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
        h1 {
            color: #333;
        }
        p {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Hello {{ $mailData['company']->name }},</h1>
        
        <p>Here is the notification for the job:</p>

        <h2>Job Title: {{ $mailData['job']->title }}</h2>

        <h3>Employee Details:</h3>
        
        <p><strong>Name:</strong> {{ $mailData['user']->name }}</p>
        <p><strong>Email:</strong> {{ $mailData['user']->email }}</p>
        <p><strong>Mobile No:</strong> {{ $mailData['user']->phone }}</p>
        
       

        <p>Thank you,</p>
        <p>Your Company Team</p>
    </div>
</body>
</html>
