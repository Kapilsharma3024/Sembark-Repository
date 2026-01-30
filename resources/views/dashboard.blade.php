<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
@if(session('success'))
<div class="alert alert-success">{{ session('success')}}</div>
@elseif(session('error'))
<div class="alert alert-danger">{{session('error')}}</div>
@endif
<body style="font-family:Arial; margin:20px;">

    <h1>Dashboard — {{ $user->name }} ({{ ucfirst($user->role) }})</h1>

    <form action="{{ route('logout') }}" method="POST" style="float:right;">
        @csrf
        <button type="submit">Logout</button>
    </form>

    @if (session('status'))
        <p style="color:green;">{{ session('status') }}</p>
    @endif

    @if ($user->role !== 'superadmin')
        <h3>Generate Short URLs</h3>
        <form method="POST" action="{{ route('short-url.store') }}">
            @csrf
            <input type="url" name="original_url" placeholder="https://example.com/long-url" required style="width:500px;">
            <button type="submit">Generate</button>
        </form>
        <br>
    @endif

    @if ($user->role === 'superadmin')
        <h5>All Companies</h5>
        <table border="1" cellpadding="8" cellspacing="0" style="width:100%; margin-top:10px;">
            <thead>
                <tr>
                    <th>Client Name</th>
                    <th>Users</th>
                    <th>Total/Generated Urls</th>
                    <th>Total Urls Hit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($companys as $company)
                    <tr>
                        <td>{{ $company->name ?? null }}</td>
                        <td>{{ $company->users->count() ?? null }}</td>
                        <td>{{ $company->shortUrls->count() ?? null }}</td>
                        <td>{{ $company->shortUrls->sum('hit_count') ?? null }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@if(Auth::user()->role === 'superadmin')
<br>
<br>
<br>
@endif
    <h5>Generated Short Urls</h5>

    <table border="1" cellpadding="8" cellspacing="0" style="width:100%; margin-top:10px;">
        <thead>
            <tr>
                <th>Short Link</th>
                <th>Long URL</th>
                @if ($user->role !== 'member')
                    <th>Created by</th>
                @endif
                @if ($user->role === 'superadmin')
                    <th>Company</th>
                @endif
                <th>Hits</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
           
             @foreach ($urls as $url)
                <tr>
                    {{-- <td><a href=" {{ route('short.redirect',$url->short_code) }}  {{ url('/s/' . $url->short_code) }}" target="_blank">/s/{{ $url->short_code }} {{ route('short.redirect',$url->short_code) }}</a></td> --}}
                    <td><a href=" {{ route('short.redirect',$url->short_code) }} " target="_blank">/s/{{ $url->short_code }}</a></td>
                    <td style="word-break:break-all;">{{ $url->original_url }}</td>
                    @if ($user->role !== 'member')
                        <td>{{ $url->user->name }}</td>
                    @endif
                    @if ($user->role === 'superadmin')
                        <td>{{ $url->company->name ?? '—' }}</td>
                    @endif
                    <td>{{ $url->hit_count ?? 0 }}</td>
                    <td>{{ $url->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    @if (in_array($user->role, ['superadmin','admin']))
        <a class="btn btn-primary" href="{{ route('invite.create') }}">Invite</a> 
    @endif
     @if ($user->role !== 'superadmin')
        <a class="btn btn-primary" href="{{ route('short-url.create') }}">Create short URL</a>
    @endif
        
    <div>
        {{ $urls->links() }}
    </div>
    <br>
    

    @if($user->role === 'admin')
    <h2>Team Members</h2>

        <table border="1" cellpadding="8" cellspacing="0" style="width:100%; margin-top:10px;">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Total Generate Urls</th>
                    <th>Total URL Hits</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($members as $member)
                    <tr>
                        <td>{{ $member->name}}</td>
                        <td>{{ $member->email}}</td>
                        <td>{{ $member->role}}</td>
                        <td>{{ $member->shortUrls->count()}}</td>
                        <td>{{ $member->shortUrls->sum('hit_count') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>