// User detail updates
document.addEventListener('DOMContentLoaded', function() {
    const updateForm = document.getElementById('updateForm');
    const errorMessage = document.getElementById('form-error-message');
    const successMessage = document.getElementById('form-success-message');

    updateForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Create FormData object
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
                
                // Clear password fields
                document.getElementById('psw').value = '';
                document.getElementById('psw-repeat').value = '';
                
                // Show success message
                successMessage.textContent = data.message;
                errorMessage.textContent = '';
            } else {
                // Show error message
                errorMessage.textContent = data.message;
                successMessage.textContent = '';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            errorMessage.textContent = 'An error occurred while updating the profile.';
            successMessage.textContent = '';
        });
    });
});