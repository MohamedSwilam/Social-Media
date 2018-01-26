<?php
    require_once 'database.php';
    require_once 'crud.php';

class userLinks extends database implements crud{
    //put your code here
   private $facebooklink; 
   private $instagramlink;
   private $twitterlink; 
   private $linkedinlink;
   private $googlepluslink;  
   
    
   public function create(array $data){
    //$userID,$facebookLink,$instagramLink,$twitterLink,$linkedinLink,$googleplusLink,$extra1,$extra1,$extra1,$extra1
    //$d1 = new database();
    $this->facebooklink=$data[1];
    $this->instagramlink=$data[2];
    $this->twitterlink=$data[3];
    $this->linkedinlink=$data[4];
    $this->googlepluslink=$data[5];
    $this->userID=$data[0];
        
    $SQL="INSERT INTO `links`(`userID`, `facebook`, `twitter`, `instgram`, `linkedin`, `googleplus`) VALUES ('$this->userID','$this->facebooklink','$this->instagramlink','$this->twitterlink','$this->linkedinlink','$this->googlepluslink')";
    $result=$this->booleanQuery($SQL);
        return $result;
    }
    
   public function update(array $data){
    //$userID,$facebookLink,$instagramLink,$twitterLink,$linkedinLink,$googleplusLink,$extra1
    //$d1 = new database();
    $this->facebooklink=$data[1];
    $this->instagramlink=$data[2];
    $this->twitterlink=$data[3];
    $this->linkedinlink=$data[4];
    $this->googlepluslink=$data[5];
    $this->userID=$data[0];
        
    $SQL="UPDATE `links` SET `facebook`='$this->facebooklink',`twitter`='$this->twitterlink',`instgram`='$this->instagramlink',`linkedin`='$this->linkedinlink', `googleplus`='$this->googlepluslink' WHERE `userID`='$this->userID'";
        
    $result=$this->booleanQuery($SQL);
        
        return $result;
   }
    
   public function read($id){
        $sql="SELECT * FROM `links` WHERE `userID`='$id'";
        //$d1 = new database();
        $result=$this->dataQuery($sql);
        return $result;
    }
    
   public function delete(array $data){
        
    }
}
