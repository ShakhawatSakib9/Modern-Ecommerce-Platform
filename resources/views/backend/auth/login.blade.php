<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Admin Login | {{ config('app.name', 'Innoflexia') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            width: 380px;
        }

        .card {
            border-radius: 14px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, .15);
        }

        .login-logo {
            font-weight: 600;
            margin-bottom: 15px;
            color: #fff;
            text-align: center;
        }

        .login-logo small {
            display: block;
            font-size: 14px;
            opacity: .9;
        }

        .form-control {
            border-radius: 8px;
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-login:hover {
            opacity: .9;
        }
    </style>
</head>

<body>

    <div class="login-box">
        <div class="login-logo">
            {{ config('app.name', 'Innoflexia') }}
            <small>Admin Panel</small>
        </div>

        <div class="card">
            <div class="card-body">

                <p class="text-center mb-4 text-muted">Sign in to continue</p>

                @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                    @endforeach
                </div>
                @endif

                <form method="POST" action="{{ route('admin.login.submit') }}">
                    @csrf

                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control"
                            placeholder="Email address" value="{{ old('email') }}" required>
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control"
                            placeholder="Password" required>
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Remember me</label>
                        </div>
                        <a href="javascript:void(0)" class="text-sm"
                            onclick="alert('Please contact system administrator')">
                            Forgot?
                        </a>
                    </div>

                    <button type="submit" class="btn btn-login btn-block">
                        <i class="fa fa-sign-in-alt mr-1"></i> Login
                    </button>
                </form>

                <div class="text-center mt-3">
                    <a href="{{ url('/') }}" class="text-muted text-sm">
                        ← Back to website
                    </a>
                </div>

            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

</body>

</html>