<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php
    if (isset($_SESSION['auth_error'])) {
        echo '<p style="color: red;">' . $_SESSION['auth_error'] . '</p>';
        unset($_SESSION['auth_error']); // Clear the error message after displaying
    }
    ?>
    <form action="login.php" method="post">
        <div>
            <label for="login">Username:</label><br>
            <input type="text" id="login" name="login" required>
        </div>
        <div>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required>
        </div>
        <br>
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <button onclick="showRegisterForm()">Register</button></p>

    <script>
    function showRegisterForm() {
        document.getElementById('login-form-container').style.display = 'none';
        document.getElementById('register-form-container').style.display = 'block';
    }
    </script>

</body>
</html>