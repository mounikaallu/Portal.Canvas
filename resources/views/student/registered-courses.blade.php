<div class="courses-container">
    <h1>My Registered Courses</h1>
    <div class="card-grid">
        @foreach($courses as $course)
        <div class="course-card">
            <h3>{{ $course->course_name }}</h3>
            <p>{{ $course->course_desc }}</p>
            <p><strong>Teacher:</strong> {{ $course->pivot->teacher->first_name }}</p>
            <p><strong>Semester:</strong> {{ $course->semester }}</p>
        </div>
        @endforeach
    </div>
</div>
