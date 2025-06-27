<?php
session_start();
require_once '../models/User.php';

if (isset($_POST['update_admission'])) {
    $id = $_POST['id'];
    $data = [
        'fullname' => $_POST['fullname'],
        'pid' => $_POST['pid'],
        'doctor_name' => $_POST['doctor_name'],
        'department' => $_POST['department'],
        'age' => $_POST['age'],
        'gender' => $_POST['gender'],
        'phone' => $_POST['phone']
    ];

    $user = new User();
    $updated = $user->updatePatientAdmission($id, $data);

    if ($updated) {
        header("Location: ../patient/dashboard.php?message=Admission+Updated+Successfully");
    } else {
        echo "Failed to update admission.";
    }
}
