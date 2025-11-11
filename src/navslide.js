const navToggle = document.getElementById("navToggle");
const sidebar = document.getElementById("sidebar");
const navslide = document.querySelector(".navslide");
const contentContainer = document.querySelector(".content-container");
const pager = document.querySelector(".pager");

sidebar.classList.add("closed");
navslide.classList.add("closed");

navToggle.addEventListener("click", () => {
  sidebar.classList.toggle('open');
  navslide.classList.toggle("closed");
  document.body.classList.toggle("sidebar-open"); // 👈 add this
  document.body.classList.toggle("no-scroll"); // 👈 add this
});

