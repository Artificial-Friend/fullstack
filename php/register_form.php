<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <form action="register.php" method="post">
        <div>
            <label for="firstName">First Name:</label><br>
            <input type="text" id="firstName" name="firstName" required>
        </div>
        <div>
            <label for="lastName">Last Name:</label><br>
            <input type="text" id="lastName" name="lastName" required>
        </div>
        <div>
            <label for="login">Username:</label><br>
            <input type="text" id="login" name="login" required>
        </div>
        <div>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required>
        </div>
        <br>
        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <button onclick="showLoginForm()">Login</button></p>

    <script>
    function showLoginForm() {
        document.getElementById('register-form-container').style.display = 'none';
        document.getElementById('login-form-container').style.display = 'block';
    }
    </script>

</body>
</html>