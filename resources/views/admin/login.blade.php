<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-5">
                <h1 class="mb-4">Admin Login</h1>


    @if ($errors->any())
        <div style="background:#ffecec;border:1px solid #ff6b6b;padding:12px 16px;margin:12px 0;">
            <ul style="margin:0;padding-left:18px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

<form method="POST" action="{{ route('admin.login.post') }}">
        @csrf

        <div style="margin: 12px 0;">
            <label>Email</label><br>
            <input type="email" name="email" value="{{ old('email') }}" required style="padding:8px;width:320px;">
        </div>

        <div style="margin: 12px 0;">
            <label>Password</label><br>
            <input type="password" name="password" required style="padding:8px;width:320px;">
        </div>

        <button type="submit" style="padding:10px 14px; background:#111; color:#fff; border:none; cursor:pointer;">
            Login
        </button>
    </form>

    <div class="mt-3 text-center">
        <a href="{{ route('admin.register') }}">Create admin account</a>
    </div>
</body>
</html>


