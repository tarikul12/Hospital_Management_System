<?php
session_start();
require_once '../models/User.php';

date_default_timezone_set('Asia/Kolkata');
$_SESSION["date"] = date('Y-m-d');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['useremail'] ?? '');
    $password = $_POST['userpassword'] ?? '';

    $userModel = new User();
    
    // First check if email exists in any user table
    $usertype = $userModel->findUserType($email);
    
    if (!$usertype) {
        $_SESSION['error'] = 'We can\'t find any account for this email.';
        header('Location: ../views/login.php');
        exit;
    }

    // Now verify credentials
    $userInfo = $userModel->validateCredentials($email, $password, $usertype);
    
    if ($userInfo) {
        $_SESSION['user'] = $userInfo['name'];
        $_SESSION['useremail'] = $email;
        $_SESSION['usertype'] = $usertype;
        $_SESSION['userid'] = $userInfo['id']; // Store user ID if needed

        // Redirect based on user type
        switch ($usertype) {
            case 'p': header('Location: ../patient/dashboard.php'); exit;
            case 'a': header('Location: ../admin/dashboard.php'); exit;
            case 'd': header('Location: ../doctor/dashboard.php'); exit;
        }
    } else {
        $_SESSION['error'] = 'Invalid password. Please try again.';
        header('Location: ../views/login.php');
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['useremail'] ?? '';
    $password = $_POST['userpassword'] ?? '';

    $userModel = new User();
    $usertype = $userModel->getUserNameByEmail($email,$usertype);

    if ($usertype) {
        $valid = $userModel->validateCredentials($email, $password, $usertype);
        if ($valid) {
            $_SESSION['user'] = $email;
            $_SESSION['usertype'] = $usertype;

            // Redirect based on user type
            switch ($usertype) {
                case 'p': header('Location: ../patient/dashboard.php'); exit;
                case 'a': header('Location: ../admin/dashboard.php'); exit;
                case 'd': header('Location: ../doctor/dashboard.php'); exit;
                default:
                    $_SESSION['error'] = 'Unknown user type.';
                    break;
            }
        } else {
            $_SESSION['error'] = 'Wrong credentials: Invalid email or password.';
        }
    } else {
        $_SESSION['error'] = 'We can’t find any account for this email.';
    }

    header('Location: ../views/login.php');
    exit;
}
