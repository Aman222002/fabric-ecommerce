
<!DOCTYPE html>
<html>
<head>
    <title>Invitation</title>
</head>
<body>
    <h2>Hello {{ $name }},</h2>
    <h4>Email {{ $email }},</h4>
    <h5>Phone {{ $phone }},</h5>
    <p>You have been invited to join our platform!</p>
    <p>Your company Detail is: {{ $company }}</p>
    @if(is_array($permission))
        <p>Your permission level:</p>
        <ul>
            @foreach($permission as $perm)
                <li>{{ $perm }}</li>
            @endforeach
        </ul>
    @else
        <p>Your permission level: {{ $permission }}</p>
    @endif
    <p>You  Accepted this<a href="{{ url($url . '/' . $name . '/' . $company . '/' .$email. '/' . $phone. '/' .urlencode(json_encode($permission))) }}" >click here</a> </p>
    <p>You  Rejected this<a href="{{$url2
    }}">Rejected</a> </p>
    <p>Thank you!</p>
</body>
</html>
