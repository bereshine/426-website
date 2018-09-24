<?php
class Activity{
    private $id;
    private $holder;
    private $time;
    private $start_time;
    private $end_time;
    private $description;
    private $participant;

    public static function connect(){
        return new mysqli( "classroom.cs.unc.edu",
        "zengao",
        "zengao",
        "zengaodb"
        );
    }

    public function __construct($activity_id){
        $mysqli = Activity::connect();
        $this->id = $activity_id;
        $result = $mysqli->query(
            "select Activity.holder, Activity.start_time, Activity.end_time, Activity.time, Activity.description
            from Activity where Activity.id = ".intval($activity_id)
        );
        if($result){
            $result_row = $result->fetch_array();
            $holder_id = $result_row['holder'];
            $holder_table = $mysqli->query(
                "select User.name from User where User.id = ".intval($holder_id)
            );
            $holder_row = $holder_table->fetch_array();
            $this->holder = $holder_row['name'];
            $this->time = $result_row['time'];
            $this->start_time = $result_row['start_time'];
            $this->end_time = $result_row['end_time'];
            $this->description = $result_row['description'];
            $this->participant = array();
            $participant_id_array = array();
            $participant_table = $mysqli->query(
                "select Participant.user from Participant where Participant.activity = ".intval($activity_id)
            );
            if($participant_table){
                while($next_row = $participant_table->fetch_array()){
                    $participant_id_array[] = $next_row['user'];
                }
                foreach($participant_id_array as $participant_id){
                $name_table = $mysqli->query("
                    select User.name from User where User.id = ".intval($participant_id)
                    );
                    while($next_row = $name_table->fetch_array()){
                        $this->participant[] = $next_row['name'];
                    }
            }
            }
        }
        else{
            return null;
        }
    }

    public function get_array(){
        $result_array = array(
            'id'=>$this->id,
            'holder'=>$this->holder,
            'time'=>$this->time,
            'start_time'=>$this->start_time,
            'end_time'=>$this->end_time,
            'description'=>$this->description,
            'participant'=>$this->participant
        );
        return $result_array;
    }
}