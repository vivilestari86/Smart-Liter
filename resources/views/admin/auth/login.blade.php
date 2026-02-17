<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>
    
    <style>
        html, body{
            height: 100%;
            margin: 0;
        }

        /* FULL SCREEN background */
        .login-bg{
            min-height: 100vh;
            width: 100%;
            display: grid;
            place-items: center;

            /* background full layar */
            background:
            linear-gradient(rgba(0,0,0,.10), rgba(0,0,0,.10)),
            url('{{ asset('images/bg-admin.jpg') }}') center/cover no-repeat;

            /* hilangkan padding yang bikin tidak full */
            padding: 0;
        }

        /* wrapper (cuma untuk center) */
        .login-hero{
            width: 100%;
            min-height: 100vh;
            display: grid;
            place-items: center;

            /* jangan batasi 1100px & jangan kasih padding besar */
            padding: 24px 16px;

            /* hapus box look */
            background: transparent;
            border-radius: 0;
        }

        .login-card{
            width: min(440px, 92vw);
            background: #ffffff;
            border-radius: 18px;
            padding: 28px 30px 24px;  /* lebih lega kiri kanan */
            box-shadow: 0 18px 60px rgba(0,0,0,.25);
        }

        .brand{
            display: flex;
            justify-content: center;
            margin-bottom: 12px;
        }
        .brand img{
            height: clamp(50px, 6vw, 88px);  /* min 52, max 88 */
            }

        .brand{
            margin-bottom: 18px;
            }

        .field{ margin-top: 14px; }
        
        .label{
            font-size: 12px;
            color: #666;
            margin-bottom: 6px;
        }

        .input{
            width: 100%;
            box-sizing: border-box;      /* penting biar ga mepet */
            border: 1px solid #d7c3b1;
            background: #f7efe6;
            border-radius: 10px;
            padding: 12px 14px;          /* lebih lega */
            outline: none;
        }
        .input:focus{
            border-color: #c67d46;
            box-shadow: 0 0 0 3px rgba(198,125,70,.15);
        }

        .hint-link{
            display: block;
            text-align: center;
            font-size: 12px;
            color: #c67d46;
            margin: 16px 0 18px;
            text-decoration: none;
        }

        .btn-login{
            width: 170px;
            margin: 0 auto;
            display: block;
            background: #c67d46;
            color: #fff;
            border: 0;
            padding: 10px 14px;
            border-radius: 10px;
            font-weight: 700;
            box-shadow: 0 4px 0 #a76433;
            cursor: pointer;
        }
        .btn-login:active{
            transform: translateY(1px);
            box-shadow: 0 3px 0 #a76433;
        }

        .error{
            margin-top: 10px;
            background: #ffe7e7;
            border: 1px solid #ffb9b9;
            color: #9b1c1c;
            padding: 10px 12px;
            border-radius: 10px;
            font-size: 13px;
        }
        </style>

</head>
<body>
<div class="login-bg">
    <div class="login-hero">
        <div class="login-card">
            <div class="brand">
                <img src="{{ asset('images/logo.jpg') }}" alt="SmartLiter">
            </div>

            @if ($errors->any())
                <div class="error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf

                <div class="field">
                    <div class="label">Email</div>
                    <input class="input" type="email" name="email" value="{{ old('email') }}" placeholder="Tambahkan Email" required>
                </div>

                <div class="field">
                    <div class="label">Kata Sandi</div>
                    <input class="input" type="password" name="password" placeholder="Masukkan Kata Sandi" required>
                </div>

                <a class="hint-link" href="#">Lupa Kata Sandi?</a>

                <button type="submit" class="btn-login">Masuk</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
