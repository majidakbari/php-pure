<?php

namespace App\Services;

use PDO;

class Authenticator
{

    protected $db;

    public function __construct(PDO $DB_con)
    {
        $this->db = $DB_con;
    }

    public function login($identifier, $password)
    {
        $stmt = $this->db->prepare("SELECT * FROM admins WHERE userName=:uname LIMIT 1");
        $stmt->execute(array(':uname' => $identifier));
        $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($stmt->rowCount() > 0) {
            if (password_verify($password, $userRow['password'])) {

                $_SESSION['user_session'] = $userRow;
                return true;

            } else {
                return false;
            }
        }
    }


    public function admin_register(array $params)
    {
        $stmt = $this->db->prepare("INSERT INTO admins (userName,password) VALUES (:uname,:password)");
        $stmt->execute(array(':uname'=>$params['userName'], ':password'=>password_hash($params['password'],PASSWORD_BCRYPT)));
    }
    
    public function logout()
    {
        session_destroy();
        
    }
}