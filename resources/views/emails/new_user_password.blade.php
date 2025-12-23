<!DOCTYPE html>
<html>
<head>
    <title>Your Account Password</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2 style="color: #2563eb;">Welcome to Darpon Institute!</h2>
        
        <p>Dear {{ $user->name }},</p>
        
        <p>Thank you for enrolling in our course. An account has been created for you to access your course materials.</p>
        
        <div style="background-color: #f3f4f6; padding: 15px; border-radius: 8px; margin: 20px 0;">
            <p style="margin: 0; font-weight: bold;">Your Login Credentials:</p>
            <p style="margin: 5px 0;">Email: {{ $user->email }}</p>
            <p style="margin: 5px 0;">Password: <strong>{{ $password }}</strong></p>
        </div>
        
        <p>Please log in and change your password as soon as possible.</p>
        
        <p style="margin-top: 30px;">
            <a href="{{ route('login') }}" style="background-color: #2563eb; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">Login to Dashboard</a>
        </p>
        
        <p style="margin-top: 30px; font-size: 0.9em; color: #666;">
            Best regards,<br>
            The Darpon Institute Team
        </p>
    </div>
</body>
</html>
