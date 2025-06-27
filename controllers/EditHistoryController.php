<?php
require_once '../models/User.php';

$user = new User();
$history = null;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    // Fetch the history record to prefill the form
    $history = $user->getMedicalHistory((int)$_GET['id']);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_history'])) {
    $data = [
        'id'           => (int)$_POST['id'],
        'visit_date'   => $_POST['visit_date'],
        'diagnosis'    => $_POST['diagnosis'],
        'treatment'    => $_POST['treatment'],
        'prescription' => $_POST['prescription'],
        'lab_results'  => $_POST['lab_results'],
        'doctor_notes' => $_POST['doctor_notes'],
    ];
    
    $user->updateMedicalHistory($data);
    header("Location: ../views/viewHistory.php");
    exit;
}
?>
