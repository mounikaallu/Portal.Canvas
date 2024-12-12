@extends('layouts.app')

@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/registration.css') }}">
<!-- Logo Image -->
<div class="header-image"></div>

<!-- Lion Image-->
<div class="logo-container">
    <img src="{{ asset('assets/images/lion.jpg') }}" alt="Lion Image">
</div>

<form method="post" action="{{ route('register.store') }}">
    @csrf

    <div class='container'>
        <h2>MIDAS Account Creation</h2>

        <div class="form-group">
            <label for="university_id">University ID Number</label>
            <input type="text" class="form-control" name="university_id" value="{{ old('university_id') }}">
            @error('university_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}">
            @error('last_name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}">
            @error('first_name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="dateofbirth">Date of Birth</label>
            <input type="date" class="form-control" name="dateofbirth" id="date" min="1800-01-01" max="2023-12-31" value="{{ old('dateofbirth') }}">
            @error('dateofbirth')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="gender">Gender:</label>
            <div class="form-check">
                <input type="radio" class="form-check-input" name="gender" value="male" id="male" {{ old('gender') == 'male' ? 'checked' : '' }}>
                <label class="form-check-label" for="male">Male</label>
            </div>

            <div class="form-check">
                <input type="radio" class="form-check-input" name="gender" value="female" id="female" {{ old('gender') == 'female' ? 'checked' : '' }}>
                <label class="form-check-label" for="female">Female</label>
            </div>
            @error('gender')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email">
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password">
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" class="form-control" name="password_confirmation">
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <br>

        <button type="submit" class="btn btn-dark">Submit</button>
    </div>
</form>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@stop

@section('footer') 