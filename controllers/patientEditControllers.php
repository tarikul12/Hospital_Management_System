<?php
session_start();
require_once '../models/User.php';

if (!isset($_GET['id'])) {
    header('Location: dashboard.php');
    exit();
}

$id = $_GET['id'];
$user = new User();
$admission = $user->getAdmissionById($id); // Make sure this method exists

if (!$admission) {
    echo "Patient admission not found.";
    exit();
}


if (!isset($_SESSION['user']) || !isset($_SESSION['usertype'])) {
    header('Location: ../views/login.php');
    exit;
}

$usertype = $_SESSION['usertype'];
$username = $_SESSION['user'];

$roleName = [
    'a' => 'Admin',
    'd' => 'Doctor',
    'p' => 'Patient'
];

require_once '../models/User.php';
$user = new User();

$search = $_GET['search'] ?? '';
if (!empty($search)) {
    $patient_admissions = $user->searchPatientAdmissions($search);
} else {
    $patient_admissions = $user->getAllAdmissions();
}
?>