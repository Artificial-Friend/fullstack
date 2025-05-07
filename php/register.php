<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstName'] ?? '';
    $lastName = $_POST['lastName'] ?? '';
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';

    $backend_url = 'http://localhost:8080/register';

    $data = json_encode([
        'firstName' => $firstName,
        'lastName' => $lastName,
        'login' => $login,
        'password' => $password
    ]);

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
        // Handle cURL errors
        $_SESSION['auth_error'] = 'Error connecting to backend: ' . $curl_error;
    } elseif ($http_status === 200 || $http_status === 201) {
        // Successful registration
        $responseData = json_decode($response, true);
         if (isset($responseData['token'])) {
            $_SESSION['authenticated'] = true;
            $_SESSION['auth_token'] = $responseData['token']; // Store the token
            $_SESSION['username'] = $login; // Store username (optional)
             $_SESSION['auth_error'] = ''; // Clear any previous errors
        } else {
            // Success status but no token received
             $_SESSION['auth_error'] = 'Registration successful, but no token received from backend.';
              // Optionally set authenticated to true even without a token if backend design allows registration without immediate login token
              // $_SESSION['authenticated'] = true;
               $_SESSION['username'] = $login; // Still might want to show welcome message with username
        }

    } else {
        // Handle other HTTP errors (e.g., user already exists, validation errors)
        $_SESSION['authenticated'] = false;
        $_SESSION['auth_token'] = null;
        $error_message = 'Registration failed: HTTP status ' . $http_status;
        $responseData = json_decode($response, true);
        if (isset($responseData['message'])) {
            $error_message .= ' - ' . $responseData['message'];
        }
        $_SESSION['auth_error'] = $error_message;
    }

    header('Location: index.php');
    exit;
}

// If accessed directly without POST
header('Location: index.php');
exit;
?>