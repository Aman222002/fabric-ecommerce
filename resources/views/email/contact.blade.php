<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Email</title>
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
        strong {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <p><strong>Full Name:</strong> {{ $fullName }}</p>
        <p><strong>Email:</strong> {{ $Email }}</p>
        <p><strong>Subject:</strong> {{ $Subject }}</p>
        <p><strong>Message:</strong></p>
        <p>{{ $Message }}</p>
    </div>
</body>
</html>
