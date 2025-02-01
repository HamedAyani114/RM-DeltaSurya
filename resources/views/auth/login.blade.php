<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }} | {{ $pageTitle }} </title>

    {{-- favicon --}}
    <link rel="shortcut icon" href="{{ env('APP_ICON') }}" type="image/x-icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ env('ICON') }}">
    <link rel="stylesheet" href="/css/toastr.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/css/adminlte.min.css">
    <style>
        .divider:after,
        .divider:before {
        content: "";
        flex: 1;
        height: 1px;
        background: #eee;
        }
        .h-custom {
        height: calc(100% - 73px);
        }
        @media (max-width: 450px) {
        .h-custom {
        height: 100%;
        }
        }
    </style>
</head>

<body class="hold-transition login-page">
    @if ($errors->any())
    <div id="toast-container" class="toast-top-center" style="margin-top: 3rem">
        <div class="toast toast-error" aria-live="assertive" style="display: block;">
            <ul class="mt-2" style="margin-left: -.5rem">
                @foreach ($errors->all() as $error)
                <li class="toast-message">{{ $error }}</li>
                @endforeach
            </ul>
            {{-- <div class="toast-message">{{ $error }}</div> --}}
        </div>
    </div>
    @endif
<section class="vh-100">
    <div class="container-fluid h-custom">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-9 col-lg-6 col-xl-5">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                    class="img-fluid" alt="Sample image">
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                <form method="POST" action="{{ route('loginStore') }}">
                    @csrf
                    <div class="divider d-flex align-items-center my-4">
                        <h1 class="text-center fw-bold mx-3 mb-0">RS DELTA SURYA</h1>
                    </div>
                    <!-- Email input -->
                    <div class="form-outline mb-2">
                        <label class="form-label" for="username">Username</label>
                        <input type="text" name="username" id="username"
                            class="form-control form-control-lg @error('username') is-invalid @enderror"
                            placeholder="Enter a valid username" autofocus required value="{{ old('username') }}" />
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-3">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control form-control-lg"
                            placeholder="Enter password" required />
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <!-- Checkbox -->
                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" class="btn btn-primary btn-lg"
                                style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</section>

    {{-- <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="{{ env('APP_URL') }}" class="h1">{{ env('APP_NAME') }}</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Masukkan akun anda</p>
                <form action="{{ route('loginStore') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" class="form-control @error('username') is-invalid @enderror"
                            placeholder="Username" name="username" value="{{ old('username') }}" autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            placeholder="Password" name="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box --> --}}

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/js/toastr.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
</body>

</html>
