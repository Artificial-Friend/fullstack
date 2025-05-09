<?php
session_start();

// --- Favicon quick exit (to prevent it from running full script) ---
if (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] === '/favicon.ico') {
    http_response_code(204); // No Content
    exit;
}

if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
    $page_title = 'Welcome';
    // Show authenticated content
    $content = '<h1>Welcome, ' . htmlspecialchars($_SESSION['username']) . '!</h1>';
    $content .= '<div style="margin-top: 20px;">';
    $content .= '<form action="logout.php" method="post" style="display:inline-block; margin-right: 10px;"><button type="submit" style="padding: 10px 20px; cursor: pointer;">Logout</button></form>';

    $page_title = 'Home'; // Default title



    $backend_url = 'http://localhost:8080/v1/user-data';
    $auth_token = $_SESSION['auth_token'];

    $ch = curl_init($backend_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $auth_token
    ]);

    $response = curl_exec($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);

    curl_close($ch);

    $responseData = json_decode($response, true);
    $_SESSION['role'] = $responseData['role'];

    if ($_SESSION['role'] === 'admin') {
        $content .= '<a href="dashboard.php"><button style="padding: 10px 20px; cursor: pointer;">Dashboard</button></a>';
    }
    $content .= '<a href="messages.php"><button style="padding: 10px 20px; cursor: pointer;">Messages</button></a>';
} else {
    $page_title = 'Welcome Guest';
    // Show login/registration forms
    $content = '<h1>Welcome Guest!</h1>';
    // Display authentication errors if any
    if (isset($_SESSION['auth_error']) && $_SESSION['auth_error'] !== '') {
        $content .= '<p style="color: red;">' . $_SESSION['auth_error'] . '</p>';
        unset($_SESSION['auth_error']); // Clear the error message after displaying
    }
    $content .= '<div id="login-form-container">';
     ob_start();
    include 'login_form.php';
    $content .= ob_get_clean();
    $content .= '</div>';
    $content .= '<div id="register-form-container" style="display:none;">';
     ob_start();
    include 'register_form.php';
    $content .= ob_get_clean();
}
$content .= '</div>';

?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $page_title; ?></title>
    <style>
        body {
            font-family: sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f4f4;
            margin: 0;
        }
        .container {
            text-align: center;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
         h1 {
            color: #333;
            margin-bottom: 20px;
        }
         button {
            background-color: #5cb85c; /* Green */
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
            margin: 5px;
        }
        button:hover {
            background-color: #4cae4c;
        }
         a button {
            text-decoration: none;
            display: inline-block; /* Allows padding and margin */
        }
    </style>
</head>
<body>
    <div class="container">
        <?php echo $content; ?>
    </div>
</body>
</html>