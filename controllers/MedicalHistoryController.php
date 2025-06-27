<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once '../models/User.php';

$user = new User();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_history'])) {
    $data = [
        'visit_date'    => trim($_POST['visit_date'] ?? ''),
        'diagnosis'     => trim($_POST['diagnosis'] ?? ''),
        'treatment'     => trim($_POST['treatment'] ?? ''),
        'prescription'  => trim($_POST['prescription'] ?? ''),
        'lab_results'   => trim($_POST['lab_results'] ?? ''),
        'doctor_notes'  => trim($_POST['doctor_notes'] ?? ''),
        'added_by'      => $_SESSION['user_id'] ?? 'system'
    ];

    foreach (['visit_date', 'diagnosis', 'treatment'] as $field) {
        if (empty($data[$field])) {
            $_SESSION['error'] = "Please fill out the required field: " . ucfirst(str_replace('_', ' ', $field));
            header('Location: ../views/addHistory.php');
            exit;
        }
    }

    $success = $user->addMedicalHistory($data);

    $_SESSION[$success ? 'success' : 'error'] =
        $success ? "Medical history added successfully." : "Failed to add medical history. Please try again.";

    header('Location: ../views/addHistory.php');
    exit;
}
?>
