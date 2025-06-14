<?php
// controllers/DashboardController.php
session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['usertype'])) {
    // User not logged in, redirect to login page
    header('Location: ../views/login.php');
    exit;
}

// Optionally you can add extra logic here like loading data from DB for dashboard

// Render dashboard view
include '../admin/dashboard.php';
