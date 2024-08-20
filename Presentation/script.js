// script.js

// JavaScript om de foutmelding dynamisch weer te geven
if (typeof errorMsg !== 'undefined' && errorMsg !== null && errorMsg !== '') {
    document.getElementById("errorMsg").innerText = errorMsg;
}

document.addEventListener("DOMContentLoaded", function() {
    const adminToggle = document.querySelector(".admin-toggle");
    const adminPanel = document.getElementById("admin-panel");

    adminToggle.addEventListener("click", function() {
        if (adminPanel.style.display === "none" || adminPanel.style.display === "") {
            adminPanel.style.display = "block";
        } else {
            adminPanel.style.display = "none";
        }
    });
});