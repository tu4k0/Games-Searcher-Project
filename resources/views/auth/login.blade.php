@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <body class="bg-primary">
        <div class="container min-vh-100 d-flex justify-content-center align-items-center">
            <div class="row">
                <h1 style="color:white">Log in</h1>
                <form action="{{ route('login_user')  }}" class="center" style="width: 500px; height: 800px" method="POST">
                    @csrf
                    @error('googleId')
                    <p style="margin-top: 10px; font-size: 20px; color: red">{{ $message }}</p>
                    @enderror
                    <div class="form-group mt-6">
                        <label for="loginInput" style="font-size:25px; color: white">Email</label>
                        <input name="email" style="font-size:20px;" class="form-control mt-1 @error('email') border border-danger @enderror" placeholder="Enter email">
                        @error('email')
                        <p style="margin-top: 10px; font-size: 20px; color: red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mt-6">
                        <label for="passwordInput" style="font-size:25px; color: white">Password</label>
                        <input name="password" type="password" style="font-size:20px;" class="form-control mt-1 @error('password') border border-danger @enderror" placeholder="Enter password">
                        @error('password')
                        <p style="margin-top: 10px; font-size: 20px; color: red">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-danger mt-4 items-center" style="font-size: 20px">Login</button>
                    <div class="mt-6" style="float: right; margin-top: 20px">
                        <a href="{{ route('google_auth_form') }}">
                            <img id="google_auth" src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png" style="margin-left: 3em;">
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </body>
@stop
