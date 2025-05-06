document.addEventListener("DOMContentLoaded", function() {
    const mobileMenuButton = document.querySelector(
        '[data-collapse-toggle="mobile-menu-2"]'
    );
    const mobileMenu = document.getElementById("mobile-menu-2");

    mobileMenuButton.addEventListener("click", function() {
        const expanded = mobileMenuButton.getAttribute("aria-expanded") === "true";

        if (expanded) {
            // Close the mobile menu
            mobileMenuButton.setAttribute("aria-expanded", "false");
            mobileMenu.classList.remove("block");
            mobileMenu.classList.add("hidden");
        } else {
            // Open the mobile menu
            mobileMenuButton.setAttribute("aria-expanded", "true");
            mobileMenu.classList.remove("hidden");
            mobileMenu.classList.add("block");
        }
    });
});

const logoutSection = document.getElementById("logout");

var display = false;

function hideshow() {
    if (!display) {
        logoutSection.style.display = 'block';
        display = 0;
    } else {
        logoutSection.style.display = 'none';
        display = 1;
    }
    display = !display;
}
const showResultSection = document.getElementById("showResult");

function result() {
    if (!display) {
        showResultSection.style.display = "block";
        display = 0;
    }
}