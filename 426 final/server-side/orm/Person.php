<?php
class Person{
    private $name;
    private $status;
    private $messages;

     public static function connect(){
        return new mysqli( "classroom.cs.unc.edu",
        "zengao",
        "zengao",
        "zengaodb"
        );
    }

    public function __construct($user_id){
        $mysqli = Person::connect();
        $name_status_table = $mysqli->query(
            "select User.name, User.status from User where User.id = $user_id"
        );
        $new_name_status = $name_status_table->fetch_array();
        $this->name = $new_name_status['name'];
        $this->status = $new_name_status['status'];
        $this->messages = array();
        $message_table = $mysqli->query(
            "select Message.id from Message where Message.from = $user_id or Message.to = $user_id"
        );
        if($message_table){
            while($next_row = $message_table->fetch_array()){
                $new_message = new Message($next_row['id']);
                $this->messages[] = $new_message->get_array();
            }
        }
    }

    public function get_array(){
        $result_array = array(
            'name' => $this->name,
            'status'=> $this->status,
            'messages'=>$this->messages
        );
        return $result_array;
    }
}