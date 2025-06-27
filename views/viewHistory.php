<?php
include('../controllers/DashboardController.php');
require_once '../models/User.php';

require_once '../models/User.php';
$user = new User();

$histories = $user->getMedicalHistory();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Medical History</title>
    <link rel="stylesheet" href="../assets/css/patientDash.css">
    <link rel="stylesheet" href="../assets/css/viewHistory.css">
    <script src="../assets/js/patientDash.js"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script src="../assets/js/viewHistory.js"></script>

</head>

<body>

    <div class="sidebar">
        <img src="../assets/images/patient.jpg" alt="User Avatar">
        <h3><?= ucfirst(explode('@', $username)[0]); ?></h3>
        <p>
        <h1><?= isset($roleName[$usertype]) ? '<b><i>' . $roleName[$usertype] . '</i></b>' : 'User'; ?></h1>
        </p>


        <a  href="#">Home</a>
        <a href="../views/doctorList.php">Doctor List</a>
        <a href="../views/patientAdForm.php">Patient Appointment </a>
        <a href="views/addhistory.php?pid=<?= urlencode($pid) ?>">Add Medical History </a>
        <a  class="active" href="views/viewhistory.php?pid=<?= urlencode($pid) ?>">View Medical History </a>
        <a href="../controllers/LogoutController.php">Log out</a>
    </div>

    <div class="content">
        <div class="topbar">
        
        </div>

            <?php if (!empty($histories)): ?>
            <h2>All Medical History Records</h2>
            <table id="historyTable" class="display">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Visit Date</th>
                        <th>Diagnosis</th>
                        <th>Treatment</th>
                        <th>Prescription</th>
                        <th>Lab Results</th>
                        <th>Doctor Notes</th>
                        <th>Added By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($histories as $history): ?>
                    <tr>
                        <td><?= htmlspecialchars($history['id']) ?></td>
                        <td><?= htmlspecialchars($history['visit_date']) ?></td>
                        <td><?= htmlspecialchars($history['diagnosis']) ?></td>
                        <td><?= htmlspecialchars($history['treatment']) ?></td>
                        <td><?= htmlspecialchars($history['prescription']) ?></td>
                        <td><?= htmlspecialchars($history['lab_results']) ?></td>
                        <td><?= htmlspecialchars($history['doctor_notes']) ?></td>
                        <td><?= htmlspecialchars($history['added_by']) ?></td>
                        <td>
                            <a href="editHistory.php?id=<?= $history['id'] ?>" class="btn-edit">Edit</a>
                            <a href="../controllers/DeleteHistoryController.php?id=<?= $history['id'] ?>"
                                class="btn-delete"
                                onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                            <a href="../controllers/ExportHistoryController.php?id=<?= $history['id'] ?>" class="btn-export">Export</a>

                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php else: ?>
            <p>No medical history records found.</p>
            <?php endif; ?>
        </div>

</body>

</html>