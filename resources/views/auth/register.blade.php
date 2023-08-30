@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <body class="bg-secondary">
        <div class="container min-vh-100 d-flex justify-content-center align-items-center">
            <div class="row">
                <h1 style="color:white">Register</h1>
                <form action="{{ route("register_user") }}" class="center" style="width: 500px; height: 800px" method="POST" id="register_user">
                    @csrf
                    @error('googleId')
                    <p style="margin-top: 10px; font-size: 20px; color: red">{{ $message }}</p>
                    @enderror
                    <div class="form-group mt-6">
                        <label for="nameInput" style="font-size:25px; color: white; margin-top: 20px">Login</label>
                        <input name="login" type="text" style="font-size:20px;" class="form-control mt-1 @error('login') border border-danger @enderror" id="exampleInputName" placeholder="Enter login">
                        @error('login')
                        <p style="margin-top: 10px; font-size: 20px; color: red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mt-6">
                        <label for="emailInput" style="font-size:25px; color: white">E-mail</label>
                        <input name="email" type="email" style="font-size:20px;" class="form-control mt-1 @error('email') border border-danger @enderror" id="exampleInputEmail" placeholder="Enter email">
                        @error('email')
                        <p style="margin-top: 10px; font-size: 20px; color: red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mt-6">
                        <label for="passwordInput" style="font-size:25px; color: white">Password</label>
                        <input name="password" type="password" style="font-size:20px;" class="form-control mt-1 @error('password') border border-danger @enderror" id="exampleInputPassword" placeholder="Enter password">
                        @error('password')
                        <p style="margin-top: 10px; font-size: 20px; color: red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mt-6">
                        <label for="passwordInputConfirm" style="font-size:25px; color: white">Confirm Password</label>
                        <input name="password_confirmation" type="password" style="font-size:20px;" class="form-control mt-1 @error('login') border border-danger @enderror" id="exampleInputPasswordConfirm" placeholder="Confirm password">
                        @error('password_confirmation')
                        <p style="margin-top: 10px; font-size: 20px; color: red">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mt-4 items-center" style="font-size: 20px">Register</button>
                    <div class="mt-6" style="float: right; margin-top: 20px">
                        <a href="{{ route('google_auth_form') }}">
                            <img src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png" style="margin-left: 3em;">
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </body>
@stop
