<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login | SI Jurnal PKL SMKN 2 Kota Jambi</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ asset('template/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/iCheck/square/blue.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700">
    <style>
        body {
            background: #e9ecef;
            font-family: 'Source Sans Pro', sans-serif;
        }
        .login-box {
            margin-top: 60px;
        }
        .login-logo img {
            width: 90px;
            margin-bottom: 10px;
        }
        .login-box-body {
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            padding: 30px 25px 20px 25px;
        }
        .login-box-msg {
            font-size: 18px;
            margin-bottom: 18px;
            color: #495057;
        }
        .btn-primary {
            background-color: #0073b7;
            border-color: #0073b7;
        }
        .register-link {
            margin-top: 15px;
            display: block;
            text-align: center;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #888;
            font-size: 14px;
        }
    </style>
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <img src="{{ asset('img/logo.jpg') }}" alt="Logo SMKN 2 Kota Jambi">
            <div style="font-size:20px;font-weight:600;margin-top:8px;">SI Jurnal PKL SMKN 2 Kota Jambi</div>
        </div>
        <div class="login-box-body">
            @if(session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin-bottom:0;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <p class="login-box-msg">Silakan login untuk memulai sesi Anda</p>            <form action="{{ route('login') }}" method="post">
                @csrf
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Username / NISN / NIP" name="login" value="{{ old('login') }}" required autofocus>
                    <span class="fa fa-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Password" name="password" required>
                    <span class="fa fa-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-7">
                        
                    </div>
                    <div class="col-xs-5">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
                    </div>
                </div>            </form>
            
            <div style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 5px; font-size: 13px;">
              
                
                <div style="border-top: 1px solid #dee2e6; padding-top: 10px;">
                    <div style="margin-bottom: 8px;"><strong>Akun Testing:</strong></div>
                    <div style="font-size: 12px;">
                        <strong>Admin:</strong> admin / password<br>
                        <strong>Guru:</strong> guru1 / password<br>
                        <strong>Siswa:</strong> siswa1 / password<br>
                        <strong>Pimpinan:</strong> pimpinan / password
                    </div>
                </div>
            </div>
            
            <a href="{{ route('password.request') }}" class="register-link">Lupa password?</a>
            <a href="{{ route('register') }}" class="register-link">Daftar akun baru</a>
        </div>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} SMKN 2 Kota Jambi
    </div>
    <script src="{{ asset('template/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('template/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('template/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(function() {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%'
            });
        });
    </script>
</body>
</html>

