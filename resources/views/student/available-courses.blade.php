<div class="registration-container">
    <!-- Step 1: Select Semester -->
    <div id="semester-step">
        <h2 class="heading">Click below for Registration</h2>
        <div class="semester-selection">
            <h3>Terms Open for Registration</h3>
            <select id="semester-select" class="form-control">
                <option value="">-- Select Course --</option>
                @foreach ($semesters as $semester)
                    <option value="{{ $semester }}">{{ $semester }}</option>
                @endforeach
            </select>
            <button class="btn btn-primary mt-3" id="continue-button" onclick="fetchCourses()">Continue</button>
        </div>
    </div>
    
    <!-- Step 2: Display Courses -->
    <div id="courses-step" style="display: none;">
        <h3>Available Courses</h3>
        <table class="table table-bordered courses-table">
            <thead>
                <tr>
                    <th>Course Name</th>
                    <th>Description</th>
                    <th>Teacher</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="courses-table-body">
            </tbody>
        </table>
    </div>
</div>

