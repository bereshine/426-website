<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
    session_start();

    require_once('authenticate.php');

    require_once('orm/Activity.php');
    require_once('orm/Message.php');
    require_once('orm/Person.php');
    require_once('orm/User.php');

    if(isset($_SERVER['PATH_INFO'])){
        $path_components = explode('/',$_SERVER['PATH_INFO']);
    }
    else{
        $path_components = NULL;
    }

    if($_SERVER['REQUEST_METHOD']=="GET"){
        if((count($path_components)==2)&&($path_components[1]!="")){
            $user_name = trim($_GET['name']);
            $user = new User($user_name);
            if($user == null){
                header("HTTP/1.0 404 NOT FOUND");
                print("User: ".$user_name." Not Found");
                exit();
            }
            else{
                header("Content-type: application/json");
                print($user->get_json());
                exit();
            }
        }
    }
    elseif($_SERVER['REQUEST_METHOD']=="POST"){
        if((count($path_components)==2)&&($path_components[1]!="")&&isset($_REQUEST['password'])){
            $user_name = $_REQUEST['name'];
            $password = $_REQUEST['password'];
            if(User::is_exist($user_name)){
                header("HTTP/1.0 401 USER NAME ALREADY EXISTS");
                print(json_encode(false));
                exit();
            }
            else{
                $result = User::add_new_user($user_name, $password);
                if($result){
                    header("Content-type: application/json");
                    print(json_encode(true));
                    exit();
                }
                else{
                    header("HTTP/1.0 401 INTERNAL ERROR");
                    print(json_encode(false));
                    exit();
                }
            }
        }
    }
    else{
        header("HTTP/1.0 400 USER NAME ALREADY EXISTS");
        print("CANNOT UNDERSTAND THE REQUEST");
    }
?>