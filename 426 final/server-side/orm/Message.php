<?php
class Message{
    private $from;
    private $to;
    private $content;
    private $time;

    public static function connect(){
        return new mysqli( "classroom.cs.unc.edu",
        "zengao",
        "zengao",
        "zengaodb"
        );
    }

    public function __construct($message_id){
        $mysqli = Message::connect();
        $result = $mysqli->query(
            "select Message.id, Message.from_user, Message.to_user, Message.content, Message.time from Message
            where Message.id = $message_id"
        );
        if($result){
            $result_row = $result->fetch_array();
            $this->from = $result_row['from_user'];
            $this->to = $result_row['to_user'];
            $this->content = $result_row['content'];
            $this->time = $result_row['time'];
        }
    }

    public function get_array(){
        $result_array = array(
            'from'=>$this->from,
            'to'=>$this->to,
            'content'=> $this->content,
            'time'=>$this->time
        );
        return $result_array();
    }
}