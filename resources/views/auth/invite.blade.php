<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Invite User</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></head>
@if(session('success'))
<div class="alert alert-success">{{ session('success')}}</div>
@elseif(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<body style="font-family:Arial; margin:20px;">

    <h2>Invite New {{ Auth::user()->role === 'superadmin' ? 'Client' : 'Team Member' }}</h2>

    <form method="POST" action="{{ route('invite.store') }}">
        @csrf

        <p><label>Name</label><br><input type="text" name="name" value="{{ old('name') }}" required></p>
        <p><label>Email</label><br><input type="email" name="email" value="{{ old('email') }}" required></p>
        <p><label>Password</label><br><input type="password" name="password" required></p>
        <p><label>Confirm Password</label><br><input type="password" name="password_confirmation" required> </p>

        @if (Auth::user()->role === 'superadmin')
            <p><label>Company Name</label><br><input type="text" name="company_name" required></p>
        @else
            <p>
                <label>Role</label><br>
                <select name="role">
                    <option value="admin">Admin</option>
                    <option value="member">Member</option>
                </select>
            </p>
        @endif

        <button class="btn btn-success" type="submit">{{ Auth::user()->role === 'superadmin' ?'Create Client' : 'Create Team Member'}}</button>
    </form>

    <br><a class="btn btn-primary" href="{{ route('dashboard') }}">Back to Dashboard</a>
</body>
</html>