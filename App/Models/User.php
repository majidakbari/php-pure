<?php
namespace App\Models;

use Exception;
use PDO;

class User extends Model
{


    public function update($id, array $data)
    {


        $sql = "UPDATE `users` SET `name` = :name, `email`= :email , `website`=:website , `gender`=:gender WHERE `id` = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':website', $data['website']);
        $stmt->bindParam(':gender', $data['gender']);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

    }

    public function delete($id)

    {

        $sql="DELETE FROM users WHERE id=:id";
        $stmt=$this->connection->prepare($sql);
        $stmt->bindParam(':id', $id);
        return ($stmt->execute());
    }


    public function register(array $data)
    {
        if ($this->does_Email_Exist($data['email']))
            throw new Exception('Email is already taken! please pick another one.');

        $stmt = $this->connection->prepare("INSERT INTO `users` (`name`,`email`,`website`,`gender`) VALUES (:name, :email , :website, :gender)");
        $stmt->execute([
            'name' => $data['name'],
            'email' => $data['email'],
            'website' => $data['website'],
            'gender' => $data['gender'],
        ]);
    }

    public function all()
    {

        $sth = $this->connection->prepare("SELECT `id`,`name`,`email`,`website`,`gender` FROM `users`");
        $sth->execute();

        return $sth->fetchAll();

    }


    public function getData($limit = 10, $page = 1)
    {

        $offset  = $limit * ($page - 1);

        $sth = $this->connection->prepare("SELECT `id`,`name`,`email`,`website`,`gender` FROM `users` LIMIT :offset, :limit");
        $sth->bindParam(':limit', $limit, PDO::PARAM_INT);
        $sth->bindParam(':offset', $offset, PDO::PARAM_INT);
        $sth->execute();

        $result = $sth->fetchAll();
        

        return $result;
    }

    public function total()
    {
        $total  = $this->connection->query("SELECT COUNT(id) as rows FROM `users`")
            ->fetch(PDO::FETCH_OBJ);

        $total_count  = $total->rows;

        return $total_count;
    }




    public function does_Email_Exist($email)
    {
        $stmt = $this->connection->prepare("SELECT * FROM `users` WHERE `email`=:email LIMIT 1");
        $stmt->execute(array(':email' => $email));

        if ($stmt->rowCount() > 0) {
            return true;
        }

        return false;
        
    }
}