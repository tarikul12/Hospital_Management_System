<?php
require_once '../models/Doctor.php';

class DoctorController {
    public function getDoctors() {
        return Doctor::getAllDoctors();
    }
}
