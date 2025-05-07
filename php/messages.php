<?php
session_start();

// Check if the user is authenticated
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true || !isset($_SESSION['auth_token'])) {
    // If not authenticated, redirect to index.php
    header('Location: index.php');
    exit;
}

$backend_url = 'http://localhost:8080/messages';
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

?>
<!DOCTYPE html>
<html>
<head>
    <title>Messages</title>
</head>
<body>
    <h1>Messages</h1>
    <p><a href="index.php">Back to Home</a></p>

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
                    echo '<li>' . htmlspecialchars($message) . '</li>';
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

</body>
</html>