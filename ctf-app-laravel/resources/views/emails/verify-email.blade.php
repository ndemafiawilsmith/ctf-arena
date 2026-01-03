<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email - CTF Arena</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            background-color: #0d0015;
            color: #e0e0e0;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid rgba(0, 255, 65, 0.2);
        }

        .logo {
            color: #00ff41;
            font-size: 24px;
            font-weight: bold;
            text-decoration: none;
            letter-spacing: 2px;
        }

        .content {
            padding: 40px 20px;
            background: linear-gradient(135deg, #1a0b2e 0%, #0d0015 100%);
            border: 1px solid rgba(0, 255, 65, 0.1);
            border-radius: 8px;
            margin-top: 20px;
            text-align: center;
        }

        h1 {
            color: #ffffff;
            font-size: 24px;
            margin-bottom: 20px;
        }

        p {
            color: #a0a0a0;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .button {
            display: inline-block;
            padding: 15px 30px;
            background-color: #00ff41;
            color: #000000;
            text-decoration: none;
            font-weight: bold;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #00cc33;
        }

        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #666666;
            margin-top: 20px;
        }

        .verification-code {
            background-color: rgba(0, 255, 65, 0.1);
            color: #00ff41;
            padding: 5px 10px;
            border-radius: 4px;
            font-family: monospace;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <a href="{{ url('/') }}" class="logo">CTF_ARENA</a>
        </div>

        <div class="content">
            <h1>INITIATE SEQUENCE: VERIFY_EMAIL</h1>

            <p>
                Agent <strong>{{ $notifiable->name }}</strong>,<br>
                Security protocol requires email verification to access classified challenges.
            </p>

            <a href="{{ $url }}" class="button">VERIFY ACCESS</a>

            <p style="margin-top: 30px; font-size: 14px;">
                Or copy-paste this link into your terminal:<br>
                <span style="color: #00ff41; word-break: break-all;">{{ $url }}</span>
            </p>
        </div>

        <div class="footer">
            <p>
                &copy; {{ date('Y') }} CTF_ARENA. All rights reserved.<br>
                This is an automated security transmission.
            </p>
        </div>
    </div>
</body>

</html>