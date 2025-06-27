<?php
require_once '../models/User.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $user = new User();
    $record = $user->getMedicalHistory($id);

    if (!$record) {
        die("No record found to export.");
    }

    // Output headers for CSV download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=medical_history_' . $id . '.csv');

    $output = fopen('php://output', 'w');

    // Add column headers
    fputcsv($output, array_keys($record));

    // Add record row
    fputcsv($output, array_values($record));

    fclose($output);
    exit;
} else {
    echo "Invalid ID.";
    exit;
}
