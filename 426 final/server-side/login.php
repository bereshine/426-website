<?php
session_start();
require_once('orm/Activity.php');
require_once('orm/Message.php');
require_once('orm/Person.php');
require_once('orm/User.php');

function check_password($username, $password) {
    $mysqli = new mysqli( "classroom.cs.unc.edu",
        "zengao",
        "zengao",
        "zengaodb"
        );
    $user_exist_table = $mysqli->query(
        "select User.id from User where User.name= '".$mysqli->real_escape_string($username)."'"
    );
    $pass_word_correct_table = $mysqli->query(
        "select User.id from User where User.name= '".$mysqli->real_escape_string($username).
        "' and User.password = '".$mysqli->real_escape_string($password)."'"
    );
    $user_exist = $user_exist_table->fetch_array();
    $pass_word_correct = $pass_word_correct_table->fetch_array();
    if($user_exist['id']==null){
        return "user_not_exist";
    }
    elseif($pass_word_correct['id']==null){
        return "pass_word_incorrect";
    }
    else{
        return "true";
    }
}

$username = $_GET['name'];
$password = $_GET['password'];
$check_result = check_password($username, $password);
if ($check_result == "true") {
  header('Content-type: application/json');
  // Generate authorization cookie
  $_SESSION['username'] = $username;
  setcookie('hub');
  $user = new User($username);
  header("Content-type: application/json");
  print($user->get_json());
  exit();

} elseif($check_result=="user_not_exist"){
  header('Content-type: application/json');
  print(json_encode(array("result"=>"user_not_exist")));
  exit();
}else{
    header('Content-type: application/json');
    print(json_encode(array("result"=>"password_incorrect")));
    exit();
}