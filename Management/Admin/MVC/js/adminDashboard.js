document.addEventListener("DOMContentLoaded", function () {
  const logoutBtn = document.querySelector(".logout");

  if (logoutBtn) {
    logoutBtn.addEventListener("click", function (e) {
      const confirmLogout = confirm("Are you sure you want to logout?");
      if (!confirmLogout) {
        e.preventDefault();
      }
    });
  }
  const btn = document.getElementById("manageJournalBtn");
  const menu = document.getElementById("journalMenu");

  if (btn && menu) {
    btn.addEventListener("click", function () {
      menu.style.display = menu.style.display === "flex" ? "none" : "flex";
    });
  }
});
