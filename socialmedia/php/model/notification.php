<?php
require_once 'database.php';
require_once 'crud.php';

class notification extends database implements crud{
    private $userID;
    private $postID;
    private $kind;
    private $date;
    private $time;
    private $seen;
    
    public function create(array $data) {
        //userID,postID,Kind
        $this->userID=$data[0];
        $this->postID=$data[1];
        $this->kind=$data[2];
        $this->date = date("d-m-y h:i:s a");
        $this->time=time();
        $this->seen="false";
        $sql="INSERT INTO `notifications`(`userID`, `postID`, `kind`, `date`, `time`, `seen`) VALUES ('$this->userID','$this->postID','$this->kind','$this->date','$this->time','$this->seen')";
        $result = $this->booleanQuery($sql);
        return $result;
    }

    public function delete(array $data) {
        //userID,postID,type
        $sql="DELETE FROM `notifications` WHERE `userID`='$data[0]' AND `postID`='$data[1]' AND `kind`='$data[2]'";
        $result=$this->booleanQuery($sql);
        return $result;
    }

    public function read($id) {
        $sql="SELECT A.* FROM notifications A WHERE A.kind='like' AND A.postID in (SELECT B.postID FROM posts B WHERE B.userID = '$id') UNION SELECT A.* FROM notifications A WHERE A.kind='comment' AND A.postID in (SELECT B.postID FROM posts B WHERE B.userID = '$id') UNION SELECT A.* FROM notifications A WHERE A.kind='share' AND A.postID in (SELECT B.postID FROM posts B WHERE B.owner = '$id') ORDER BY `time` DESC";
        $result = $this->dataQuery($sql);
        return $result;
    }

    public function update(array $data) {
        //userID,postID,Kind
        $this->seen="true";
        $sql="UPDATE `notifications` SET `seen`='$this->seen' WHERE `userID`='$data[0]' AND `postID`='$data[1]' AND `kind`='$data[2]'";
        $result = $this->booleanQuery($sql);
        return $result;
    }
}
