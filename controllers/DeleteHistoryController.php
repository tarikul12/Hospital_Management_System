<?php
require_once '../models/User.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user = new User();
    $id = (int) $_GET['id'];

    if ($user->deleteMedicalHistory($id)) {
        header("Location: ../views/viewHistory.php?deleted=1");
        exit;
    } else {
        header("Location: ../views/viewHistory.php?error=1");
        exit;
    }
} else {
    header("Location: ../views/viewHistory.php");
    exit;
}
