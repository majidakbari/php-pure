<?php

namespace App\Models;

use PDO;

abstract class Model
{

    public function __construct(PDO $connection)
    {
        $this->connection=$connection;
    }
    
        public abstract function register(array $data);
        public abstract function update($id, array $data);
        public abstract function delete($id);
        public abstract function all();
        public abstract function does_Email_Exist($email);
    
}
