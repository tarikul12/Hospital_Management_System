<?php
session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['usertype'])) {
    header('Location: ../views/login.php');
    exit;
}

$usertype = $_SESSION['usertype'];
$username = $_SESSION['user'];

$roleName = [
    'a' => 'Admin',
    'd' => 'Doctor',
    'p' => 'Patient'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | <?php echo $roleName[$usertype] ?? 'User'; ?></title>
    <link rel="stylesheet" href="../assets/css/main.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; display: flex; }
        .sidebar {
            width: 220px; background: #f0f0f0; height: 100vh; padding: 20px;
            display: flex; flex-direction: column; align-items: center;
        }
        .sidebar h3, .sidebar p { margin: 10px 0; text-align: center; }
        .sidebar a {
            display: block; padding: 10px; margin: 10px 0;
            text-decoration: none; color: #000; width: 100%;
            border-radius: 6px;
        }
        .sidebar a:hover, .sidebar a.active {
            background: #007BFF; color: #fff;
        }
        .topbar {
            display: flex; justify-content: space-between; align-items: center;
            padding: 20px; background: #ffffff; border-bottom: 1px solid #ccc;
        }
        .content { flex: 1; display: flex; flex-direction: column; }
        .main { padding: 20px; }
        .doctor-table {
            width: 100%; border-collapse: collapse;
        }
        .doctor-table th, .doctor-table td {
            padding: 10px; border-bottom: 1px solid #ccc;
            text-align: left;
        }
        .btn {
            padding: 6px 12px;
            border: none; border-radius: 4px;
            cursor: pointer;
        }
        .btn-view { background: #dbeafe; color: #1d4ed8; }
        .btn-sessions { background: #bfdbfe; color: #1e40af; }
        .search-box {
            display: flex; gap: 10px; align-items: center;
        }
        .search-box input[type="text"] {
            padding: 6px; width: 200px;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <img src="../assets/image/admin.jpg" alt="User Avatar" style="width: 60px; height: 60px; border-radius: 50%;">
        <h3><?php echo ucfirst(explode('@', $username)[0]); ?></h3>
        <p>
<?php if ($usertype === 'a'): ?>
    <a href="admin/dashboard.php">Admin Dashboard</a> |
    <a href="admin/manage_patients.php">Manage Patients</a> |
    <a href="admin/manage_doctors.php">Manage Doctors</a>
    
<?php elseif ($usertype === 'd'): ?>
    <a href="doctor/dashboard.php">Doctor Dashboard</a> |
    <a href="doctor/appointments.php">My Appointments</a> |
    <a href="doctor/schedule.php">My Schedule</a>
    
<?php elseif ($usertype === 'p'): ?>
    <a href="patient/dashboard.php">Patient Dashboard</a> |
    <a href="patient/appointments.php">My Appointments</a> |
    <a href="patient/medical_records.php">Medical Records</a>
<?php endif; ?>
</p>
        <a class="active" href="#">Home</a>
        <a href="#">All Doctors</a>
        <a href="#">Scheduled Sessions</a>
        <a href="#">My Bookings</a>
        <a href="#">Settings</a>
        <a href="../controllers/LogoutController.php">Log out</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="topbar">
            <button onclick="history.back()" class="btn">← Back</button>
            <div class="search-box">
                <input type="text" placeholder="Search Doctor name or Email">
                <button class="btn btn-view">Search</button>
            </div>
            <div>
                <strong>Today's Date</strong><br>
                <?php echo date("Y-m-d"); ?>
            </div>
        </div>

        <div class="main">
            <h2>All Doctors (1)</h2>
            <table class="doctor-table">
                <thead>
                    <tr>
                        <th>Doctor Name</th>
                        <th>Email</th>
                        <th>Specialties</th>
                        <th>Events</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Test Doctor</td>
                        <td>doctor@edoc.com</td>
                        <td>Accident and emergency</td>
                        <td>
                            <button class="btn btn-view">👁 View</button>
                            <button class="btn btn-sessions">🔁 Sessions</button>
                        </td>
                    </tr>
                    <!-- Add more rows dynamically -->
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
