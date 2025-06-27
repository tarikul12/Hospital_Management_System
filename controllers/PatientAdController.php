<?php
require_once '../models/User.php';

$user = new User();
$admissions = $user->getAllAdmissions();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname     = $_POST['fullname'] ?? '';
    $pid          = $_POST['pid'] ?? '';
    $doctor_name  = $_POST['doctor_name'] ?? '';
    $department   = $_POST['department'] ?? '';
    $age          = $_POST['age'] ?? '';
    $gender       = $_POST['gender'] ?? '';
    $phone        = $_POST['phone'] ?? '';

    $userModel = new User();

    $saved = $userModel->addPatientAdmission($fullname, $pid, $doctor_name, $department, $age, $gender, $phone);

    if ($saved) {
        header("Location: ../views/patientAdForm.php?msg=Admission+successful");
    } else {
        header("Location: ../views/patientAdForm.php?msg=Error+saving+data");
    }
    exit;
}
