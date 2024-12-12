let menu = document.querySelector('#menu-btn');
let navbar = document.querySelector('.header .nav');
let header = document.querySelector('.header');

// Function to open the side navigation
function openSideNav() {
  const sideNav = document.getElementById("side-nav");
  const overlay = document.getElementById("overlay");

  sideNav.style.width = "250px"; // Open side nav
  overlay.style.display = "block"; // Show the overlay
}

// Function to close the side navigation
function closeSideNav() {
  const sideNav = document.getElementById("side-nav");
  const overlay = document.getElementById("overlay");

  sideNav.style.width = "0"; // Close side nav
  overlay.style.display = "none"; // Hide the overlay
}


menu.onclick = () => {
  menu.classList.toggle('fa-times');
  navbar.classList.toggle('active');
}
window.onscroll = () => {
  menu.classList.toggle('fa-times');
  navbar.classList.toggle('active');
  if (window.scrollY > 0) {
    header.classList.add('active');
  } else {
    header.classList.remove('active');
  }

}
