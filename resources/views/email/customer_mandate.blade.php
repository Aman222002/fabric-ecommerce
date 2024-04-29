<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Subscription Confirmation</title>
    <style>
        
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        
        
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
     
        .content {
            padding: 20px 0;
        }
        
       
        .btn {
            display: inline-block;
            background: #007bff;
            color: white;
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
        <p>Dear Customer,</p>
        <div class="content">
            <p>Please click the link below to open the Buy Subscription:</p>
            <a href="{{$url}}" class="btn">Click Here</a>
        </div>
        <p>Best regards,<br>JOBS</p>
    </div>
</body>
</html>
