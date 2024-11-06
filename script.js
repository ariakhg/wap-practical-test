// User detail updates
document.addEventListener('DOMContentLoaded', function() {
    const updateForm = document.getElementById('updateForm');
    const errorMessage = document.getElementById('form-error-message');
    const successMessage = document.getElementById('form-success-message');

    // Handles edit profile form submission
    updateForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Create FormData object for AJAX submission
        const formData = new FormData(updateForm);
        formData.append('update', 'true'); // Add the update parameter

        // Send AJAX request
        fetch('profile.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update form fields with new values
                document.getElementById('username').value = data.new_username;
                document.getElementById('email').value = data.new_email;
                
                // Clear password fields for security
                document.getElementById('psw').value = '';
                document.getElementById('psw-repeat').value = '';
                
                // Display success message
                successMessage.textContent = data.message;
                errorMessage.textContent = '';
            } 
            else {
                // Display error message
                errorMessage.textContent = data.message;
                successMessage.textContent = '';
            }
        })
    });
});