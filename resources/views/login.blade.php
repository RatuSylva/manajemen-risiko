<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Risiko</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family: Arial, sans-serif;
        }

        body{
            background:#f3f3f3;
            display:flex;
            justify-content:center;
            align-items:center;
            min-height:100vh;
        }

        .container{
            width:380px;
            background:white;
            padding:30px;
            border-radius:10px;
            box-shadow:0 2px 10px rgba(0,0,0,0.1);
        }

        .logo{
            text-align:center;
            margin-bottom:15px;
        }

        .logo img{
            width:200px;
        }

        .title{
            text-align:center;
            color:#24248f;
            font-weight:bold;
            font-size:28px;
        }

        .subtitle{
            text-align:center;
            color:#666;
            margin-top:5px;
            margin-bottom:25px;
        }

        .form-group{
            margin-bottom:15px;
        }

        label{
            display:block;
            margin-bottom:5px;
            font-weight:bold;
            font-size:14px;
        }

        input{
            width:100%;
            padding:12px;
            border:1px solid #ddd;
            border-radius:5px;
        }

        .alert{
            background:#ffeaea;
            color:#c74c4c;
            padding:12px;
            border-radius:5px;
            margin-bottom:15px;
            font-size:14px;
        }

        .btn-login{
            width:100%;
            padding:12px;
            border:none;
            background:#1500a8;
            color:white;
            border-radius:5px;
            font-weight:bold;
            cursor:pointer;
        }

        .footer{
            text-align:center;
            margin-top:20px;
            color:#777;
            font-size:13px;
        }
    </style>
</head>
<body>

<div class="container">

    <div class="logo">
        <img src="{{ asset('images/Logo BP Batam.gif') }}" alt="Logo" class="logo">
    </div>

    <div class="title">
        Sistem Manajemen Risiko
    </div>

    <div class="subtitle">
        BADAN PENGUSAHAAN BATAM
    </div>

    <form method="POST" action="/login">
        @csrf
        <div class="form-group">
            <label>Username</label>
            <input 
                type="text" 
                name="username" 
                placeholde="Masukkan username"
                value="{{ old('username') }}"
            >
        </div>

        <div class="form-group">
            <label>Password</label>
            <input 
                type="password" 
                name="password" 
                placeholder="Masukkan password"
            >
        </div>

        @if ($errors->any())
            <div class="alert">
                {{ $errors->first() }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert">
                {{ session('error') }}
            </div>
        @endif

        <button type="submit" class="btn-login">
            Masuk
        </button>
    </form>

    <div class="footer">
        Untuk pengguna internal (UPR, UMR, UPI)
    </div>

</div>

</body>
</html>
