// loginValidation.js

document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("loginForm");
  const emailInput = document.getElementById("email");
  const passwordInput = document.getElementById("password");

  form.addEventListener("submit", function (e) {
    let errorMessage = "";

    // Check if email is empty
    if (emailInput.value.trim() === "") {
      errorMessage = "Email is required.";
    }
    // Validate email format
    else if (!validateEmail(emailInput.value.trim())) {
      errorMessage = "Please enter a valid email address.";
    }
    // Check if password is empty
    else if (passwordInput.value.trim() === "") {
      errorMessage = "Password is required.";
    }

    // If there is an error, prevent form submission and show alert
    if (errorMessage !== "") {
      e.preventDefault();
      alert(errorMessage);
      return false;
    }
    else {
      return true;
    }
  });

  // Email validation function
  function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
  }
});
