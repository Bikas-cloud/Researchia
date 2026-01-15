document.getElementById("paperForm").addEventListener("submit", function (e) {
  const fileInput = document.querySelector("input[type='file']");
  const file = fileInput.files[0];

  if (!file) {
    alert("Please upload a paper file.");
    e.preventDefault();
    return;
  }

  if (file.type !== "application/pdf") {
    alert("Only PDF files are allowed.");
    e.preventDefault();
    return;
  }

  if (file.size > 10 * 1024 * 1024) {
    alert("File size must be under 10MB.");
    e.preventDefault();
  }
});
