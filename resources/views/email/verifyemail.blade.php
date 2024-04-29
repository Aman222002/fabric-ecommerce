<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verification Email</title>
</head>
<body>
    <h2>Welcome, {{ $user->name }}!</h2>

    <p>
        Thank you for registering with us. To verify your email address, please click on the link below:
    </p>

    <a href="{{ $verificationUrl }}">Verify Email Address</a>

    <p>
        If you did not sign up for an account, please ignore this email.
    </p>

    <p>
        Regards,<br>
        Your Website Team
    </p>
</body>
</html>
