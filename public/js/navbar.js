document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.getElementById("sidebar");
    const toggle = document.getElementById("sidebarToggle");
    const mainContent = document.getElementById("mainContent");

    if (sidebar && toggle && mainContent) {
        toggle.addEventListener("click", function () {
            sidebar.classList.toggle("-translate-x-full");
            mainContent.classList.toggle("ml-64");
            mainContent.classList.toggle("ml-0");
        });
    }
});
