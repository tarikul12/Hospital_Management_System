<?php
include('../controllers/patientEditControllers.php');
require_once '../models/User.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Admission | <?= $roleName[$usertype] ?? 'User'; ?></title>
    <link rel="stylesheet" href="../assets/css/patientEdit.css">

</head>

<body>

    <div class="sidebar">
        <img src="../assets/images/patient.jpg" alt="User Avatar">
        <h3><?= ucfirst(explode('@', $username)[0]); ?></h3>
        <p>
        <h1><?= isset($roleName[$usertype]) ? '<b><i>' . $roleName[$usertype] . '</i></b>' : 'User'; ?></h1>
        </p>


        <a class="active" href="#">Home</a>
        <a href="#">Doctor Profile</a>
        <a href="../views/patientAdForm.php">Patient Appointment Form</a>
        <a href="../views/addHistory.php">Add Medical History </a>
        <a href="../views/viewHistory.php">View Medical History </a>
        <a href="../controllers/LogoutController.php">Log out</a>
    </div>

    <div class="content">
        <div class="topbar">
            <button onclick="history.back()" class="btn">← Back</button>
            <form class="search-box" action="" method="GET">
                <input type="text" name="search" placeholder="Search by Full Name or Patient ID"
                    value="<?= htmlspecialchars($search) ?>">
                <button class="btn btn-view">Search</button>
            </form>
            <strong><?= date("Y-m-d"); ?></strong>
        </div>

        <div class="main">
            <div class="form-container">
                <h2>Edit Patient Admission</h2>
                <form action="../controllers/PatientAdmissionController.php" method="POST">
                    <input type="hidden" name="id" value="<?= $admission['id'] ?>">

                    <label>Full Name:</label>
                    <input type="text" name="fullname" value="<?= htmlspecialchars($admission['fullname']) ?>" required>

                    <label>Patient ID:</label>
                    <input type="text" name="pid" value="<?= htmlspecialchars($admission['pid']) ?>" required>

                    <label>Doctor Name:</label>
                    <input type="text" name="doctor_name" value="<?= htmlspecialchars($admission['doctor_name']) ?>"
                        required>

                    <label>Department:</label>
                    <input type="text" name="department" value="<?= htmlspecialchars($admission['department']) ?>"
                        required>

                    <label>Age:</label>
                    <input type="number" name="age" value="<?= htmlspecialchars($admission['age']) ?>" required>

                    <label>Gender:</label>
                    <select name="gender" required>
                        <option value="Male" <?= $admission['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?= $admission['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
                    </select>

                    <label>Phone:</label>
                    <input type="text" name="phone" value="<?= htmlspecialchars($admission['phone']) ?>" required>

                    <button type="submit" name="update_admission" class="btn btn-submit">Update Admission</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>