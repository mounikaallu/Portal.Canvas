@extends('layouts.app')

@section('content')
    @if(session('success'))
        @include('popup')
    @endif

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/login.css') }}">
    <!-- Header Section -->
    <div class="header-container">
        <!-- Logo -->
        <img src="{{ asset('assets/images/logo_odu.png') }}" alt="Old Dominion University Logo" class="logo">
        <!-- Background Image -->
        <img src="{{ asset('assets/images/loginpage_img.jpg') }}" alt="Campus Background" class="background">
    </div>

    <div class="login-container">
        <form method="post" action="{{ route('login.store') }}" name="loginForm" novalidate>
            @csrf

            @if(session('error'))
                <div class="errors">
                    {{ session('error') }}
                </div>
            @endif

            <div class="form-group">
                <label for="email">EMAIL ID:</label>
                <input type="text" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="errors">{{ $message }}</div> <!-- Use the .errors class -->
                @enderror
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                @error('password')
                    <div class="errors">{{ $message }}</div> <!-- Use the .errors class -->
                @enderror
            </div>
            
            <button type="submit" class="btn-login">Login</button>

            <div class="links">
                <a href="/registration" class="btn-secondary">Create an Account</a>
                <a href="#" class="btn-secondary">Forgot Password?</a>
            </div>
        </form>
    </div>
@stop
