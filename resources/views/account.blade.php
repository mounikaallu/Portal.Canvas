<!-- resources/views/account.blade.php -->
<div class="account-panel" id="accountPanel">
    <input type="hidden" id="user_email" value="{{ $user->email }}">
    <div class="account-header">
        <!-- Display initials (e.g., MA for Mounika Allu) -->
        <h2>{{ strtoupper(substr($user->first_name, 0, 1)) . strtoupper(substr($user->last_name, 0, 1)) }}</h2>
        <h4>{{ $user->first_name . ' ' . $user->last_name }}</h4>
        <button class="close-btn" id="closeAccountPanel">&#x2715;</button>
    </div>

    <!-- Logout Form -->
    <form id="logoutForm" action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-secondary logout-btn">Logout</button>
    </form>

    <ul class="account-links">
        <li><a href="#">Notifications</a></li>
        <li><a href="javascript:void(0);" onclick="loadProfile()">Profile</a></li>
        <li><a href="#">Files</a></li>
        <li><a href="#">Settings</a></li>
        <li><a href="#">Follett Discover</a></li>
        <li><a href="#">QR for Mobile Login</a></li>
        <li><a href="#">Global Announcements</a></li>
    </ul>

    <div class="contrast-option">
        <button class="contrast-btn">&#x2715; Use High Contrast UI</button>
    </div>
</div>
