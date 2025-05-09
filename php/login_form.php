<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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
        input[type="text"], input[type="password"] {
            width: 100%; /* Make input fields take full width of their container */
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
    <h2>Login</h2>
    <?php
    if (isset($_SESSION['auth_error'])) {
        echo '<p style="color: red;">' . $_SESSION['auth_error'] . '</p>';
        // Note: Unsetting the error is handled in index.php now
    }
    ?>
    <form action="login.php" method="post">
        <div class="form-group">
            <label for="login">Username:</label>
            <input type="text" id="login" name="login" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <br>
        <button type="submit">Login</button>
    </form>
    <p style="margin-top: 20px;">Don't have an account? <button onclick="showRegisterForm()" style="background-color: #f0ad4e;">Register</button></p>

    <script>
    function showRegisterForm() {
        document.getElementById('login-form-container').style.display = 'none';
        document.getElementById('register-form-container').style.display = 'block';
    }
    </script>

</body>
</html>