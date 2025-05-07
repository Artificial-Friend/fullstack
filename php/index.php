<?php
session_start();

if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
    // Show authenticated content
    echo '<h1>Welcome, ' . htmlspecialchars($_SESSION['username']) . '!</h1>';
    echo '<form action="logout.php" method="post" style="display:inline;"><button type="submit">Logout</button></form>';
    echo '<a href="messages.php"><button>Messages</button></a>'; // Messages button for authenticated users
} else {
    // Show login/registration forms
    echo '<h1>Welcome Guest!</h1>';
    // Display authentication errors if any
    if (isset($_SESSION['auth_error']) && $_SESSION['auth_error'] !== '') {
        echo '<p style="color: red;">' . $_SESSION['auth_error'] . '</p>';
        unset($_SESSION['auth_error']); // Clear the error message after displaying
    }
    echo '<div id="login-form-container">';
    include 'login_form.php';
    echo '</div>';
    echo '<div id="register-form-container" style="display:none;">';
    include 'register_form.php';
    echo '</div>';
}

?>