<?php include('../controllers/EditHistoryController.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Medical History</title>
    <link rel="stylesheet" href="../assets/css/addHistory.css">
</head>
<body>
    
</body>
</html>


<?php
include('../controllers/DashboardController.php');
include('../controllers/EditHistoryController.php'); 
require_once '../models/User.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard | <?= $roleName[$usertype] ?? 'User'; ?></title>
    <link rel="stylesheet" href="../assets/css/patientDash.css">
    <script src="../assets/js/patientDash.js"></script>
</head>

<body>

    <div class="sidebar">
        <img src="../assets/images/patient.jpg" alt="User Avatar">
        <h3><?= ucfirst(explode('@', $username)[0]); ?></h3>
        <p>
        <h1><?= isset($roleName[$usertype]) ? '<b><i>' . $roleName[$usertype] . '</i></b>' : 'User'; ?></h1>
        </p>


        <a class="active" href="#">Home</a>
        <a href="../views/doctorList.php">Doctor List</a>
        <a href="../views/patientAdForm.php">Patient Appointment </a>
        <a href="views/addhistory.php?pid=<?= urlencode($pid) ?>">Add Medical History </a>
        <a href="views/viewhistory.php?pid=<?= urlencode($pid) ?>">View Medical History </a>
        <a href="../controllers/LogoutController.php">Log out</a>
    </div>

    <div class="content">
        <div class="topbar">
         
        </div>

       <div class="form-container">
        

        <?php if ($history): ?>
        <form action="../controllers/EditHistoryController.php" method="POST">
            <h2>Edit Medical History</h2>
            <input type="hidden" name="id" value="<?= htmlspecialchars($history['id']) ?>">

            <label>Visit Date:</label>
            <input type="date" name="visit_date" value="<?= htmlspecialchars($history['visit_date']) ?>" required><br>

            <label>Diagnosis:</label>
            <textarea name="diagnosis" required><?= htmlspecialchars($history['diagnosis']) ?></textarea><br>

            <label>Treatment:</label>
            <textarea name="treatment" required><?= htmlspecialchars($history['treatment']) ?></textarea><br>

            <label>Prescription:</label>
            <textarea name="prescription"><?= htmlspecialchars($history['prescription']) ?></textarea><br>

            <label>Lab Results:</label>
            <textarea name="lab_results"><?= htmlspecialchars($history['lab_results']) ?></textarea><br>

            <label>Doctor Notes:</label>
            <textarea name="doctor_notes"><?= htmlspecialchars($history['doctor_notes']) ?></textarea><br>

            <button type="submit" name="update_history">Update</button>
        </form>
        <?php else: ?>
            <p>Record not found or invalid ID.</p>
        <?php endif; ?>
    </div>
    </div>

</body>

</html>