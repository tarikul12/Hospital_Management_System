<?php
session_start();
require_once '../models/User.php';

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

$user = new User();

$search = $_GET['search'] ?? '';
$patient_admissions = !empty($search)
    ? $user->searchPatientAdmissions($search)
    : $user->getAllAdmissions();

$msg = $_GET['msg'] ?? '';
?>