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

}
