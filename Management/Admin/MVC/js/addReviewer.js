document
  .getElementById("reviewerForm")
  .addEventListener("submit", function (e) {
    const inputs = document.querySelectorAll("input");
    let valid = true;

    inputs.forEach((input) => {
      if (input.value.trim() === "") {
        valid = false;
        input.style.border = "2px solid red";
      } else {
        input.style.border = "1px solid #ccc";
      }
    });

    if (!valid) {
      e.preventDefault();
      alert("Please fill in all fields.");
    }
  });
