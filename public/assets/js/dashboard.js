document.addEventListener("DOMContentLoaded", () => {
    initAccountPanelToggle();
    initLogoutConfirmation();
    loadProfileOnAccountClick();
    attachProfileEventListeners();
});

// Initialize account panel toggle functionality
function initAccountPanelToggle() {
    const accountLink = document.getElementById("accountLink");
    const accountPanel = document.getElementById("accountPanel");
    const closeBtn = document.getElementById("closeAccountPanel");

    if (accountLink && accountPanel && closeBtn) {
        accountLink.addEventListener("click", (event) => {
            event.preventDefault();
            toggleAccountPanel(accountPanel);
        });

        closeBtn.addEventListener("click", (event) => {
            event.preventDefault();
            toggleAccountPanel(accountPanel);
        });

        window.addEventListener("click", (event) => {
            if (!accountPanel.contains(event.target) && event.target !== accountLink) {
                accountPanel.classList.remove("visible");
            }
        });
    }
}

// Toggle visibility of the account panel
function toggleAccountPanel(panel) {
    panel.classList.toggle("visible");
}

// Initialize logout confirmation
function initLogoutConfirmation() {
    const logoutBtn = document.querySelector(".logout-btn");
    const logoutForm = document.getElementById("logoutForm");

    if (logoutBtn && logoutForm) {
        logoutBtn.addEventListener("click", (event) => {
            event.preventDefault();
            if (confirm("Are you sure you want to log out?")) {
                logoutForm.submit();
            }
        });
    }
}

// Function to load profile via AJAX
function loadProfileOnAccountClick() {
    const profileLink = document.getElementById("profile-link");
    
    if (profileLink) {
        profileLink.addEventListener("click", (event) => {
            event.preventDefault();
            loadProfile();
        });
    }
}

function loadProfile() {
    const userEmail = $("#user_email").val();
    console.log("User email:", userEmail);

    $.ajax({
        url: '/profile',
        method: 'GET',
        data: {
            user_email: userEmail
        },
        success: function(response) {
            $('.main-content').html(response);
            attachProfileEventListeners();  // Attach profile-specific event listeners
        },
        error: function(error) {
            console.log("Error loading profile:", error);
        }
    });
}

// Attach event listeners for profile edit and save functionality
function attachProfileEventListeners() {
    const editProfileBtn = document.getElementById("edit-profile-btn");
    const cancelEditBtn = document.getElementById("cancel-edit-btn");
    const saveChangesBtn = document.getElementById("save-changes");
    const profileView = document.getElementById("profile-view");
    const profileEdit = document.getElementById("profile-edit");

    if (editProfileBtn && cancelEditBtn && profileView && profileEdit) {
        // Show the edit form and hide the view-only section
        editProfileBtn.addEventListener("click", () => {
            profileView.style.display = "none";
            profileEdit.style.display = "block";
        });

        // Hide the edit form and show the view-only section
        cancelEditBtn.addEventListener("click", () => {
            profileEdit.style.display = "none";
            profileView.style.display = "block";
        });
    }

    // Save changes button functionality
    if (saveChangesBtn) {
        saveChangesBtn.addEventListener("click", (event) => {
            event.preventDefault();
            saveProfileChanges();
        });
    }
}

// Function to save profile changes via AJAX with CSRF token
function saveProfileChanges() {
    const formData = {
        first_name: document.getElementById("first_name").value,
        last_name: document.getElementById("last_name").value,
        dateofbirth: document.getElementById("dateofbirth").value,
        mobile_number: document.getElementById("mobile_number").value,
        email: document.getElementById("email").value,
        _token: $('meta[name="csrf-token"]').attr('content')  // CSRF token
    };

    $.ajax({
        url: '/profile/update',
        method: 'POST',
        data: formData,
        success: function(response) {
            if (response.success) {
                // Display success message
                $('#success-message').show();

                // Update profile view with new data
                document.querySelector("#profile-view .profile-section").innerHTML = `
                    <p><strong>First Name:</strong> ${response.user.first_name}</p>
                    <p><strong>Last Name:</strong> ${response.user.last_name}</p>
                    <p><strong>Date of Birth:</strong> ${response.user.dateofbirth}</p>
                    <p><strong>Mobile Number:</strong> ${response.user.mobile_number}</p>
                `;
                 // Update profile header with new data
                 const profileHeader = document.querySelector(".profile-container h2");
                 profileHeader.innerText = `${response.user.first_name.toUpperCase()} ${response.user.last_name.toUpperCase()}'s Profile`;
                 
                // Toggle to non-edit view
                $('#profile-edit').hide();
                $('#profile-view').show();
            } else {
                alert("Error updating profile: " + response.error);
            }
        },
        error: function(error) {
            console.log("Error updating profile:", error);
            alert("An error occurred while updating your profile.");
        }
    });
}
