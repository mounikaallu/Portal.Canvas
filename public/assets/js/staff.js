document.addEventListener("DOMContentLoaded", () => {
    initPanelToggle(); // Initialize panel toggles
    loadTeachers(); // Load teachers when the page loads
    attachModalEventListeners(); // Attach listeners for modal actions
    attachOnboardTeacherModalListeners(); // Attach listeners for onboarding teacher modal actions
});

// Function to initialize toggles for multiple panels
function initPanelToggle() {
    const accountLink = document.getElementById("accountLink");
    const staffLink = document.getElementById("staffLink");
    const accountPanel = document.getElementById("accountPanel");
    const staffPanel = document.getElementById("staff-container");

    // Helper function to close all panels
    function closeAllPanels() {
        if (accountPanel) accountPanel.style.display = "none";
        if (staffPanel) staffPanel.style.display = "none";
    }

    // Toggle Account Panel
    if (accountLink) {
        accountLink.addEventListener("click", (event) => {
            event.preventDefault();
            closeAllPanels(); // Close other panels
            if (accountPanel) {
                accountPanel.style.display =
                    accountPanel.style.display === "block" ? "none" : "block";
            }
        });
    }

    // Toggle Staff Panel
    if (staffLink) {
        staffLink.addEventListener("click", (event) => {
            event.preventDefault();
            closeAllPanels(); // Close other panels
            if (staffPanel) {
                staffPanel.style.display =
                    staffPanel.style.display === "block" ? "none" : "block";
            }
        });
    }

    // Close panels when clicking outside
    window.addEventListener("click", (event) => {
        if (
            !event.target.closest(".sidebar") &&
            !event.target.closest("#accountPanel") &&
            !event.target.closest("#staff-container")
        ) {
            closeAllPanels();
        }
    });
}

// Load all teachers and display in the table
function loadTeachers() {
    $.ajax({
        url: '/staff/teachers', // Endpoint for fetching teachers
        method: 'GET',
        success: function (response) {
            const tbody = document.getElementById("teacher-table-body");
            tbody.innerHTML = ""; // Clear table before appending new data

            response.teachers.forEach((teacher) => {
                const row = `
                    <tr>
                        <td>${teacher.first_name}</td>
                        <td>${teacher.last_name}</td>
                        <td>${teacher.dateofbirth}</td>
                        <td>${teacher.gender}</td>
                        <td>${teacher.email}</td>
                        <td>${teacher.mobile_number}</td>
                        <td>
                            <button class="btn btn-secondary" onclick="openUpdateModal(${teacher.id}, '${teacher.first_name}', '${teacher.last_name}', '${teacher.dateofbirth}', '${teacher.mobile_number}')">
                                Edit
                            </button>
                        </td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
        },
        error: function (error) {
            console.error("Error fetching teachers:", error);
        },
    });
}

// Open update modal with teacher data pre-filled
function openUpdateModal(id, firstName, lastName, dob, mobileNumber) {
    const modal = document.getElementById("update-teacher-modal");
    document.getElementById("update-teacher-id").value = id;
    document.getElementById("update-teacher-first-name").value = firstName;
    document.getElementById("update-teacher-last-name").value = lastName;
    document.getElementById("update-teacher-dob").value = dob;
    document.getElementById("update-teacher-mobile").value = mobileNumber;

    if (modal) modal.style.display = "block";
}

// Attach event listeners for modal actions
function attachModalEventListeners() {
    const modal = document.getElementById("update-teacher-modal");
    const closeModalBtn = document.getElementById("close-modal-btn");

    if (closeModalBtn) {
        closeModalBtn.addEventListener("click", () => {
            if (modal) modal.style.display = "none";
        });
    }

    // Update teacher on form submission
    const updateTeacherForm = document.getElementById("update-teacher-form");
    if (updateTeacherForm) {
        updateTeacherForm.addEventListener("submit", (event) => {
            event.preventDefault();
            updateTeacher();
        });
    }
}

// Update teacher details via AJAX
function updateTeacher() {
    const formData = {
        id: document.getElementById("update-teacher-id").value,
        first_name: document.getElementById("update-teacher-first-name").value,
        last_name: document.getElementById("update-teacher-last-name").value,
        dateofbirth: document.getElementById("update-teacher-dob").value,
        mobile_number: document.getElementById("update-teacher-mobile").value,
        _token: $('meta[name="csrf-token"]').attr('content'), // CSRF token
    };

    $.ajax({
        url: '/staff/update-teacher', // Endpoint for updating teacher
        method: 'POST',
        data: formData, 
        success: function (response) {
            if (response.success) {
                alert("Teacher updated successfully!");
                document.getElementById("update-teacher-modal").style.display = "none";
                loadTeachers(); // Reload updated teachers
            } else {
                alert("Error updating teacher: " + response.error);
            }
        },
        error: function (error) {
            console.error("Error updating teacher:", error);
            alert("An error occurred while updating the teacher.");
        },
    });
}

// Attach modal event listeners for onboarding teacher
function attachOnboardTeacherModalListeners() {
    const onboardTeacherBtn = document.getElementById("onboard-teacher-btn");
    const onboardTeacherModal = document.getElementById("onboard-teacher-modal");
    const closeModalBtn = document.getElementById("cancel-onboard-teacher");

    // Open onboard modal
    if (onboardTeacherBtn) {
        onboardTeacherBtn.addEventListener("click", () => {
            if (onboardTeacherModal) onboardTeacherModal.style.display = "block";
        });
    }

    // Close onboard modal
    if (closeModalBtn) {
        closeModalBtn.addEventListener("click", () => {
            if (onboardTeacherModal) onboardTeacherModal.style.display = "none";
        });
    }

    const onboardTeacherForm = document.getElementById("onboard-teacher-form");
    if (onboardTeacherForm) {
        onboardTeacherForm.addEventListener("submit", (event) => {
            event.preventDefault();
            onboardTeacher();
        });
    }
}

function onboardTeacher() {
    const formData = {
        first_name: document.getElementById("onboard-teacher-first-name").value,
        last_name: document.getElementById("onboard-teacher-last-name").value,
        dateofbirth: document.getElementById("onboard-teacher-dob").value,
        email: document.getElementById("onboard-teacher-email").value,
        mobile_number: document.getElementById("onboard-teacher-mobile").value,
        password: document.getElementById("onboard-teacher-password").value,
        role: "teacher", // Hardcoded role for teachers
        _token: $('meta[name="csrf-token"]').attr("content"), // CSRF token
    };

    console.log('Onboarding Form Data:', formData); // Log form data for debugging

    $.ajax({
        url: '/staff/onboard-teacher', // Backend endpoint
        method: 'POST',
        data: formData,
        success: function (response) {
            console.log('Onboarding Response:', response); // Log response for debugging
            if (response.success) {
                alert("Teacher onboarded successfully!");
                document.getElementById("onboard-teacher-modal").style.display = "none";
                loadTeachers(); // Reload teachers list
            } else {
                alert("Error onboarding teacher: " + (response.error || 'Unknown error.'));
            }
        },
        error: function (error) {
            console.error("Onboarding Error:", error);
            alert("An error occurred during onboarding.");
        },
    });
}
