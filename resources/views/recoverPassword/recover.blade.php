<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recover Your Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000;
            color: #fff;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }
        .header {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .content {
            background-color: #333;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            color: #ddd;
        }
        .content p {
            margin: 10px 0;
            font-size: 18px;
        }
        .token {
            font-weight: bold;
            font-size: 22px;
            color: #ff9900;
        }
        .expire-time {
            font-size: 18px;
            color: #bbb;
        }
        .footer {
            font-size: 14px;
            color: #888;
            margin-top: 30px;
        }
        .footer a {
            color: #ff9900;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            Hello, {{ $user->name }}!
        </div>

        <div class="content">
            <p>We received a request to reset your password. Below are the details:</p>

            <p>Your token: <span class="token">{{ $token->token }}</span></p>
            <p class="expire-time">This token will expire in {{ \Carbon\Carbon::parse($token->expire_at)->diffForHumans() }}.</p>
        </div>

        <div class="footer">
            <p>If you did not request a password reset, please ignore this message.</p>
            <p>For more help, visit our <a href="#">support page</a>.</p>
        </div>
    </div>
</body>
</html>
