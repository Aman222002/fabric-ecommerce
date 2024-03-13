<!DOCTYPE html>
<html>
<head>
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
        }
        h4, h5 {
            color: #666;
        }
        p {
            margin: 10px 0;
            color: #777;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        ul li {
            margin-bottom: 5px;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Hello {{ $name }},</h2>
        <h4>Email {{ $email }},</h4>
        <h5>Phone {{ $phone }},</h5>
        <p>You have been invited to join our platform!</p>
        <p>Your company Detail is: {{ $company_name }}</p>
        @if(is_array($permission))
            <p>Your permission level:</p>
            <ul>
                @foreach($permissions as $perm)
                    <li>{{ $perm }}</li>
                @endforeach
            </ul>
        @else
            <p>Your permission level: {{ $permissions }}</p>
        @endif
        <p>You Accepted this <br><a href="{{ url($url . '/' . $name . '/' . $company . '/' .$email. '/' . $phone. '/' .urlencode(json_encode($permission))) }}">click here</a></p>
        <p>You Rejected this <br><a href="{{$url2}}">Rejected</a></p>
        <p>Thank you!</p>
    </div>
</body>
</html>
