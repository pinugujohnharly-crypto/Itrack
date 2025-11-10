const navToggle = document.getElementById("navToggle");
const sidebar = document.getElementById("sidebar");
const navslide = document.querySelector(".navslide");

// Start closed
sidebar.classList.add("closed");
navslide.classList.add("closed");

navToggle.addEventListener("click", () => {
  sidebar.classList.toggle("closed");
  navslide.classList.toggle("closed");
});
