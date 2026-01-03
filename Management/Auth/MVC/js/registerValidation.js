document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("loginForm");

  form.addEventListener("submit", function (e) {
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();

    // Email validation
    if (email === "") {
      alert("Email is required");
      e.preventDefault();
      return;
    }

    // Password validation
    if (password === "") {
      alert("Password is required");
      e.preventDefault();
      return;
    }

    if (password.length < 6) {
      alert("Password must be at least 6 characters");
      e.preventDefault();
      return;
    }
  });
});
