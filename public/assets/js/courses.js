document.addEventListener("DOMContentLoaded", () => {
    initCoursesPanelToggle(); // Initialize panel toggles
    loadCourses(); // Load courses on page load
    attachCoursesModalEventListeners(); 
    attachAddCourseModalEventListeners();
    loadTeacherCourses();
    loadRegisteredCourses();

    // Attach event listener for "Register for Courses" button
    const registerCourseBtn = document.getElementById("register-course-btn");
    if (registerCourseBtn) {
        registerCourseBtn.addEventListener("click", () => {
            loadSemesterDropdown();
        });
    }
});

function initCoursesPanelToggle() {
    const staffLink = document.getElementById("staffLink");
    const staffPanel = document.getElementById("staff-container");
    const coursesLink = document.getElementById("coursesLink");
    const coursesPanel = document.getElementById("courses-container");

    if (!coursesLink || !coursesPanel) {
        return;
    }

    function closeAllPanels() {
        if (staffPanel) staffPanel.style.display = "none";
        if (coursesPanel) coursesPanel.style.display = "none";
    }

    if (staffLink) {
        staffLink.addEventListener("click", (event) => {
            event.preventDefault();
            closeAllPanels();
            if (staffPanel) {
                staffPanel.style.display = staffPanel.style.display === "block" ? "none" : "block";
            }
        });
    }

    if (coursesLink) {
        coursesLink.addEventListener("click", (event) => {
            event.preventDefault();
            closeAllPanels();
            if (coursesPanel) {
                coursesPanel.style.display = coursesPanel.style.display === "block" ? "none" : "block";
            }
        });
    }

    window.addEventListener("click", (event) => {
        if (
            !event.target.closest("#staff-container") &&
            !event.target.closest("#courses-container") &&
            !event.target.closest("#staffLink") &&
            !event.target.closest("#coursesLink")
        ) {
            closeAllPanels();
        }
    });
}

function loadSemesterDropdown() {
    const dynamicContainer = document.getElementById("dynamic-registration-container");

    $.ajax({
        url: '/fetch-semester-dropdown', // Route to fetch semesters
        method: 'GET',
        success: function (response) {
            dynamicContainer.innerHTML = response.html; // Load the semester dropdown into the container
        },
        error: function (error) {
            console.error("Error fetching semester dropdown:", error);
            alert("Failed to load semester selection. Please try again.");
        },
    });
}

function attachAddCourseModalEventListeners() {
    const addCourseBtn = document.getElementById("create-course-btn");
    const addCourseModal = document.getElementById("add-course-modal");
    const closeAddModalBtn = document.getElementById("close-add-modal");

    if (addCourseBtn) {
        addCourseBtn.addEventListener("click", () => {
            if (addCourseModal) addCourseModal.style.display = "block";
        });
    }

    if (closeAddModalBtn) {
        closeAddModalBtn.addEventListener("click", () => {
            if (addCourseModal) addCourseModal.style.display = "none";
        });
    }

    const addCourseForm = document.getElementById("add-course-form");
    if (addCourseForm) {
        addCourseForm.addEventListener("submit", (event) => {
            event.preventDefault();
            addCourse();
        });
    }
}

function addCourse() {
    const courseName = document.getElementById("course-name").value;
    const courseDesc = document.getElementById("course-desc").value;
    const semester = document.getElementById("semester").value;

    $.ajax({
        url: "/add-course", // Your endpoint for adding a course
        method: "POST",
        data: {
            course_name: courseName,
            course_desc: courseDesc,
            semester: semester,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            if (response.success) {
                alert("Course added successfully!");
                document.getElementById("add-course-modal").style.display = "none";
                loadCourses(); // Reload courses list
            } else {
                alert("Error adding course.");
            }
        },
        error: function (error) {
            console.error("Error adding course:", error);
        },
    });
}

function loadCourses() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
    });

    $.ajax({
        url: '/fetch-courses',
        method: 'GET',
        success: function (response) {
            const tbody = document.getElementById("courses-table-body");
            tbody.innerHTML = "";

            response.courses.forEach((course) => {
                const row = `
                    <tr>
                        <td>${course.id}</td>
                        <td>${course.course_name}</td>
                        <td>${course.course_desc}</td>
                        <td>${course.teachers.map((teacher) => teacher.first_name).join(', ') || 'No teachers assigned'}</td>
                        <td>
                            <button class="btn btn-secondary" onclick="openAssignTeachersModal(${course.id})">
                                Assign Teachers
                            </button>
                        </td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
        },
        error: function (error) {
            console.error("Error fetching courses:", error);
        },
    });
}

function openAssignTeachersModal(courseId) {
    const modal = document.getElementById("assign-teachers-modal");
    const courseIdInput = document.getElementById("course-id");
    courseIdInput.value = courseId;
    loadTeachersForAssignment();

    if (modal) modal.style.display = "block";
}

function loadTeachersForAssignment() {
    $.ajax({
        url: '/fetch-teachers',
        method: 'GET',
        success: function (response) {
            const teacherSelect = document.getElementById("teacher-ids");
            teacherSelect.innerHTML = "";

            response.teachers.forEach((teacher) => {
                const option = document.createElement("option");
                option.value = teacher.id;
                option.textContent = teacher.first_name + " " + teacher.last_name;
                teacherSelect.appendChild(option);
            });
        },
        error: function (error) {
            console.error("Error fetching teachers:", error);
        },
    });
}

function attachCoursesModalEventListeners() {
    const assignForm = document.getElementById("assign-teachers-form");
    const closeModalBtn = document.getElementById("close-assign-modal");

    if (assignForm) {
        assignForm.addEventListener("submit", (event) => {
            event.preventDefault();
            assignTeachersToCourse();
        });
    }

    if (closeModalBtn) {
        closeModalBtn.addEventListener("click", () => {
            const modal = document.getElementById("assign-teachers-modal");
            if (modal) modal.style.display = "none";
        });
    }
}

function assignTeachersToCourse() {
    const courseId = document.getElementById("course-id").value;
    const teacherIds = Array.from(document.getElementById("teacher-ids").selectedOptions).map(
        (option) => option.value
    );

    $.ajax({
        url: `/courses/${courseId}/assign-teachers`,
        method: 'POST',
        data: {
            teacher_ids: teacherIds,
            _token: $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (response) {
            if (response.success) {
                alert("Teachers assigned successfully!");
                document.getElementById("assign-teachers-modal").style.display = "none";
                loadCourses();
            } else {
                alert("Error assigning teachers.");
            }
        },
        error: function (error) {
            console.error("Error assigning teachers:", error);
        },
    });
}

function loadTeacherCourses() {
    if (typeof userId === "undefined") {
        console.error("Error: userId is not defined.");
        return;
    }
    $.ajax({
        url: '/fetch-teacher-courses',
        method: 'GET',
        data: { teacher_id: userId },
        success: function (response) {
            const grid = document.getElementById("teacher-courses-grid");
            grid.innerHTML = "";

            if (response.courses.length === 0) {
                grid.innerHTML = `
                    <div class="no-courses">
                        <img src="assets/images/no-course.jpg" alt="No Courses" class="no-courses-img">
                        <p>No courses available at the moment.</p>
                    </div>
                `;
            } else {
                response.courses.forEach((course) => {
                    const card = `
                        <div class="course-card">
                            <img src="assets/images/course_card.png" alt="Course Logo" class="course-logo">
                            <h3>${course.course_name}</h3>
                            <p>${course.course_desc}</p>
                            <p>${course.semester || "N/A"}</p>
                        </div>
                    `;
                    grid.innerHTML += card;
                });
            }
        },
        error: function (error) {
            console.error("Error fetching teacher courses:", error);
        },
    });
}

function loadCoursesBySemester(semester) {
    if (!semester) {
        console.error("Please select a valid semester.");
        return;
    }

    $.ajax({
        url: '/fetch-courses-by-semester', // Backend route to fetch courses
        method: 'GET',
        data: { semester },
        success: function (response) {
            const coursesList = document.getElementById("courses-list");
            const modal = document.getElementById("courses-modal");

            if (!coursesList || !modal) {
                console.error("Error: Required elements not found.");
                return;
            }

            coursesList.innerHTML = ""; // Clear previous data

            if (response.courses.length === 0) {
                coursesList.innerHTML = `
                    <p>No courses available for the selected semester.</p>
                `;
            } else {
                response.courses.forEach((course) => {
                    const teachers = course.teachers.map(
                        (teacher) => teacher.first_name + " " + teacher.last_name
                    ).join(", ") || "No teachers assigned yet";

                    coursesList.innerHTML += `
                        <div>
                            <p><strong>Course Name:</strong> ${course.course_name}</p>
                            <p><strong>Description:</strong> ${course.course_desc}</p>
                            <p><strong>Teachers:</strong> ${teachers}</p>
                            <hr>
                        </div>
                    `;
                });
            }

            modal.style.display = "block"; // Show the modal
        },
        error: function (error) {
            console.error("Error fetching courses by semester:", error);
        },
    });
}

function closeModal() {
    const modal = document.getElementById("courses-modal");
    modal.style.display = "none";
}

// Close modal if clicked outside
window.onclick = function (event) {
    const modal = document.getElementById("courses-modal");
    if (event.target === modal) {
        modal.style.display = "none";
    }
};


function fetchCourses() {
    const semester = document.getElementById("semester-select").value;

    if (!semester) {
        alert("Please select a semester.");
        return;
    }

    $.ajax({
        url: '/fetch-courses',
        method: 'POST',
        data: {
            semester: semester,
            _token: $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (response) {
            const coursesTableBody = document.getElementById("courses-table-body");
            coursesTableBody.innerHTML = "";

            response.courses.forEach(course => {
                const row = `
                    <tr>
                        <td>${course.course_name}</td>
                        <td>${course.course_desc}</td>
                        <td>${course.teachers.map(teacher => teacher.first_name).join(', ')}</td>
                        <td>
                            <button class="btn btn-primary" onclick="registerForCourse(${course.id}, ${course.teachers[0]?.id}, userId)">Add</button>
                        </td>
                    </tr>
                `;
                coursesTableBody.innerHTML += row;
            });

            // Hide semester step and show courses step
            document.getElementById("semester-step").style.display = "none";
            document.getElementById("courses-step").style.display = "block";
        },
        error: function (error) {
            console.error("Error fetching courses:", error);
        },
    });
}

function registerForCourse(courseId, teacherId, userId) {
    $.ajax({
        url: '/register-course',
        method: 'POST',
        data: {
            course_id: courseId,
            teacher_id: teacherId,
            student_id: userId,
            _token: $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (response) {
            alert(response.message);
        },
        error: function (error) {
            if (error.responseJSON && error.responseJSON.message) {
                alert(error.responseJSON.message);
            } else {
                alert("An error occurred while registering for the course.");
            }
        },
    });
}

function loadRegisteredCourses() {
    $.ajax({
        url: '/fetch-registered-courses', // Endpoint to fetch registered courses
        method: 'GET',
        data: { student_id: userId },
        success: function (response) {
            const grid = document.getElementById("student-registered-courses-grid");
            grid.innerHTML = ""; // Clear the grid before adding new cards

            if (response.courses.length === 0) {
                grid.innerHTML = `
                    <div class="no-courses">
                        <p>No registered courses found.</p>
                    </div>
                `;
            } else {
                response.courses.forEach((course) => {
                    const card = `
                        <div class="course-card">
                            <img src="assets/images/course_card.png" alt="Course Logo" class="course-logo">
                            <h3>${course.course_name}</h3>
                            <p>${course.course_desc}</p>
                            <p>${course.semester || "N/A"}</p>
                        </div>
                    `;
                    grid.innerHTML += card;
                });
            }
        },
        error: function (error) {
            console.error("Error fetching registered courses:", error);
        },
    });
}
