<?php
session_start();

// Check if the user is authenticated
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true || !isset($_SESSION['auth_token'])) {
    // If not authenticated, redirect to index.php
    header('Location: index.php');
    exit;
}

$backend_url = 'http://localhost:8080/v1/dashboard';
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

$page_title = 'Dashboard';

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
            align-items: flex-start; /* Align items to the top */
            min-height: 100vh;
            background-color: #f4f4f4;
            margin: 0;
            padding-top: 20px; /* Add some space at the top */
        }
        .container {
            text-align: center;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 80%; /* Limit container width */
            max-width: 600px; /* Max width for larger screens */
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
        ul {
            list-style: none;
            padding: 0;
            text-align: left; /* Align list items to the left */
        }
        li {
            background-color: #eee;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Messages</h1>
    <p><a href="index.php"><button style="background-color: #0275d8;">Back to Home</button></a></p>

    <?php
    if ($curl_error) {
        echo '<p style="color: red;">Error fetching messages: ' . $curl_error . '</p>';
    } elseif ($http_status === 200) {
        $messages = json_decode($response, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($messages)) {
            if (count($messages) > 0) {
                echo '<ul>';
                foreach ($messages as $message) {
                    // Assuming messages are simple strings or have a 'text' key
                    // If messages are objects, you might need to access a specific key like $message['text']
                    echo '<li>' . htmlspecialchars(is_array($message) ? json_encode($message) : $message) . '</li>'; // Handle potential non-string messages
                }
                echo '</ul>';
            } else {
                echo '<p>No messages found.</p>';
            }
        } else {
            echo '<p style="color: red;">Invalid response from backend.</p>';
            // Optionally print the raw response for debugging
            // echo '<pre>' . htmlspecialchars($response) . '</pre>';
        }
    } elseif ($http_status === 401) {
        // Token might be expired or invalid
        echo '<p style="color: red;">Unauthorized. Please login again.</p>';
        // Optionally clear the session or token and prompt re-login
        // session_unset();
        // session_destroy();
    } else {
        echo '<p style="color: red;">Error from backend: HTTP status ' . $http_status . '</p>';
        // Optionally print the raw response for debugging
        // echo '<pre>' . htmlspecialchars($response) . '</pre>';
    }
    ?>
</div>
</body>
</html>
