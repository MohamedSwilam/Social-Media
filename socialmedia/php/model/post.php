<?php

require_once 'crud.php';
require_once 'database.php';
require_once 'notification.php';
require_once '../model/actions.php';

class post extends database implements crud {

    private $counter;
    private $postID;
    private $ownerPostID;
    private $userID;
    private $owner;
    private $content;
    private $img;
    private $date;
    private $time;
    private $latitude;
    private $longitude;
    private $type;
    private $status;
    private $sqlAllPosts = "";

    private function postCounter($userID) {
        //$d1 = new database();
        $count = 0;
        $counter = 0;
        $SQL = "SELECT max(`counter`) FROM `posts` WHERE 1";
        $result = $this->dataQuery($SQL);
        if (is_array($result) || is_object($result)) {
            foreach ($result as $value) {
                $counter = $value['max(`counter`)'];
                $count++;
            }
        }
        if ($count == 0) {
            $counter = 1;
        } else {
            $counter++;
        }
        return $counter;
    }

    public function create(array $data) {
        //$content, $img, $owner, $date, $userID, $time, $postOwnerID,$longitude,$latitude,$type
        //$d1 = new database();
        $result = 1;
        $counter = $this->postCounter($data[4]);
        $this->counter = $counter;
        $this->postID = "post" . $counter;
        $this->ownerPostID = $data[6];
        $this->content = $data[0];
        $this->img = $data[1];
        $this->time = $data[5];
        $this->date = $data[3];
        $this->owner = $data[2];
        $this->userID = $data[4];
        $this->latitude = $data[8];
        $this->longitude = $data[7];
        $this->type = $data[9];
        $this->status = "new";
        
        if ($data[6] == "same") {
            $this->ownerPostID = $this->postID;
        }

        $SQL = "INSERT INTO `posts`(`counter`,`postID`, `ownerPostID`, `userID`, `owner`, `content` , `img` , `date`,`time`, `latitude`, `longitude`,`type`,`status`) VALUES ('$this->counter','$this->postID','$this->ownerPostID','$this->userID','$this->owner','$this->content','$this->img','$this->date','$this->time','$this->latitude','$this->longitude','$this->type','$this->status')";
        $result = $this->booleanQuery($SQL);
        if ($data[6] != "same" && $result == 1 && $data[4] != $data[2]) {
            $n1 = new notification();
            $data2 = array($this->userID, $this->postID, "share", $this->time);
            $result = $n1->create($data2);
        }
        if ($data[6] != "same") {
            $a1 = new actions();
            $dataAction = array($this->userID, $this->owner, $this->postID, "share", $this->time);
            $result = $a1->create($dataAction);
        }
        return $result;
    }

    public function delete(array $data) {
        //$ownerPostID,$postID,$ownerID,$userID
        $sql = "DELETE FROM `saveditems` WHERE `postID`='$data[1]'";
        $result = $this->booleanQuery($sql);
        if ($data[2] == $data[3] && $data[1] == $data[0]) {
            if ($result == 1) {
                $sql = "DELETE FROM `likes` WHERE `postOwnerID`='$data[0]'";
                $result = $this->booleanQuery($sql);
            }
            if ($result == 1) {
                $sql = "DELETE FROM notifications WHERE EXISTS (SELECT * FROM posts WHERE posts.postID = notifications.postID AND posts.ownerPostID = '$data[0]')";
                $result = $this->booleanQuery($sql);
            }
            if ($result == 1) {
                $a1 = new actions();
                $sql = "DELETE FROM actions WHERE EXISTS (SELECT * FROM posts WHERE posts.postID = actions.postID AND posts.ownerPostID = '$data[0]')";
                $result = $this->booleanQuery($sql);
            }
            if ($result == 1) {
                $sql = "DELETE FROM `comments` WHERE `postOwnerID`='$data[0]'";
                $result = $this->booleanQuery($sql);
            }
            if ($result == 1) {
                $sql = "DELETE FROM `posts` WHERE `ownerPostID`='$data[0]'";
                $result = $this->booleanQuery($sql);
            }
        } else if ($data[2] != $data[3] || $data[1] != $data[0]) {
            if ($result == 1) {
                $sql = "DELETE FROM `likes` WHERE `postID`='$data[1]'";
                $result = $this->booleanQuery($sql);
            }
            if ($result == 1) {
                $sql = "DELETE FROM `comments` WHERE `postID`='$data[1]'";
                $result = $this->booleanQuery($sql);
            }
            if ($result == 1) {
                $sql = "DELETE FROM `notifications` WHERE `postID`='$data[1]'";
                $result = $this->booleanQuery($sql);
            }
            if ($result == 1) {
                $sql = "DELETE FROM `actions` WHERE `postID`='$data[1]'";
                $result = $this->booleanQuery($sql);
            }
            $sql = "DELETE FROM `posts` WHERE `postID`='$data[1]'";
            $result = $this->booleanQuery($sql);
        }
        return $result;
    }

    public function delete_post_by_user($postID) {
        $sql = "DELETE FROM `saveditems` WHERE `postID`='$postID'";
        $result = $this->booleanQuery($sql);
        if ($result == 1) {
            $sql = "DELETE FROM `likes` WHERE `postOwnerID`='$postID'";
            $result = $this->booleanQuery($sql);
        }
        if ($result == 1) {
            $sql = "DELETE FROM notifications WHERE EXISTS (SELECT * FROM posts WHERE posts.postID = notifications.postID AND posts.ownerPostID = '$postID')";
            $result = $this->booleanQuery($sql);
        }
        if ($result == 1) {
            $a1 = new actions();
            $sql = "DELETE FROM actions WHERE EXISTS (SELECT * FROM posts WHERE posts.postID = actions.postID AND posts.ownerPostID = '$postID')";
            $result = $this->booleanQuery($sql);
        }
        if ($result == 1) {
            $sql = "DELETE FROM `comments` WHERE `postOwnerID`='$postID'";
            $result = $this->booleanQuery($sql);
        }
        if ($result == 1) {
            $sql = "DELETE FROM `posts` WHERE `ownerPostID`='$postID'";
            $result = $this->booleanQuery($sql);
        }
    }

    public function read($id) {
        //$d1 = new database();
        $sql = "SELECT * FROM `posts` WHERE `userID`='$id' ORDER BY counter DESC";
        $result = $this->dataQuery($sql);
        return $result;
    }

    public function read_single_post($postID) {
        $sql = "SELECT * FROM `posts` WHERE `postID`='$postID'";
        $result = $this->booleanQuery($sql);
        return $result;
    }

    public function addLike($postID, $userID, $postOwnerID, $date, $owner) {
        $SQL = "INSERT INTO `likes`(`userID`,`postID`,`postOwnerID`,`date`) VALUES ('$userID','$postID','$postOwnerID','$date')";
        $result = $this->booleanQuery($SQL);
        if ($result == 1 && $userID != $owner) {
            $n1 = new notification();
            $data = array($userID, $postID, "like", time());
            $result = $n1->create($data);
        }
        if ($result == 1) {
            $a1 = new actions();
            $dataAction = array($userID, $owner, $postID, "like", time());
            $result = $a1->create($dataAction);
        }
        return $result;
    }

    public function removeLike($postID, $userID) {
        $sql = "DELETE FROM `likes` WHERE `userID`='$userID' AND `postID`='$postID'";
        $result = $this->booleanQuery($sql);
        if ($result == 1) {
            $n1 = new notification();
            $data = array($userID, $postID, "like");
            $result = $n1->delete($data);
            if ($result == 1) {
                $a1 = new actions();
                $dataAction = array($userID, $postID, "like");
                $result = $a1->delete($dataAction);
            }
        }
        return $result;
    }

    public function readLike($postID) {
        $sql = "SELECT * FROM `user` WHERE `id` IN (SELECT `userID` FROM `likes` WHERE `postID`='$postID')";
        $result = $this->booleanQuery($sql);
        return $result;
    }

    public function countLC($tableName, $postID) {
        $sql = "SELECT * FROM `$tableName` WHERE `postID`='$postID'";
        //$d1 = new database();
        $result = $this->countRows($sql);
        return $result;
    }

    public function checkLike($postID, $userID) {
        $sql = "SELECT * FROM `likes` WHERE `userID`='$userID' AND `postID`='$postID'";
        //$d1= new database();
        $result = $this->dataQuery($sql);
        if (is_array($result) || is_object($result)) {
            return TRUE;
        }
        return FALSE;
    }

    public function update(array $data) {
        //postID,Content
        $this->postID = $data[0];
        $this->content = $data[1];
        $this->status = "edited";
        $sql = "UPDATE `posts` SET `content`='$this->content',`status`='$this->status' WHERE `ownerPostID`='$this->postID'";
        $result = $this->booleanQuery($sql);
        return $result;
    }

    public function addcomment($postID, $postOwnerID, $userID, $date, $content, $owner) {
        $SQL = "INSERT INTO `comments`(`userID`,`postID`,`postOwnerID`,`content`,`date`) VALUES ('$userID','$postID','$postOwnerID','$content','$date')";
        $result = $this->booleanQuery($SQL);
        if ($result == 1 && $owner != $userID) {
            $n1 = new notification();
            $data = array($userID, $postID, "comment");
            $result = $n1->create($data);
        }
        if ($result == 1) {
            $a1 = new actions();
            $dataAction = array($userID, $owner, $postID, "comment", time());
            $result = $a1->create($dataAction);
        }
        return $result;
    }

    public function readComments($postID) {
        //$d1 = new database();
        $sql = "SELECT * FROM `comments` WHERE `postID`='$postID'";
        $result = $this->dataQuery($sql);
        return $result;
    }

    public function savePost($userID, $ownerPostID) {
        //$d1 = new database();
        $SQL = "INSERT INTO `saveditems`(`userID`,`postID`) VALUES ('$userID','$ownerPostID')";
        $result = $this->booleanQuery($SQL);
        return $result;
    }

    public function checkSavePost($userID, $ownerPostID) {
        //$d1= new database();
        $sql = "SELECT * FROM `saveditems` WHERE `postID`='$ownerPostID' AND `userID`='$userID'";
        $result = $this->dataQuery($sql);
        if (is_array($result) || is_object($result)) {
            return TRUE;
        }
        return FALSE;
    }

    public function unsavePost($userID, $ownerPostID) {
        $sql = "DELETE FROM `saveditems` WHERE `postID`='$ownerPostID' AND `userID`='$userID'";
        $result = $this->booleanQuery($sql);
        return $result;
    }

    public function readSavedPosts($userID) {
        $sql = "SELECT * FROM `posts` INNER JOIN `saveditems` ON posts.postID = saveditems.postID AND saveditems.userID='$userID'";
        $result = $this->dataQuery($sql);
        return $result;
    }

    private function getFriendsID($userID) {
        //$d1 = new database();
        $sql = "SELECT `friendID` FROM `friends` WHERE `userID`='$userID' AND `relation`='f'";
        $result = $this->dataQuery($sql);
        return $result;
    }

    private function getAllPostsSQL($userID) {
        $this->sqlAllPosts = "SELECT * FROM `posts` WHERE `userID`='$userID'";
        $result = $this->getFriendsID($userID);
        if (is_array($result) || is_object($result)) {
            foreach ($result as $value) {
                $friendID = $value['friendID'];
                $this->sqlAllPosts.=" UNION SELECT * FROM `posts` WHERE `userID`='$friendID'";
            }
        }
        $this->sqlAllPosts.=" ORDER BY `time` DESC";
        return $this->sqlAllPosts;
    }

    public function getAllPosts($userID) {
        $sql = $this->getAllPostsSQL($userID);
        $result = $this->dataQuery($sql);
        return $result;
    }

    public function getPhotos($userID) {
        $SQL = "SELECT * FROM `posts` WHERE `userID`='$userID' AND `img`!='no'";
        $result = $this->dataQuery($SQL);
        return $result;
    }
    
    public function editComment(array $data){
        $this->commentID=$data[0];
        $this->content=$data[1];
        $sql="UPDATE `comments` SET `content`='$this->content' WHERE `comment_id`='$this->commentID'";
        $result=$this->booleanQuery($sql);
        return $result;
        
    }

}
