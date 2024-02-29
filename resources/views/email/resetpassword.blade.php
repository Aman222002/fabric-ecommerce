<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
        }
        p {
            margin-bottom: 20px;
            line-height: 1.6;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 3px;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Reset Password Link</h2>
        <p>Hello {{ $user['name'] }},</p>
        <p>You are receiving this email because we received a password reset request for your account.</p>
        <a class="btn" href="{{$url}}">Reset Password</a>
        <p>If you did not request a password reset, no further action is required.</p>
        <p>Thanks, {{ config('app.name') }}</p>
    </div>
</body>
</html>
