<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/staff.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/courses.css') }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/js/dashboard.js') }}" defer></script>

<div class="dashboard-container">
    <!-- Taskbar -->
    <div class="taskbar">
    <h1>
        @if($user->user_role === 'admin')
           Welcome to Admin Dashboard
        @elseif($user->user_role === 'teacher')
            Welcome to Teacher Dashboard
        @else
           Welcome to Student Dashboard
        @endif
    </h1>
        <div class="options-menu">
            <i class="fas fa-ellipsis-v"></i>
        </div>
    </div>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo-section">
            <img src="{{ asset('assets/images/crown_odu.png') }}" alt="Logo" class="logo">
        </div>
        <nav class="nav flex-column">
            <a id="accountLink" class="nav-link" role="button"><i class="fas fa-user-circle"></i><span>Account</span></a>
            <a class="nav-link" href="#"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
            @if($user->user_role === 'admin') <!-- Check if the user is an admin -->
            <a id="staffLink" class="nav-link" role="button"><i class="fas fa-user-tie"></i><span>Staff</span></a>
            @endif
            <a id="coursesLink" class="nav-link" role="button"><i class="fas fa-book"></i><span>Courses</span></a>
            <a class="nav-link" href="#"><i class="fas fa-calendar"></i><span>Calendar</span></a>
            <a class="nav-link" href="#"><i class="fas fa-inbox"></i><span>Inbox</span></a>
            <a class="nav-link" href="#"><i class="fas fa-history"></i><span>History</span></a>
            <a class="nav-link" href="#"><i class="fas fa-folder"></i><span>My Media</span></a>
            <a class="nav-link" href="#"><i class="fas fa-question-circle"></i><span>Help</span></a>
            <a class="nav-link" href="#"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
        </nav>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">

        <!-- Include Account Panel -->
        @include('account')

        <!-- Include Staff Panel -->
        @include('staff')

         <!-- Include Courses Panel -->
         @include('courses')
    </div>
</div>

<script src="{{ asset('assets/js/staff.js') }}" defer></script>
<script src="{{ asset('assets/js/courses.js') }}" defer></script>
@stop
