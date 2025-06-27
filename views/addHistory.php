<?php
include('../controllers/DashboardController.php');
require_once '../models/User.php';


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Medical History</title>
    <link rel="stylesheet" href="../assets/css/patientDash.css">
    <link rel="stylesheet" href="../assets/css/addHistory.css">
    <script src="../assets/js/patientDash.js"></script>
</head>

<body>

    <div class="sidebar">
        <img src="../assets/images/patient.jpg" alt="User Avatar">
        <h3><?= ucfirst(explode('@', $username)[0]); ?></h3>
        <p>
        <h1><?= isset($roleName[$usertype]) ? '<b><i>' . $roleName[$usertype] . '</i></b>' : 'User'; ?></h1>
        </p>


        <a href="#">Home</a>
        <a href="../views/doctorList.php">Doctor List</a>
        <a href="../views/patientAdForm.php">Patient Appointment </a>
        <a class="active" href="views/addhistory.php?pid=<?= urlencode($pid) ?>">Add Medical History </a>
        <a href="../views/viewHistory.php">View Medical History </a>
        <a href="../controllers/LogoutController.php">Log out</a>
    </div>

    <div class="content">
        <div class="topbar">

            <h2>Add Medical History</h2>

            <?php if (!empty($_SESSION['error'])): ?>
            <div class="error-msg">
                <?= htmlspecialchars($_SESSION['error']); ?>
            </div>
            <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <?php if (!empty($_SESSION['success'])): ?>
            <div class="success-msg">
                <?= htmlspecialchars($_SESSION['success']); ?>
            </div>
            <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

        </div>
        <form action="../controllers/MedicalHistoryController.php" method="POST">

            <label>Visit Date:</label>
            <input type="date" name="visit_date" required><br>

            <label>Diagnosis:</label>
            <textarea name="diagnosis" required></textarea><br>

            <label>Treatment:</label>
            <textarea name="treatment" required></textarea><br>

            <label>Prescription:</label>
            <textarea name="prescription"></textarea><br>

            <label>Lab Results:</label>
            <textarea name="lab_results"></textarea><br>

            <label>Doctor Notes:</label>
            <textarea name="doctor_notes"></textarea><br>

            <button type="submit" name="add_history">Submit</button>
        </form>


    </div>

</body>

</html>