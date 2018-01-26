<?php
require_once 'database.php';
require_once 'crud.php';

class friend extends database implements crud{
    private $userID;
    private $friendID;
   
    public function create(array $data) {
        //$userID, $friendID, $parameter3, $parameter4, $parameter5, $parameter6, $parameter7, $parameter8, $parameter9, $parameter10
        //Add Friend
        $this->userID=$data[0];
        $this->friendID=$data[1];
        $sql="INSERT INTO `friends`(`userID`, `friendID`, `relation`) VALUES ('$this->userID','$this->friendID','sr')";
        $sql2= "INSERT INTO `friends`(`userID`, `friendID`, `relation`) VALUES ('$this->friendID','$this->userID','gr')";
        $result=$this->booleanQuery($sql);
        $result=$this->booleanQuery($sql2);
        return $result;
    }

    public function delete(array $data) {
        //$userID,$friendID, $parameter3, $parameter4
        //delete Friend
        $sql="DELETE FROM`friends` WHERE `relation`='f' AND `userID`= '$data[0]' AND `friendID`='$data[1]'";
        $sql2="DELETE FROM`friends` WHERE `relation`='f' AND `userID`= '$data[1]' AND `friendID`='$data[0]'";
        $result=$this->booleanQuery($sql);
        $this->booleanQuery($sql2);
        return $result;
    }
    
    public function delete_friend_requst(array $data) {
        //$friendID,$userID, $parameter3, $parameter4
        //Remove Friend Request
        $sql="DELETE FROM`friends` WHERE `relation`='gr' AND `userID`= '$data[0]' AND `friendID`='$data[1]'";
        $sql2="DELETE FROM`friends` WHERE `relation`='sr' AND `userID`= '$data[1]' AND `friendID`='$data[0]'";
        $this->booleanQuery($sql);
        $this->booleanQuery($sql2);
    }

    public function read($id){
        $sql="SELECT * FROM `friends` WHERE `userID`='$id'";
        $result=$this->dataQuery($sql);
        return $result;
    }

    public function accept_friend_requst(array $data) {
        //$userID,$friendID, $parameter3, $parameter4, $parameter5, $parameter6, $parameter7
        //Accept Friend Request
        $sql="UPDATE `friends` SET `relation`='f' WHERE `userID`= '$data[0]' AND `friendID`='$data[1]'";
        $sql2="UPDATE `friends` SET `relation`='f' WHERE `userID`= '$data[1]' AND `friendID`='$data[0]'";
        $this->booleanQuery($sql);
        $this->booleanQuery($sql2);
    }
    
    public function suggestions(){
        $sql="SELECT `id` FROM `user`";
        $result=$this->dataQuery($sql);
        return $result;
    }
    
    public function read_Rand_For_Suggestions(){
        $sql="SELECT * FROM `user` ORDER BY RAND() LIMIT 10";
        $result = $this->dataQuery($sql);
        return $result;
    }
    
    public function get_Friend_Relation($userID,$friendID){
        $sql="SELECT `relation` FROM `friends` WHERE `userID`='$userID' AND `friendID`='$friendID'";
        $result=$this->dataQuery($sql);
        $relation=0;//Not friends
        if($userID==$friendID){
            $relation=-1;//my account
        }
        else if (is_array($result) || is_object($result)){
            foreach ($result as $value) {
                if($value['relation']=="f"){
                    $relation=1;//friends
                }
                else if ($value['relation']=="sr") { //sender request
                    $relation=2;//requested
                }
                else if ($value['relation']=="gr") {//getter request
                    $relation=3;//receivingRequest
                }
            }
        }
        return $relation;
    }

    public function update(array $data) {
        
    }

}