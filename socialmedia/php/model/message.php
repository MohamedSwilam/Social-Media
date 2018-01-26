<?php
require_once 'database.php';
require_once 'crud.php';

class message extends database implements crud{
    private $conv_id;
    private $sender;
    private $receiver;
    private $content;
    private $date;
    private $time;


    public function create(array $data) {
        $this->conv_id=$data[0];
        $this->sender=$data[1];
        $this->receiver=$data[2];
        $this->content=$data[3];
        $this->date=date("d-m-y h:i:s a");
        $this->time= time();
        $sql="INSERT INTO `message`(`conv_id`, `sender`, `receiver`, `content`, `date`, `time`) VALUES ('$this->conv_id','$this->sender','$this->receiver','$this->content','$this->date','$this->time')";
        $result = $this->booleanQuery($sql);
        if($result==1){
            $sql="UPDATE `conversation` SET `time`='$this->time' WHERE `id`='$this->conv_id'";
            $result = $this->booleanQuery($sql);
        }
        return $result;
    }

    public function delete(array $data) {
        
    }

    public function read($id) {
        $sql="SELECT * FROM `message` WHERE `conv_id`='$id'";
        $result = $this->dataQuery($sql);
        return $result;
    }
    
    public function update(array $data) {
        //convID,userID
        $sql="UPDATE `message` SET `seen`='yes' WHERE `conv_id`='$data[0]' AND `receiver`='$data[1]'";
        $result=  $this->booleanQuery($sql);
        return $result;
    }
    
    public function read_last_msg($conv_id) {
        $sql="SELECT * FROM `message` WHERE `time`=(SELECT MAX(time) FROM `message` WHERE `conv_id`='$conv_id')";
        $result = $this->booleanQuery($sql);
        return $result;
    }

}
