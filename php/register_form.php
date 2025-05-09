<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        /* Styles will be inherited from index.php or can be added here */
        .form-group {
            margin-bottom: 15px;
            text-align: left; /* Align labels and inputs to the left within the centered container */
        }
         label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="password"], select {
            width: 100%; /* Make input fields and select take full width of their container */
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box; /* Include padding and border in element's total width and height */
        }
         button {
            /* Inherits button styles from index.php */
         }
    </style>
</head>
<body>
    <h2>Register</h2>
    <form action="register.php" method="post">
        <div class="form-group">
            <label for="firstName">First Name:</label>
            <input type="text" id="firstName" name="firstName" required>
        </div>
        <div class="form-group">
            <label for="lastName">Last Name:</label>
            <input type="text" id="lastName" name="lastName" required>
        </div>
        <div class="form-group">
            <label for="login">Username:</label>
            <input type="text" id="login" name="login" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="admin">Admin</option>
                <option value="user">User</option>
                <option value="tester">Tester</option>
            </select>
        </div>
        <br>
        <button type="submit">Register</button>
    </form>
    <p style="margin-top: 20px;">Already have an account? <button onclick="showLoginForm()" style="background-color: #5bc0de;">Login</button></p>

    <script>
    function showLoginForm() {
        document.getElementById('register-form-container').style.display = 'none';
        document.getElementById('login-form-container').style.display = 'block';
    }
    </script>

</body>
</html>
