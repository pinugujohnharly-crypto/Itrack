document.addEventListener("DOMContentLoaded", function () {
    const profileBtn = document.querySelector(".profile-btn");
    const dropdown = document.querySelector(".profile-dropdown");

    profileBtn.addEventListener("click", function (e) {
        e.stopPropagation();
        dropdown.classList.toggle("show");
    });

    document.addEventListener("click", function () {
        dropdown.classList.remove("show");
    });
});
