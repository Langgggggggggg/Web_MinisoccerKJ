const menuToggle = document.getElementById("menu-toggle");
const sidebar = document.getElementById("sidebar");
const closeMenu = document.getElementById("close-menu");
const hamburgerIcon = document.getElementById("hamburger-icon");
const closeIcon = document.getElementById("close-icon");

menuToggle.addEventListener("click", function () {
    sidebar.classList.remove("-translate-x-full");
    hamburgerIcon.classList.add("hidden");
    closeIcon.classList.remove("hidden");
});

closeMenu.addEventListener("click", function () {
    sidebar.classList.add("-translate-x-full");
    hamburgerIcon.classList.remove("hidden");
    closeIcon.classList.add("hidden");
});
