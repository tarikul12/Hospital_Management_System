<?php
// models/User.php
require_once '../config/connection.php'; // DB connection

class User {
    private $db;

    public function __construct() {
        global $database;
        $this->db = $database;
    }

    

    public function getUserNameByEmail($email, $usertype) {
    $table = $fieldEmail = $fieldName = '';
    
    switch ($usertype) {
        case 'p':
            $table = 'patient';
            $fieldEmail = 'pemail';
            $fieldName = 'pname';
            break;
        case 'a':
            $table = 'admin';
            $fieldEmail = 'aemail';
            $fieldName = 'aname';
            break;
        case 'd':
            $table = 'doctor';
            $fieldEmail = 'docemail';
            $fieldName = 'docname';
            break;
        default:
            return '';
    }
    
    $stmt = $this->db->prepare("SELECT $fieldName FROM $table WHERE $fieldEmail = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();
    
    if ($res->num_rows === 1) {
        return $res->fetch_assoc()[$fieldName];
    }
    
    return '';
}

   // models/User.php
public function findUserType($email) {
    // Check all possible tables for the email
    $tables = [
        'a' => ['table' => 'admin', 'field' => 'aemail'],
        'd' => ['table' => 'doctor', 'field' => 'docemail'],
        'p' => ['table' => 'patient', 'field' => 'pemail']
    ];
    
    foreach ($tables as $usertype => $info) {
        $stmt = $this->db->prepare("SELECT 1 FROM {$info['table']} WHERE {$info['field']} = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            return $usertype;
        }
    }
    
    return false;
}

public function validateCredentials($email, $password, $usertype) {
    $tableInfo = [
        'p' => ['table' => 'patient', 'email' => 'pemail', 'pass' => 'ppassword', 'name' => 'pname', 'id' => 'pid'],
        'a' => ['table' => 'admin', 'email' => 'aemail', 'pass' => 'apassword', 'name' => 'aname', 'id' => 'aid'],
        'd' => ['table' => 'doctor', 'email' => 'docemail', 'pass' => 'docpassword', 'name' => 'docname', 'id' => 'docid']
    ];
    
    $info = $tableInfo[$usertype];
    $query = "SELECT {$info['id']} as id, {$info['name']} as name, {$info['pass']} as pass 
              FROM {$info['table']} 
              WHERE {$info['email']} = ?";
    
    $stmt = $this->db->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['pass'])) {
            return [
                'id' => $row['id'],
                'name' => $row['name']
            ];
        }
    }
    
    return false;
}
    public function checkEmailExists($email) {
        $stmt = $this->db->prepare("SELECT * FROM webuser WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function createUser($fullname, $email, $password, $usertype) {
        $this->db->begin_transaction();

        try {
            $stmt1 = $this->db->prepare("INSERT INTO webuser (email, usertype) VALUES (?, ?)");
            $stmt1->bind_param("ss", $email, $usertype);
            $stmt1->execute();

            if ($usertype === 'p') {
                $stmt2 = $this->db->prepare("INSERT INTO patient (pemail, pname, ppassword) VALUES (?, ?, ?)");
            } elseif ($usertype === 'a') {
                $stmt2 = $this->db->prepare("INSERT INTO admin (aemail, aname, apassword) VALUES (?, ?, ?)");
            } elseif ($usertype === 'd') {
                $stmt2 = $this->db->prepare("INSERT INTO doctor (docemail, docname, docpassword) VALUES (?, ?, ?)");
            } else {
                throw new Exception("Invalid usertype.");
            }

            $stmt2->bind_param("sss", $email, $fullname, $password);
            $stmt2->execute();

            $this->db->commit();
            return true;

        } catch (Exception $e) {
            $this->db->rollback();
            return false;
        }
    }


    public function createPatientAdmission($data) {
        $query = "INSERT INTO patient_admissions (fullname, pid, doctor_name, department, age, gender, phone) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param(
            "sississ",
            $data['fullname'],
            $data['pid'],
            $data['doctor_name'],
            $data['department'],
            $data['age'],
            $data['gender'],
            $data['phone']
        );

        return $stmt->execute();
    }

    public function getAllAdmissions() {
    $query = "SELECT * FROM patient_admissions ORDER BY id DESC";
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}


    public function updatePatientAdmission($id, $data) {
        $query = "UPDATE patient_admissions SET fullname=?, pid=?, doctor_name=?, department=?, age=?, gender=?, phone=? 
                  WHERE id=?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param(
            "sississi",
            $data['fullname'],
            $data['pid'],
            $data['doctor_name'],
            $data['department'],
            $data['age'],
            $data['gender'],
            $data['phone'],
            $id
        );

        return $stmt->execute();
    }

    public function addPatientAdmission($fullname, $pid, $doctor_name, $department, $age, $gender, $phone) {
    $stmt = $this->db->prepare("INSERT INTO patient_admissions (fullname, pid, doctor_name, department, age, gender, phone) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssiss", $fullname, $pid, $doctor_name, $department, $age, $gender, $phone);
    return $stmt->execute();
}

public function searchPatientAdmissions($keyword) {
    $like = "%" . $keyword . "%";
    $stmt = $this->db->prepare("SELECT * FROM patient_admissions WHERE fullname LIKE ? OR pid LIKE ? ORDER BY id DESC");
    $stmt->bind_param("ss", $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

public function getAdmissionById($id) {
    $query = "SELECT * FROM patient_admissions WHERE id = ?";
    $stmt = $this->db->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}


public function addMedicalHistory($data) {
    $query = "INSERT INTO medical_history (visit_date, diagnosis, treatment, prescription, lab_results, doctor_notes, added_by) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $this->db->prepare($query);

    if (!$stmt) {
        error_log("Prepare failed: " . $this->db->error);
        return false;
    }

    $stmt->bind_param(
        "sssssss",
        $data['visit_date'],
        $data['diagnosis'],
        $data['treatment'],
        $data['prescription'],
        $data['lab_results'],
        $data['doctor_notes'],
        $data['added_by']
    );

    return $stmt->execute();
}


// Get all medical history records ordered by id desc
public function getMedicalHistory($id = null) {
    if ($id === null) {
        $query = "SELECT * FROM medical_history ORDER BY id DESC";
        $stmt = $this->db->prepare($query);
    } else {
        $query = "SELECT * FROM medical_history WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
    }

    if (!$stmt) {
        error_log("Prepare failed: " . $this->db->error);
        return [];
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        error_log("Get result failed: " . $stmt->error);
        return [];
    }

    return ($id === null) ? $result->fetch_all(MYSQLI_ASSOC) : $result->fetch_assoc();
}


public function updateMedicalHistory($data) {
    $query = "UPDATE medical_history SET 
                visit_date = ?, diagnosis = ?, treatment = ?, 
                prescription = ?, lab_results = ?, doctor_notes = ? 
              WHERE id = ?";
    $stmt = $this->db->prepare($query);
    if (!$stmt) {
        error_log("Update failed: " . $this->db->error);
        return false;
    }

    $stmt->bind_param(
        "ssssssi",
        $data['visit_date'],
        $data['diagnosis'],
        $data['treatment'],
        $data['prescription'],
        $data['lab_results'],
        $data['doctor_notes'],
        $data['id']
    );

    return $stmt->execute();
}


public function deleteMedicalHistory($id) {
    $query = "DELETE FROM medical_history WHERE id = ?";
    $stmt = $this->db->prepare($query);
    if (!$stmt) {
        error_log("Delete failed: " . $this->db->error);
        return false;
    }

    $stmt->bind_param("i", $id);
    return $stmt->execute();
}



// View history by HID


}

    






    

      