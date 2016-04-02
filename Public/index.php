<?php

session_start();
//showing errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//connecting to the database

$server = "localhost";
$username = "root";
$password = "123456";
$db = "exam";

try {
    $conn = new PDO("mysql:host=$server;dbname=$db", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}
catch (PDOException $e) {
    die($e->getMessage());
}

include "../App/Models/model.php";
include "../App/Models/user.php";
include "../App/Services/Authentication.php";

$auth= new Authenticator($conn);
$user=new User($conn);


//find out the URI that is stored in $_SERVER['REQUEST-URI'] by the web server ( here in our exam the web server is php internal server)


$data = explode('/', $_SERVER['REQUEST_URI']);
$action=$data[1];

$pos = strpos($action, '?');
if ($pos){
$action = substr($action, 0, $pos);
}
;

switch ($action) {
    case '':
            header('Location: http://localhost:8080/admin-login');
        break;

    case 'admin-login':

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            include "../App/Views/admin-login.php";
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $res = $auth->login($_POST['userName'], $_POST['password']);
            if ($res) {
                echo "You are logged in successfully";
                header('Location: http://localhost:8080/show-user');
            } else {
                echo "Username or password is incorrect";
            }
        }

        break;

    case 'admin-logout':
        $auth->logout();
        break;


    case 'admin-register':
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            include "../App/Views/admin-register.php";
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $auth->register($_POST);
            $auth->login($_POST['userName'], $_POST['password']);
            header('Location: http://localhost:8080/show-user');
        }


        break;

    case 'add-user':
        if (isset($_SESSION['user_session'])) {
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                include "../App/Views/add-user.php";
            } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
                try {
                    $user->register($_POST);
                    header('Location: http://localhost:8080/show-user');
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            }
        }
        else {
            header('Location: http://localhost:8080/');
        }
        break;

    case 'show-user':

        if (isset($_SESSION['user_session'])) {
            $users = (new User($conn))->getData(10, !empty($_GET['page']) ? $_GET['page'] : 1);
            $pages_count = (new User($conn))->total()/10;
            include "../App/Views/show-user.php";
        }
        else {
            header('Location: http://localhost:8080/');
        }

    break;

    case 'update-user':
        if (isset($_SESSION['user_session'])) {
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                $stmt = $conn->prepare("SELECT * FROM users WHERE id=:id LIMIT 1");
                $stmt->execute(array(':id' => $data[2]));

                if ($stmt->rowCount() > 0) {
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    include "../App/Views/update-user.php";
                } else {
                    die("entity does'nt exist");
                }
            } else {
                $id = $data[2];
                $user->update($id, $_POST);
                header('Location: http://localhost:8080/show-user');
            }
        }
        else {
            header('Location: http://localhost:8080/');
        }
        break;


    case 'delete-user':
        if (isset($_SESSION['user_session'])) {
            $id = $data[2];
            $user->delete($id);
            header('Location: http://localhost:8080/show-user');

            break;

        }
        else {
            header('Location: http://localhost:8080/');
        }
}
