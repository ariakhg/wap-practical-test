document.addEventListener('DOMContentLoaded', function() {
    const updateForm = document.getElementById('updateForm');
    const pictureInput = document.getElementById('picture');
    const uploadButton = document.getElementById('uploadPicture');
    const profileImage = document.getElementById('profile-image');
    const errorMessage = document.getElementById('form-error-message');
    const successMessage = document.getElementById('form-success-message');

    // Handle profile picture upload
    uploadButton.addEventListener('click', function() {
        pictureInput.click();
    });

    pictureInput.addEventListener('change', function() {
        const file = this.files[0];
        if (!file) return;

        // Validate file size (5MB max)
        if (file.size > 5 * 1024 * 1024) {
            errorMessage.textContent = 'File is too large. Maximum size is 5MB.';
            successMessage.textContent = '';
            return;
        }

        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            errorMessage.textContent = 'Invalid file type. Please upload a JPG, PNG, or GIF.';
            successMessage.textContent = '';
            return;
        }

        // Show loading state
        uploadButton.textContent = 'Uploading...';
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

        fetch('updateProfilePicture.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                successMessage.textContent = data.message;
                errorMessage.textContent = '';
                
                // Update all profile pictures on the page
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
            // Revert preview if upload failed
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