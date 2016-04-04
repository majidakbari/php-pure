<?php


use App\Models\User;
use App\Services\Authenticator;
use App\Services\URL;
use App\Services\Escape;


//Auto load using composer.json

require __DIR__.'/../vendor/autoload.php';



//For admin login we should start the session
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

    try 
    {
    $conn = new PDO("mysql:host=$server;dbname=$db", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }
    catch (PDOException $e)
    {
        die($e->getMessage());
    }


$router = new URL(include '../Routes.php');
$auth= new Authenticator($conn);
$user=new User($conn);
$escape=new Escape();

//find out the URI that is stored in $_SERVER['REQUEST-URI'] by the web server ( here in our exam the web server is php internal server)

$data = explode('/', $_SERVER['REQUEST_URI']);
$action=$data[1];
//for pagination we need this
$pos = strpos($action, '?');
if ($pos){
$action = substr($action, 0, $pos);
}


switch ($action) {
    
    case '':
        $router->redirect('admin-login');
        break;

    case 'admin-login':

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            include "../App/Views/admin-login.php";
        } 
        elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $res = $auth->login($_POST['userName'], $_POST['password']);
            if ($res) {

                $router->redirect('show-user');
            } 
            else {
                echo "Username or password is incorrect";
            }
        }

        break;

    case 'admin-logout':
        $auth->logout();
        $router->redirect('admin-login');
        break;


    case 'admin-register':
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            include "../App/Views/admin-register.php";
        } 
        elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $auth->admin_register($_POST);
            $auth->login($_POST['userName'], $_POST['password']);
            $router->redirect('show-user');
        }
        break;

    case 'add-user':
        if (isset($_SESSION['user_session'])) {
            
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                include "../App/Views/add-user.php";
            }
            elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_POST['csrf']) && $_POST['csrf'] == $_SESSION['token']) {
                    $validated_name = htmlentities($_POST['name'], ENT_QUOTES, "UTF-8");
                    $_POST['name'] = $validated_name;
                        $user->add_user($_POST);
                        $router->redirect('show-user');
                    } 

                }
                else
                {
                    die('invalid data');
                }
            }
            else
            {
                $router->redirect('home');
            }

        break;

    case 'show-user':

        if (isset($_SESSION['user_session'])) {
            $users = (new User($conn))->getData(10, !empty($_GET['page']) ? $_GET['page'] : 1);
            $pages_count = (new User($conn))->total()/10;
            include "../App/Views/show-user.php";
        }
        else {
            $router->redirect('home');
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
                } 
                else {
                    die("entity does'nt exist");
                }
            }
            else {
                $id = $data[2];
                $user->update($id, $_POST);
                $router->redirect('show-user');
            }
        }
        else {
            $router->redirect('home');
        }
        break;


    case 'delete-user':
        if (isset($_SESSION['user_session'])) {
            $id = $data[2];
            $user->delete($id);
            $router->redirect('show-user');

            break;
        }
        else {
            $router->redirect('home');
        }
    case 'user-exist':
        echo $user->does_Email_Exist($_GET['email']);
}
