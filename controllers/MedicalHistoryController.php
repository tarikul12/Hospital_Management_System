<?php
session_start();
require_once '../models/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_history'])) {
    try {
        // Verify CSRF token
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
            throw new Exception("Invalid CSRF token");
        }

        $user = new User();

        $data = [
            'patient_id'    => trim($_POST['patient_id'] ?? ''),
            'admission_id'  => intval($_POST['admission_id'] ?? 0),
            'visit_date'    => trim($_POST['visit_date'] ?? ''),
            'diagnosis'     => trim($_POST['diagnosis'] ?? ''),
            'treatment'     => trim($_POST['treatment'] ?? ''),
            'prescription'  => trim($_POST['prescription'] ?? ''),
            'lab_results'   => trim($_POST['lab_results'] ?? ''),
            'doctor_notes'  => trim($_POST['doctor_notes'] ?? '')
        ];

        // Validate required fields
        $required = ['patient_id', 'visit_date', 'diagnosis', 'treatment'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                throw new InvalidArgumentException("Missing required field: $field");
            }
        }

        // Validate date format
        if (!DateTime::createFromFormat('Y-m-d', $data['visit_date'])) {
            throw new InvalidArgumentException("Invalid date format");
        }

        if ($user->addMedicalHistory($data)) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => 'Medical record added successfully'
            ];
            header("Location: ../views/viewHistory.php?patient_id=" . urlencode($data['patient_id']));
            exit;
        } else {
            throw new Exception("Failed to add medical record");
        }
    } catch (Exception $e) {
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => $e->getMessage()
        ];
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
} else {
    header("HTTP/1.1 403 Forbidden");
    exit("Access denied");
}