<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';

    $backend_url = 'http://localhost:8080/login';

    $data = json_encode(['login' => $login, 'password' => $password]);

    $ch = curl_init($backend_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $response = curl_exec($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);

    curl_close($ch);

    if ($curl_error) {
        // Handle cURL errors (e.g., backend not running)
        $_SESSION['auth_error'] = 'Error connecting to backend: ' . $curl_error;
    } elseif ($http_status === 201 || $http_status === 200) {
        // Successful login
        $responseData = json_decode($response, true);
        if (isset($responseData['token'])) {
            $_SESSION['authenticated'] = true;
            $_SESSION['auth_token'] = $responseData['token']; // Store the token
            $_SESSION['username'] = $login; // Store username (optional, depends on backend response)
            // Backend might return user details, could store those too.
            $_SESSION['auth_error'] = ''; // Clear any previous errors
        } else {
            // Success status but no token received
             $_SESSION['auth_error'] = 'Login successful, but no token received from backend.';
        }
    } elseif ($http_status === 401 || $http_status === 403 || $http_status === 404) {
        // Authentication failed (Unauthorized)
        $_SESSION['authenticated'] = false;
        $_SESSION['auth_token'] = null;
        $_SESSION['auth_error'] = 'Invalid login or password.';
    } else {
        // Other HTTP errors
         $_SESSION['authenticated'] = false;
         $_SESSION['auth_token'] = null;
        $_SESSION['auth_error'] = 'Backend error: HTTP status ' . $http_status;
    }

    header('Location: index.php');
    exit;
}

// If accessed directly without POST
header('Location: index.php');
exit;
?>