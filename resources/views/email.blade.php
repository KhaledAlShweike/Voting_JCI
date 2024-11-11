<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verify Your Email Address</title>
</head>
<body>
    <h1>Hello, {{ $user->name }}</h1>
    <p>Thank you for registering. Please verify your email address by clicking the button below.</p>
    <p>
        <a href="{{ $verificationUrl }}" style="background-color: #3490dc; color: white; padding: 10px 20px; text-decoration: none;">
            Verify Email
        </a>
    </p>
    <p>If you did not create an account, no further action is required.</p>
    <p>Regards,<br>{{ config('app.name') }}</p>
</body>
</html>
