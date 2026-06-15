@extends('layouts.app')

@section('content')
    <style>
        *,
        *:before,
        *:after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        .auth-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 150px);
            /* adjust based on header/footer */
            padding: 40px 0;
        }

        input,
        button {
            border: none;
            outline: none;
            background: none;
            font-family: 'Open Sans', Helvetica, Arial, sans-serif;
        }

        .cont {
            border-radius: 20px;
            overflow: hidden;
            position: relative;
            width: 900px;
            height: 550px;
            background: #fff;
            box-shadow:
                -10px -10px 15px rgba(255, 255, 255, .3),
                10px 10px 15px rgba(70, 70, 70, .15),
                inset -10px -10px 15px rgba(255, 255, 255, .3),
                inset 10px 10px 15px rgba(70, 70, 70, .15);
        }

        .form {
            position: relative;
            width: 640px;
            height: 100%;
            padding: 50px 30px 0;
            transition: transform 1.2s ease-in-out;
        }

        .sub-cont {
            overflow: hidden;
            position: absolute;
            left: 640px;
            top: 0;
            width: 900px;
            height: 100%;
            padding-left: 260px;
            background: #fff;
            transition: transform 1.2s ease-in-out;
        }

        .cont.s--signup .sub-cont {
            transform: translate3d(-640px, 0, 0);
        }

        button {
            display: block;
            margin: 0 auto;
            width: 260px;
            height: 36px;
            border-radius: 30px;
            color: #fff;
            font-size: 15px;
            cursor: pointer;
        }

        .img {
            overflow: hidden;
            z-index: 2;
            position: absolute;
            left: 0;
            top: 0;
            width: 260px;
            height: 100%;
            padding-top: 360px;
        }

        .img:before {
            content: '';
            position: absolute;
            right: 0;
            top: 0;
            width: 900px;
            height: 100%;
            background-image: url('{{ asset('images/Rectangle 58.png') }}');
            background-size: cover;
            background-position: center;
            opacity: .8;
            transition: transform 1.2s ease-in-out;
        }

        .img:after {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, .6);
        }

        .cont.s--signup .img:before {
            transform: translate3d(640px, 0, 0);
        }

        .img__text {
            z-index: 2;
            position: absolute;
            left: 0;
            top: 50px;
            width: 100%;
            padding: 0 20px;
            text-align: center;
            color: #fff;
            transition: transform 1.2s ease-in-out;
        }

        .cont.s--signup .img__text.m--up {
            transform: translateX(520px);
        }

        .img__text.m--in {
            transform: translateX(-520px);
        }

        .cont.s--signup .img__text.m--in {
            transform: translateX(0);
        }

        .img__btn {
            overflow: hidden;
            z-index: 2;
            position: relative;
            width: 100px;
            height: 36px;
            margin: 0 auto;
            color: #fff;
            text-transform: uppercase;
            font-size: 15px;
            cursor: pointer;
        }

        .img__btn:after {
            content: '';
            position: absolute;
            inset: 0;
            border: 2px solid #fff;
            border-radius: 30px;
        }

        .img__btn span {
            position: absolute;
            inset: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: transform 1.2s;
        }

        .img__btn span.m--in {
            transform: translateY(-72px);
        }

        .cont.s--signup .img__btn span.m--in {
            transform: translateY(0);
        }

        .cont.s--signup .img__btn span.m--up {
            transform: translateY(72px);
        }

        h2 {
            width: 100%;
            font-size: 26px;
            text-align: center;
        }

        label {
            display: block;
            width: 260px;
            margin: 25px auto 0;
            text-align: center;
        }

        label span {
            font-size: 12px;
            color: #cfcfcf;
            text-transform: uppercase;
        }

        input {
            display: block;
            width: 100%;
            margin-top: 5px;
            padding-bottom: 5px;
            font-size: 16px;
            border-bottom: 1px solid rgba(0, 0, 0, .4);
            text-align: center;
        }

        .forgot-pass {
            margin-top: 15px;
            text-align: center;
            font-size: 12px;
            color: #cfcfcf;
        }

        .submit {
            margin-top: 40px;
            margin-bottom: 20px;
            background: #d4af7a;
            text-transform: uppercase;
        }

        .sign-in {
            transition-timing-function: ease-out;
        }

        .cont.s--signup .sign-in {
            transition-timing-function: ease-in-out;
            transition-duration: 1.2s;
            transform: translate3d(640px, 0, 0);
        }

        .sign-up {
            transform: translate3d(-900px, 0, 0);
        }

        .cont.s--signup .sign-up {
            transform: translate3d(0, 0, 0);
        }
    </style>

    <div class="auth-wrapper">
        <div class="cont">

            <!-- Sign In -->
            <div class="form sign-in">
                <h2>Welcome</h2>

                <form method="POST" action="{{ route('login')}}">
                    @csrf

                    <label>
                        <span>Email</span>
                        <input type="email" name="email" required>
                    </label>

                    <label>
                        <span>Password</span>
                        <input type="password" name="password" required>
                    </label>

                    {{-- <p class="forgot-pass">Forgot password?</p> --}}

                    <button type="submit" class="submit">
                        Sign In
                    </button>
                </form>
            </div>

            <div class="sub-cont">

                <div class="img">
                    <div class="img__text m--up">
                        <h3>Don't have an account? Please Sign Up!</h3>
                    </div>

                    <div class="img__text m--in">
                        <h3>If you already have an account, just Sign In.</h3>
                    </div>

                    <div class="img__btn">
                        <span class="m--up">Sign Up</span>
                        <span class="m--in">Sign In</span>
                    </div>
                </div>

                <!-- Sign Up -->
                <div class="form sign-up">
                    <h2>Create your Account</h2>

                    <form method="POST" action="{{ route('register')}}">
                        @csrf

                        <label>
                            <span>Name</span>
                            <input type="text" name="name" required>
                        </label>

                        <label>
                            <span>Email</span>
                            <input type="email" name="email" required>
                        </label>

                        <label>
                            <span>Password</span>
                            <input type="password" name="password" required>
                        </label>

                        <button type="submit" class="submit">
                            Sign Up
                        </button>
                    </form>
                </div>

            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.img__btn').addEventListener('click', function() {
                document.querySelector('.cont').classList.toggle('s--signup');
            });
        });
    </script>
@endsection
