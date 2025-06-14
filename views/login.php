<!-- views/login.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/animations.css">
    <link rel="stylesheet" href="../assets/css/login.css">
    <link rel="stylesheet" href="../assets/css/main.css"> 

</head>
<body>
    <center>
    <div class="container">
        <table border="0" style="width: 60%;">
            <tr><td><p class="header-text">Welcome Back!</p></td></tr>
            <tr><td><p class="sub-text">Login with your details to continue</p></td></tr>
            <form action="../controllers/LoginController.php" method="POST">
                <tr><td class="label-td">
                    <label for="useremail" class="form-label">Email:</label>
                </td></tr>
                <tr><td class="label-td">
                    <input type="email" name="useremail" class="input-text" placeholder="Email Address" required>
                </td></tr>
                <tr><td class="label-td">
                    <label for="userpassword" class="form-label">Password:</label>
                </td></tr>
                <tr><td class="label-td">
                    <input type="password" name="userpassword" class="input-text" placeholder="Password" required>
                </td></tr>
                <tr><td>
                    <br>
                    <?php
                    session_start();
                    if (isset($_SESSION['error'])) {
                        echo '<label class="form-label" style="color:red;">' . $_SESSION['error'] . '</label>';
                        unset($_SESSION['error']);
                    }
                    ?>
                </td></tr>
                <tr><td>
                    <input type="submit" value="Login" class="login-btn btn-primary btn">
                </td></tr>
                <tr><td>
                    <br>
                    <label class="sub-text">Don't have an account? </label>
                    <a href="../views/signup.php" class="hover-link1 non-style-link">Sign Up</a>
                    <br><br><br>
                </td></tr>
            </form>
        </table>
    </div>
    </center>
</body>
</html>
