<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
            margin-bottom: 10px;
        }
        p {
            margin: 10px 0;
            color: #777;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .button {
            display: inline-block;
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Hello {{ $name }},</h2>
        <p>You have been invited to join our platform.</p>
        <p>Please review the details below:</p>
        <ul>
            <li><strong>Email:</strong> {{ $email }}</li>
            <li><strong>Phone:</strong> {{ $phone }}</li>
            <li><strong>Company:</strong> {{ $company_name }}</li>
            <li><strong>Permission Level:</strong> 
                @if(is_array($permission))
                    <ul>
                        @foreach($permissions as $perm)
                            <li>{{ $perm }}</li>
                        @endforeach
                    </ul>
                @else
                    {{ $permissions }}
                @endif
            </li>
        </ul>
        <p>To accept this invitation, click the button below:</p>
        <p>
            <a href="{{ url($url . '/' . $name . '/' . $company . '/' .$email. '/' . $phone. '/' .urlencode(json_encode($permission))) }}" class="button">Accept Invitation</a>
        </p>
        <p>If you wish to decline this invitation, click the following link:</p>
        <p>
            <a href="{{$url2}}" class="button">Decline Invitation</a>
        </p>
        <p>Thank you!</p>
    </div>
</body>
</html>
