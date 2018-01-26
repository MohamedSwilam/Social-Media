<?php
    require_once 'database.php';
    require_once 'crud.php';

class actions extends database implements crud{
    
    private $userID;
    private $ownerID;
    private $postID;
    private $type;
    private $time;

    public function create(array $data){
        $this->userID=$data[0];// 2ly 3amal 2l action
        $this->ownerID=$data[1];// 2ly 2t3aml feh 2laction
        $this->postID=$data[2];
        $this->type=$data[3];
        $this->time=$data[4];
        
        $SQL="INSERT INTO `actions`(`userID`,`ownerID`,`postID`,`type`,`time`)VALUES ('$this->userID','$this->ownerID','$this->postID','$this->type','$this->time')";
        $result=$this->booleanQuery($SQL);
        return $result;
    }
    
    public function update(array $data){
        
    }
    
    public function read($id){
        $sql="SELECT A.* FROM actions A WHERE A.userID in (SELECT B.friendID FROM friends B WHERE B.userID = '$id' AND B.relation='f') ORDER BY `time` DESC";
        $result=$this->dataQuery($sql);
        return $result;
    }
    
    public function delete(array $data){
        //userID,postID,type
        $userID=$data[0];
        $postID=$data[1];
        $type=$data[2];
        $sql="DELETE FROM `actions` WHERE `userID`='$userID' AND `postID`='$postID' AND `type`='$type'";
        $result = $this->booleanQuery($sql);
        return $result;
    }
}
?>