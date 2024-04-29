<!DOCTYPE html>
<html>
<head>
    <title>Rejection Message</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .message-container {
            text-align: center;
        }
        .message-container img {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="message-container">
        <img src="/storage/assest/rejected.jpg" alt="Rejected" width="150">
        @if(isset($message))
            <p>{{ $message }}</p>
        @elseif(isset($error))
            <p>{{ $error }}</p>
        @endif
    </div>
</body>
</html>
