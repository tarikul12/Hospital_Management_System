<?php
include('../controllers/patientAdFormController.php');
require_once '../models/User.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Patient Appointment </title>
    <link rel="stylesheet" href="../assets/css/patientAdd.css">

</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <img src="../assets/images/patient.jpg" alt="User Avatar">
        <h3><?= ucfirst(explode('@', $username)[0]); ?></h3>
        <p>
        <h1><?= isset($roleName[$usertype]) ? '<b><i>' . $roleName[$usertype] . '</i></b>' : 'User'; ?></h1>
        </p>

        <a href="../patient/dashboard.php">Home</a>
        <a href="../patient/dashboard.php">Doctor Profile</a>
        <a class="active" href="../views/patientAdForm.php">Patient Appointment </a>
        <a href="../views/addHistory.php">Add Medical History </a>
        <a href="../views/viewHistory.php">Show Medical History </a>
        <a href="../controllers/LogoutController.php">Log out</a>
    </div>

    <!-- Content Area -->
    <div class="content">
        <div class="topbar">
        </div>

        <div class="main">
            <div class="form-container">
                <h2>Patient Appointment </h2>

                <?php if ($msg): ?>
                <p class="success-msg"><?= htmlspecialchars($msg) ?></p>
                <?php endif; ?>

                <form action="../controllers/PatientAdController.php" method="POST">
                    <label for="fullname">Full Name:</label>
                    <input type="text" name="fullname" id="fullname" required>

                    <label for="pid">Patient ID:</label>
                    <input type="text" name="pid" id="pid" required>

                    <label for="doctor_name">Doctor Name:</label>
                    <input type="text" name="doctor_name" id="doctor_name" required>

                    <label for="department">Department:</label>
                    <input type="text" name="department" id="department" required>

                    <label for="age">Age:</label>
                    <input type="number" name="age" id="age" required>

                    <label for="gender">Gender:</label>
                    <select name="gender" id="gender" required>
                        <option value="">Select gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>

                    <label for="phone">Phone Number:</label>
                    <input type="text" name="phone" id="phone" required>

                    <input type="submit" value="Submit Admission">
                </form>
            </div>
        </div>
    </div>

</body>

</html>