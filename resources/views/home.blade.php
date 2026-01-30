<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sembark URL Shortener</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f8f9fa; }
        .container { max-width: 900px; margin: 80px auto; text-align: center; padding: 40px; background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #333; }
        p { color: #555; font-size: 1.1em; line-height: 1.6; }
        .btn { display: inline-block; margin: 20px 10px; padding: 12px 30px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; }
        .btn:hover { background: #0056b3; }
        .btn-secondary { background: #6c757d; }
        .btn-secondary:hover { background: #5a6268; }
    </style>
</head>
<body>

    <div class="container">
        <h1>Sembark URL Shortener</h1>
        <p>Create short, memorable links for your long URLs.<br>
        Manage your shortened links per company / team.</p>

        <p><strong>Features:</strong></p>
        <ul style="list-style: none; padding: 0; font-size: 1.1em; color: #444;">
            <li>→ Company-based user management</li>
            <li>→ Role-based access (SuperAdmin / Admin / Member)</li>
            <li>→ Private short link lists per user/company</li>
            <li>→ Public redirection for shortened URLs</li>
        </ul>

        <div style="margin-top: 40px;">
            <a href="{{ route('login') }}" class="btn">Login to Dashboard</a>
            <!-- Optional: if you ever add public registration, you can put Register here -->
            <!-- <a href="#" class="btn btn-secondary">Learn More</a> -->
        </div>

        <p style="margin-top: 60px; font-size: 0.9em; color: #777;">
             All rights reserved by Sembark Pvt. Ltd.
        </p>
    </div>

</body>
</html>