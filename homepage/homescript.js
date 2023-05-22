let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".sidebarBtn");
sidebarBtn.onclick = function() {
  sidebar.classList.toggle("active");
  if(sidebar.classList.contains("active")){
  sidebarBtn.classList.replace("bx-menu" ,"bx-menu-alt-right");
}else
  sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
}


// Disable back button functionality
function disableBackButton() {
    window.history.pushState(null, "", window.location.href);
    window.addEventListener("popstate", function () {
        window.history.pushState(null, "", window.location.href);
    });
}

// Call the function to disable the back button
disableBackButton();

// Logout function
function logout() {
  // Redirect the user to the correct path of logout.php
  window.location.href = 'logout.php';
}

// Add event listener to the logout link
document.getElementById('logoutLink').addEventListener('click', function(event) {
  event.preventDefault(); // Prevent the default behavior of the link
  logout(); // Call the logout function
});


