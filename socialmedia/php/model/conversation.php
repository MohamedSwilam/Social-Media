<?php
require_once 'database.php';
require_once 'crud.php';

class conversation extends database implements crud{
    //private $convID;
    private $side1;
    private $side2;
    private $time;
    
    public function create(array $data) {
        //side1,side2
        $this->side1=$data[0];
        $this->side2=$data[1];
        $this->time=time();
        
        $sql="INSERT INTO `conversation`(`side1`, `side2`,`time`) VALUES ('$this->side1','$this->side2','$this->time')";
        $result = $this->booleanQuery($sql);
        return $result;
    }

    public function delete(array $data) {
        
    }

    public function read($id) {
        $sql="SELECT * FROM `conversation` WHERE `side1`='$id' OR `side2`='$id' ORDER BY `time` DESC";
        $result = $this->dataQuery($sql);
        return $result;
    }
    
    public function read_sides($id) {
        $sql="SELECT * FROM `conversation` WHERE `id`='$id'";
        $result = $this->dataQuery($sql);
        return $result;
    }
    
    public function get_convID($side1,$side2) {
        $sql="SELECT * FROM `conversation` WHERE `side1`='$side1' AND `side2`='$side2'";
        $result = $this->dataQuery($sql);
        return $result;
    }

    public function update(array $data) {
        
    }
    
    public function check($side1,$side2){
        $sql="SELECT * FROM `conversation` WHERE (`side1`='$side1' AND `side2`='$side2') OR (`side1`='$side2' AND `side2`='$side1')";
        $result = $this->dataQuery($sql);
        if (!empty($result)){
            foreach ($result as $value) {
                $id=$value['id'];
                return $id;
            }
        }
        return "no";
    }
}
