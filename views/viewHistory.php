<?php
require_once '../controllers/DashboardController.php';
require_once '../models/User.php';

try {
    $patientId = $_GET['patient_id'] ?? '';
    if (!ctype_alnum($patientId)) {
        throw new InvalidArgumentException("Invalid Patient ID format");
    }

    $user = new User();
    $history = $user->getMedicalHistory($patientId);

    $searchTerm = $_GET['search'] ?? '';
    if ($searchTerm) {
        $history = array_filter($history, function($record) use ($searchTerm) {
            $fields = ['diagnosis', 'treatment', 'added_by'];
            foreach ($fields as $field) {
                if (stripos($record[$field] ?? '', $searchTerm) !== false) {
                    return true;
                }
            }
            return false;
        });
    }
} catch (Exception $e) {
    die("Error: " . htmlspecialchars($e->getMessage()));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical History | <?= htmlspecialchars($roleName[$usertype] ?? 'User') ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/viewHistory.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 sidebar">
                <div class="sidebar-sticky">
                    <div class="profile-section text-center mb-4">
                        <img src="../assets/image/patient.jpg" alt="User Avatar" class="rounded-circle">
                        <h4 class="mt-3"><?= htmlspecialchars(ucfirst(explode('@', $username)[0])) ?></h4>
                        <p class="text-muted"><?= htmlspecialchars($roleName[$usertype] ?? 'User') ?></p>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Scheduled Sessions</a></li>
                        <li class="nav-item"><a class="nav-link" href="../views/patientAdForm.php">Patient Admission</a></li>
                        <li class="nav-item"><a class="nav-link" href="../views/addHistory.php?patient_id=<?= urlencode($patientId) ?>">Add History</a></li>
                        <li class="nav-item"><a class="nav-link" href="../views/viewHistory.php?patient_id=<?= urlencode($patientId) ?>">View History</a></li>
                        <li class="nav-item"><a class="nav-link text-danger" href="../controllers/LogoutController.php">Logout</a></li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <button onclick="history.back()" class="btn btn-outline-secondary me-2">← Back</button>
                    <form class="d-flex" method="GET">
                        <input type="hidden" name="patient_id" value="<?= htmlspecialchars($patientId) ?>">
                        <input class="form-control me-2" type="search" name="search" 
                               placeholder="Search records..." value="<?= htmlspecialchars($searchTerm) ?>">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                    <span class="text-muted"><?= date("F j, Y") ?></span>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Medical History for Patient ID: <?= htmlspecialchars($patientId) ?></h2>
                    <a href="exportPDF.php?patient_id=<?= urlencode($patientId) ?>" class="btn btn-danger">
                        <i class="bi bi-file-earmark-pdf"></i> Export PDF
                    </a>
                </div>

                <?php if (!empty($history)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Visit Date</th>
                                    <th>Diagnosis</th>
                                    <th>Treatment</th>
                                    <th>Prescription</th>
                                    <th>Lab Results</th>
                                    <th>Doctor Notes</th>
                                    <th>Added By</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($history as $record): ?>
                                <tr>
                                    <td><?= htmlspecialchars($record['visit_date']) ?></td>
                                    <td><?= nl2br(htmlspecialchars($record['diagnosis'])) ?></td>
                                    <td><?= nl2br(htmlspecialchars($record['treatment'])) ?></td>
                                    <td><?= nl2br(htmlspecialchars($record['prescription'])) ?></td>
                                    <td><?= nl2br(htmlspecialchars($record['lab_results'])) ?></td>
                                    <td><?= nl2br(htmlspecialchars($record['doctor_notes'])) ?></td>
                                    <td><?= htmlspecialchars($record['added_by']) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info text-center">
                        <p class="mb-4">No medical history records found for this patient.</p>
                        <a href="addHistory.php?patient_id=<?= urlencode($patientId) ?>" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Add New Record
                        </a>
                    </div>
                <?php endif; ?>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>