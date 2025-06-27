<?php
require_once '../models/Doctor.php';
require_once '../controllers/DoctorController.php';
include('../controllers/DashboardController.php');
require_once '../models/User.php';

$controller = new DoctorController();
$doctors = $controller->getDoctors();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Doctors Team</title>
    <link rel="stylesheet" href="../assets/css/patientDash.css">
    <link rel="stylesheet" href="../assets/css/doctorList.css">
    <script src="../assets/js/doctorList.js"></script>
</head>

<body>

    <div class="sidebar">
        <img src="../assets/images/patient.jpg" alt="User Avatar">
        <h3><?= ucfirst(explode('@', $username)[0]); ?></h3>
        <p>
        <h1><?= isset($roleName[$usertype]) ? '<b><i>' . $roleName[$usertype] . '</i></b>' : 'User'; ?></h1>
        </p>


        <a href="../patient/dashboard.php">Home</a>
        <a class="active" href="../views/doctorList.php">Doctor List</a>
        <a href="../views/patientAdForm.php">Patient Appointment </a>
        <a href="../views/addHistory.php">Add Medical History </a>
        <a href="../views/viewHistory.php">View Medical History </a>
        <a href="../controllers/LogoutController.php">Log out</a>
    </div>

    <div class="content">

        <h2 class="title">Our Dedicated Doctors Team</h2>
        <div class="filter-bar">
            <select id="departmentFilter">
                <option value="All">All Department</option>
                <option>Cardiology</option>
                <option>Neurology</option>
                <option>Orthopedics</option>
                <option>Ophthalmology</option>
                <option>Nephrology</option>
            </select>
            <input type="text" id="searchInput" placeholder="Search your consultant">
            <button onclick="filterDoctors()">Search</button>
        </div>


        <div class="doctor-grid">
            <?php foreach ($doctors as $doc): ?>
            <div class="card" data-department="<?= strtolower($doc['department']) ?>">
                <img src="../assets/images/<?= $doc['image'] ?>" alt="<?= $doc['name'] ?>">
                <h4><?= $doc['name'] ?></h4>
                <p><?= $doc['title'] ?></p>
                <small><b><?= $doc['department'] ?></b></small>
                <div class="buttons">
                    <a href="../views/patientAdForm.php" class="btn">Appointment</a>
                    <button class="btn">Profile</button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>


</body>

</html>