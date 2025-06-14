<!-- views/signup.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../assets/css/signup.css">
    <link rel="stylesheet" href="../assets/css/main.css">

</head>
<body>
    <center>
        <div class="container">
            <form action="../controllers/SignupController.php" method="POST">
                <h2>Create an Account</h2>
                <?php
                session_start();
                if (isset($_SESSION['signup_error'])) {
                    echo '<p style="color:red;">' . $_SESSION['signup_error'] . '</p>';
                    unset($_SESSION['signup_error']);
                }
                if (isset($_SESSION['signup_success'])) {
                    echo '<p style="color:green;">' . $_SESSION['signup_success'] . '</p>';
                    unset($_SESSION['signup_success']);
                }
                ?>
                <label>Full Name:</label><br>
                <input type="text" name="fullname" required><br><br>

                <label>Email:</label><br>
                <input type="email" name="email" required><br><br>

                <label>Password:</label><br>
                <input type="password" name="password" required><br><br>

                <label>User Type:</label><br>
                <select name="usertype" required>
                    <option value="p">Patient</option>
                    <option value="a">Admin</option>
                    <option value="d">Doctor</option>
                </select><br><br>

                <input type="submit" value="Sign Up"><br><br>

                <a href="login.php">Already have an account? Login</a>
            </form>
        </div>
    </center>
</body>
</html>
