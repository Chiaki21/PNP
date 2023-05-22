// Disable back button functionality
function disableBackButton() {
    window.history.pushState(null, "", window.location.href);
    window.addEventListener("popstate", function () {
        window.history.pushState(null, "", window.location.href);
    });
}

// Call the function to disable the back button
disableBackButton();

// Continue button click event
document.getElementById('continue-btn').addEventListener('click', function() {
    window.location.href = 'homepage/homelog.php';
});
