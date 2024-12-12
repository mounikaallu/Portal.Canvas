@extends('layouts.app')

@section('content')
<div class="profile-container">
    <h2>{{ strtoupper($user->first_name . ' ' . $user->last_name) }}'s Profile</h2>

    <!-- Display Success Message Area -->
    <div id="success-message" class="alert alert-success" style="display: none;">
        Profile updated successfully.
    </div>

    <!-- Non-editable view -->
    <div id="profile-view" class="profile-view">
        <div class="profile-section">
            <p><strong>First Name:</strong> {{ $user->first_name }}</p>
            <p><strong>Last Name:</strong> {{ $user->last_name }}</p>
            <p><strong>Date of Birth:</strong> {{ $user->dateofbirth }}</p>
            <p><strong>Mobile Number:</strong> {{ $user->mobile_number }}</p>
        </div>
        <button class="btn btn-secondary" id="edit-profile-btn">Edit Profile</button>
    </div>

    <!-- Editable form (hidden by default) -->
    <div id="profile-edit" class="profile-edit" style="display: none;">
        <form id="update-profile-form">
            @csrf
            <input type="hidden" name="email" id="email" value="{{ $user->email }}">

            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $user->first_name }}" required>
            </div>

            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $user->last_name }}" required>
            </div>

            <div class="form-group">
                <label for="dateofbirth">Date of Birth</label>
                <input type="date" class="form-control" id="dateofbirth" name="dateofbirth" value="{{ $user->dateofbirth }}" required>
            </div>

            <div class="form-group">
                <label for="mobile_number">Mobile Number</label>
                <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="{{ $user->mobile_number }}" required>
            </div>

            <button type="button" class="btn btn-primary" id="save-changes">Save Changes</button>
            <button type="button" class="btn btn-secondary" id="cancel-edit-btn">Cancel</button>
        </form>
    </div>
</div>
@endsection
