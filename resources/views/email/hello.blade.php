<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration Confirmation</title>
    <style>
        /* Email Body */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        
        /* Container */
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        /* Header */
        .header {
            background: #e2e2e2;
            border-bottom: 6px solid green;
            padding: 20px;
            text-align: center;
        }
        
        /* Content */
        .content {
            padding: 20px 0;
        }
        
        /* Button */
        .btn {
            display: inline-block;
            background: #007bff;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
        }
        
        .btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Registration Confirmation</h2>
        </div>
        <div class="content">
            <p>Hello, {{$name}},</p>
            <p>Thank you for registering with us.</p>
            <p>If you did not register on our site, you can ignore this email.</p>
            <p><strong>Thank You.</strong></p>
        </div>
    </div>
</body>
</html>
