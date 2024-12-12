<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="courses-container" id="courses-container" style="display: none;">
    @if($user->user_role === 'admin')
        <div class="courses-header">
            <h1>Courses Management</h1>
            <p>Welcome to the courses management section.</p>
            <button class="btn btn-primary" id="create-course-btn">Add Course</button>
        </div>

        <div class="courses-table-container">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Course ID</th>
                        <th>Course Name</th>
                        <th>Course Description</th>
                        <th>Assigned Teachers</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="courses-table-body"></tbody>
            </table>
        </div>
    @endif
    @if($user->user_role === 'teacher')
    <script>
        const userId = {{ $user->id }};
    </script>
        <div class="courses-container" id="teacher-courses-container">
            <div class="card-grid" id="teacher-courses-grid"></div>
        </div>
    @endif
    @if($user->user_role !== 'admin' && $user->user_role !== 'teacher')
    <script>
        const userId = {{ $user->id }};
    </script>
        <div class="register-courses-container">
            <h3>Click below for Registration</h3>
            <button class="btn btn-primary" id="register-course-btn">Registration</button>
            <div id="dynamic-registration-container"></div>
        </div>
        <div class="registered-courses-container">
            <h3>Your Registered Courses</h3>
        <div class="card-grid" id="student-registered-courses-grid"></div>
        </div>
    @endif


      <!-- Modal for Adding Course -->
      <div id="add-course-modal" class="modal" style="display: none;">
        <div class="modal-content">
            <h3>Add New Course</h3>
            <form id="add-course-form">
                <div class="form-group">
                    <label for="course-name">Course Name</label>
                    <input type="text" id="course-name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="course-desc">Course Description</label>
                    <textarea id="course-desc" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="semester">Semester</label>
                    <input type="text" id="semester" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Course</button>
                <button type="button" class="btn btn-secondary" id="close-add-modal">Cancel</button>
            </form>
        </div>
    </div>

    <!-- Modal for Assigning Teachers -->
    <div id="assign-teachers-modal" class="modal" style="display: none;">
        <div class="modal-content">
            <h3>Assign Teachers to Course</h3>
            <form id="assign-teachers-form">
                <input type="hidden" id="course-id">
                <div class="form-group">
                    <label for="teacher-ids">Select Teachers</label>
                    <select id="teacher-ids" multiple></select>
                </div>
                <button type="submit" class="btn btn-primary">Assign</button>
                <button type="button" class="btn btn-secondary" id="close-assign-modal">Cancel</button>
            </form>
        </div>
    </div>
</div>
