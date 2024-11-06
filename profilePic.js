document.addEventListener('DOMContentLoaded', function() {
    const updateForm = document.getElementById('updateForm');
    const pictureInput = document.getElementById('picture');
    const uploadButton = document.getElementById('uploadPicture');
    const profileImage = document.getElementById('profile-image');
    const errorMessage = document.getElementById('form-error-message');
    const successMessage = document.getElementById('form-success-message');

    // Button click -> profile picture upload
    uploadButton.addEventListener('click', function() {
        pictureInput.click();
    });

    // Handle file selection
    pictureInput.addEventListener('change', function() {
        const file = this.files[0];
        if (!file) return;

        // Check file type
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            errorMessage.textContent = 'Invalid file type. Please upload a JPG, PNG, or GIF.';
            successMessage.textContent = '';
            return;
        }

        // Loading state
        uploadButton.disabled = true;

        // Show preview
        const reader = new FileReader();
        reader.onload = function(e) {
            profileImage.src = e.target.result;
        }
        reader.readAsDataURL(file);

        // Upload file
        const formData = new FormData();
        formData.append('picture', file);

        fetch('profilePic.php', {
            method: 'POST',
            body: formData
        })
        // Convert response from server to JSON format
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                successMessage.textContent = data.message;
                errorMessage.textContent = '';
                
                // Update profile picture on the page
                const profilePictures = document.querySelectorAll('.profile-btn img');
                profilePictures.forEach(img => {
                    img.src = 'uploads/' + data.picture;
                });
            } else {
                errorMessage.textContent = data.message;
                successMessage.textContent = '';
                // Revert preview if upload failed
                profileImage.src = profileImage.dataset.originalSrc;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            errorMessage.textContent = 'An error occurred while updating the profile picture.';
            successMessage.textContent = '';
            // Revert preview to original image if upload failed
            profileImage.src = profileImage.dataset.originalSrc;
        })
        .finally(() => {
            // Reset upload button
            uploadButton.textContent = 'Upload Picture';
            uploadButton.disabled = false;
            // Clear file input
            pictureInput.value = '';
        });
    });

    // Store original image source for fallback
    profileImage.dataset.originalSrc = profileImage.src;
}); 