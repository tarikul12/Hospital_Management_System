<?php
require_once '../controllers/DashboardController.php';
require_once '../models/User.php';

$patientId = $_GET['patient_id'] ?? '';
$admissionId = $_GET['admission_id'] ?? '';

if (!ctype_alnum($patientId)) {
    die("Invalid Patient ID");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Medical History | <?= htmlspecialchars($roleName[$usertype] ?? 'User') ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/addHistory.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar (same as viewHistory.php) -->
            <nav class="col-md-3 col-lg-2 sidebar">
                <!-- Include the same sidebar code from viewHistory.php -->
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <button onclick="history.back()" class="btn btn-outline-secondary me-2">← Back</button>
                    <h2>Add Medical History Record</h2>
                    <span class="text-muted"><?= date("F j, Y") ?></span>
                </div>

                <form action="../controllers/MedicalHistoryController.php" method="POST" class="needs-validation" novalidate>
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                    <input type="hidden" name="patient_id" value="<?= htmlspecialchars($patientId) ?>">
                    <input type="hidden" name="admission_id" value="<?= htmlspecialchars($admissionId) ?>">

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Patient ID</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($patientId) ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Admission ID</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($admissionId) ?>" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="visit_date" class="form-label">Date of Visit *</label>
                        <input type="date" class="form-control" id="visit_date" name="visit_date" required>
                        <div class="invalid-feedback">Please provide a visit date</div>
                    </div>

                    <div class="mb-3">
                        <label for="diagnosis" class="form-label">Diagnosis *</label>
                        <textarea class="form-control" id="diagnosis" name="diagnosis" rows="3" required></textarea>
                        <div class="invalid-feedback">Please enter a diagnosis</div>
                    </div>

                    <div class="mb-3">
                        <label for="treatment" class="form-label">Treatment *</label>
                        <textarea class="form-control" id="treatment" name="treatment" rows="3" required></textarea>
                        <div class="invalid-feedback">Please describe the treatment</div>
                    </div>

                    <div class="mb-3">
                        <label for="prescription" class="form-label">Prescription</label>
                        <textarea class="form-control" id="prescription" name="prescription" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="lab_results" class="form-label">Lab Results</label>
                        <textarea class="form-control" id="lab_results" name="lab_results" rows="3"></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="doctor_notes" class="form-label">Doctor Notes</label>
                        <textarea class="form-control" id="doctor_notes" name="doctor_notes" rows="3"></textarea>
                    </div>

                    <button type="submit" name="add_history" class="btn btn-primary btn-lg w-100">
                        <i class="bi bi-plus-circle"></i> Add Medical Record
                    </button>
                </form>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Form validation
    (function() {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
    </script>
</body>
</html>