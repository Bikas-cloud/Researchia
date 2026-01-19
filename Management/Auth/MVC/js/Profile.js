alert("Profile.js loaded");
function editField(field) {
  const el = document.getElementById(field + "Text");
  const old = el.innerText;

  const input = document.createElement("textarea");
  input.value = old;
  input.className = "inline-input";

  el.replaceWith(input);
  input.focus();

  input.onblur = () => {
    fetch("../php/updateProfile.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `field=${field}&value=${encodeURIComponent(input.value)}`,
    })
      .then((res) => res.text())
      .then((res) => {
        const p = document.createElement("p");
        p.id = field + "Text";
        p.innerText = input.value;

        input.replaceWith(p);
      });
  };
}

/* Profile Picture */
document.getElementById("profilePicInput").addEventListener("change", () => {
  const formData = new FormData();
  formData.append("profile_pic", profilePicInput.files[0]);

  fetch("../php/uploadProfilePic.php", {
    method: "POST",
    body: formData,
  })
    .then((res) => res.text())
    .then((res) => {
      document.getElementById("profileImage").src = "../uploads/profile/" + res;
    });
});

/* DARK MODE */
const btn = document.getElementById("themeToggle");
btn.onclick = () => {
  document.body.classList.toggle("dark");
  if (!btn) return;

  btn.onclick = () => {
    document.body.classList.toggle("dark");

    const theme = document.body.classList.contains("dark") ? "dark" : "light";
    document.cookie = `theme=${theme}; path=/; max-age=31536000`;
  };
};
