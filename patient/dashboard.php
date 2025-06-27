<?php
include('../controllers/DashboardController.php');
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
            <button onclick="history.back()" class="btn">← Back</button>
            <form class="search-box" action="" method="GET">
                <input type="text" name="search" placeholder="Search by Full Name or Patient ID"
                    value="<?= htmlspecialchars($search) ?>">
                <button class="btn btn-view">Search</button>
            </form>
            <strong><?= date("Y-m-d"); ?></strong>
        </div>

        <div class="main">
            <h2>All Patients (<?= count($patient_admissions) ?>)</h2>
            <table class="doctor-table">
                <thead>
                    <tr>
                        <th>Patient ID</th>
                        <th>Full Name</th>
                        <th>Doctor Name</th>
                        <th>Department</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($patient_admissions)): ?>
                    <?php foreach ($patient_admissions as $admission): ?>
                    <tr>
                        <td><?= htmlspecialchars($admission['pid'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($admission['fullname'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($admission['doctor_name'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($admission['department'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($admission['age'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($admission['gender'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($admission['phone'] ?? 'N/A') ?></td>
                        <td>
                            <a class="btn btn-view" href="view.php?id=<?= $admission['id'] ?>">👁 View</a>
                            <a class="btn btn-sessions" href="../views/edit.php?id=<?= $admission['id'] ?>">📝 Edit</a>

                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">No admissions found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>