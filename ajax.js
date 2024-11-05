document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("updateForm").addEventListener("submit", function (e) {
        e.preventDefault(); // Prevent the default form submission

        var formData = new FormData(this);
        
        fetch("profile.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the form fields with the new values
                document.getElementById("username").value = data.new_username;
                document.getElementById("email").value = data.new_email;
                document.getElementById("psw").value = ""; // Clear password fields
                document.getElementById("psw-repeat").value = ""; // Clear password fields
                document.getElementById("successMessage").innerText = data.message;
            } else {
                document.getElementById("errorMessage").innerText = data.message;
            }
        })
        .catch(error => {
            console.error("Error:", error);
        });
    });
});
