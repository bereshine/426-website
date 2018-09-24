<?php
class User{
    private $name;
    private $status;
    private $friends;
    private $activities;

    public static function connect(){
        return new mysqli( "classroom.cs.unc.edu",
        "zengao",
        "zengao",
        "zengaodb"
        );
    }

    public static function add_new_user($user_name,$password){
        $mysqli = User::connect();
        $default_status = "This guy is too lazy to write his status";
        $result = $mysqli->query(
            "insert into User (name, password, status) values('".$mysqli->real_escape_string($user_name)."','"
            .$mysqli->real_escape_string($password)."', '".$mysqli->real_escape_string($default_status)."')"
        );
        if($result){
            return true;
        }
        else{
            return false;
        }
    }

    public static function is_exist($user_name){
        $mysqli = User::connect();
        $result = $mysqli->query(
            "select User.id from User where User.name = '".$mysqli->real_escape_string($user_name)."'"
        );
        $result_row = $result->fetch_array();
        $id = $result_row['id'];
        if($id == null){
            return false;
        }
        else{
            return true;
        }
    }

    public function __construct($user_name){
        $mysqli = User::connect();
        //Find User.id via user_name, and add status
        $result = $mysqli->query(
            "select User.status, User.id from User where User.name = '".$mysqli->real_escape_string($user_name)."'"
        );
        if($result){
            $this->name = $user_name;
            $tmp = $result->fetch_array();
            $this->status = $tmp['status'];
            $id = $tmp['id'];
            //use User.id to construct friend object
            $this->friends = array();
            $friends_table = $mysqli->query(
            "select Friend.other from Friend where Friend.self =".intval($id)
            );
            if($friends_table){
                while($next_row = $friends_table->fetch_array()){
                    $new_friend = new Person($next_row['other']);
                    $this->friends[] = $new_friend->get_array();
                }
            }
            //construct activities array
            $this->activities = array();
            $activity_id_array = array();
            //continued
            $activity_table = $mysqli->query(
                "select Activity.id from Activity where Activity.holder =".intval($id)
            );
            if($activity_table){
                while($next_row = $activity_table->fetch_array()){
                    $new_activity = new Activity($next_row['id']);
                    $this->activities[] = $new_activity->get_array();
                }
            }
        }
        else{
            return null;
        }
    }

    public function get_json(){
        $result_array = array(
            'name'=> $this->name,
            'status'=>$this->status,
            'friends'=>$this->friends,
            'activities'=>$this->activities
        );
        return json_encode($result_array);
    }

}