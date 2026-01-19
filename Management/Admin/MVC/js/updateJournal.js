document
  .getElementById("updateJournalForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    const form = this;
    const msg = document.getElementById("formMsg");
    const data = new FormData(form);

    msg.textContent = "Updating...";
    msg.className = "info";

    fetch("../php/updateJournalAction.php", {
      method: "POST",
      body: data,
    })
      .then((res) => res.text())
      .then((res) => {
        if (res === "success") {
          msg.textContent = "Journal updated successfully";
          msg.className = "success";
        } else {
          msg.textContent = res;
          msg.className = "error";
        }
      });
  });
