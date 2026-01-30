<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Create Short URL</title></head>
<body style="font-family:Arial; margin:20px;">

    <h2>Create Short URL</h2>

    <form method="POST" action="{{ route('short-url.store') }}">
        @csrf
        <p>
            <input type="url" name="original_url" placeholder="https://very-long-url-here.com/..." required style="width:600px;">
        </p>
        <button type="submit">Generate Short Link</button>
    </form>

    <br><a href="{{ route('dashboard') }}">Dashboard</a>
</body>
</html>