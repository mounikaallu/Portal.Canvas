<div class="staff-container" id="staff-container" style="display: none;">
    <div class="staff-header">
        <h1>Staff Management</h1>
        <p>Welcome to the staff management section.</p>
        <button class="btn btn-primary" id="onboard-teacher-btn">Onboard Teacher</button>
    </div>

    <!-- Table to display teachers -->
    <div class="staff-table-container">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Date of Birth</th>
                    <th>Gender</th>
                    <th>Email</th>
                    <th>Mobile Number</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="teacher-table-body">
                <!-- Teachers data will be dynamically populated here -->
            </tbody>
        </table>
    </div>

  <!-- Onboard Teacher Modal -->
<div id="onboard-teacher-modal" class="modal" style="display: none;">
    <div class="modal-content">
        <h3>Onboard New Teacher</h3>
        <form id="onboard-teacher-form">
            @csrf
            <div class="form-group">
                <label for="onboard-teacher-first-name">First Name</label>
                <input type="text" class="form-control" id="onboard-teacher-first-name" name="first_name" required>
            </div>
            <div class="form-group">
                <label for="onboard-teacher-last-name">Last Name</label>
                <input type="text" class="form-control" id="onboard-teacher-last-name" name="last_name" required>
            </div>
            <div class="form-group">
                <label for="onboard-teacher-dob">Date of Birth</label>
                <input type="date" class="form-control" id="onboard-teacher-dob" name="dateofbirth" required>
            </div>
            <div class="form-group">
                <label for="onboard-teacher-email">Email</label>
                <input type="email" class="form-control" id="onboard-teacher-email" name="email" required>
            </div>
            <div class="form-group">
                <label for="onboard-teacher-mobile">Mobile Number</label>
                <input type="text" class="form-control" id="onboard-teacher-mobile" name="mobile_number" required>
            </div>
            <div class="form-group">
                <label for="onboard-teacher-password">Password</label>
                <input type="password" class="form-control" id="onboard-teacher-password" name="password" required>
            </div>
            <div class="form-group">
                <label for="onboard-teacher-role">Role</label>
                <input type="text" class="form-control" id="onboard-teacher-role" name="role" value="teacher" readonly>
            </div>
            <button type="submit" class="btn btn-success">Onboard Teacher</button>
            <button type="button" class="btn btn-secondary" id="cancel-onboard-teacher">Cancel</button>
        </form>
    </div>
</div>

<!-- Update Teacher Modal -->
<div id="update-teacher-modal" class="modal" style="display: none;">
    <div class="modal-content">
        <h3>Update Teacher</h3>
        <form id="update-teacher-form">
            @csrf
            <input type="hidden" id="update-teacher-id" name="teacher_id">
            <div class="form-group">
                <label for="update-teacher-first-name">First Name</label>
                <input type="text" class="form-control" id="update-teacher-first-name" name="first_name" required>
            </div>
            <div class="form-group">
                <label for="update-teacher-last-name">Last Name</label>
                <input type="text" class="form-control" id="update-teacher-last-name" name="last_name" required>
            </div>
            <div class="form-group">
                <label for="update-teacher-dob">Date of Birth</label>
                <input type="date" class="form-control" id="update-teacher-dob" name="dateofbirth" required>
            </div>
            <div class="form-group">
                <label for="update-teacher-mobile">Mobile Number</label>
                <input type="text" class="form-control" id="update-teacher-mobile" name="mobile_number" required>
            </div>
            <button type="submit" class="btn btn-success">Save Changes</button>
            <button type="button" class="btn btn-secondary" id="close-modal-btn">Cancel</button>
        </form>
    </div>
</div>

</div>
