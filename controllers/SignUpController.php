<?php
// controllers/SignupController.php
session_start();
require_once '../models/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $usertype = $_POST['usertype'];

    $userModel = new User();

    if ($userModel->checkEmailExists($email)) {
        $_SESSION['signup_error'] = 'Email is already registered.';
        header('Location: ../views/signup.php');
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $success = $userModel->createUser($fullname, $email, $hashedPassword, $usertype);

    if ($success) {
    // Verify the data was inserted correctly
    $checkWebuser = $userModel->checkEmailExists($email);
    $checkSpecific = $userModel->findUserType($email);
    
    if (!$checkWebuser || !$checkSpecific) {
        // Rollback if not consistent
        $_SESSION['signup_error'] = 'Registration incomplete. Please try again.';
    } else {
        $_SESSION['signup_success'] = 'Registration successful! Please login.';
    }
}

    header('Location: ../views/signup.php');
    exit;
}
