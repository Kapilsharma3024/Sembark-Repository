<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></head>
@if(session('success'))
<div class="alert alert-success">{{ session('success')}}</div>
@elseif(session('error'))
<div class="alert alert-danger">{{session('error')}}</div>
@endif
<body style="font-family:Arial; text-align:center; margin-top:6%;">
    <h2>Login</h2>

    @if ($errors->any())
        <p style="color:red;">{{ $errors->first() }}</p>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <p>
            <label>Email</label><br>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus>
        </p>
        <p>
            <label>Password</label><br>
            <input type="password" name="password" required>
        </p>
        <button type="submit">Login</button>
    </form>
</body>
</html>