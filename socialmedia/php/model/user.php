<?php

require_once 'database.php';
require_once 'post.php';
require_once 'crud.php';

class user extends database implements crud {

    private $id;
    private $counter;
    private $firstName;
    private $lastName;
    private $email;
    private $mobile;
    private $password;
    private $gender;
    private $birthdate;
    private $work;
    private $theme;
    private $latitude;
    private $longitude;
    private $profile;
    private $cover;

    private function userCounter() {
        $count = 0;
        $counter = 0;
        $SQL = "SELECT max(`counter`) FROM `user` WHERE 1";
        $result = $this->dataQuery($SQL);
        foreach ($result as $value) {
            $counter = $value['max(`counter`)'];
            $count++;
        }
        if ($count == 0) {
            $counter = 1;
        } else {
            $counter++;
        }
        return $counter;
    }

    public function create(array $data) {
        //$firstName,$lastName,$email,$mobile,$password,$gender,$birthdate,$work,$longitude,$latitude
        //$d1 = new database(); 
        $this->firstName = $data[0];
        $this->lastName = $data[1];
        $this->counter = $this->userCounter();
        $this->id = $data[0] . $this->counter;
        $this->email = $data[2];
        $this->mobile = $data[3];
        $this->password = sha1($data[4]);
        $this->gender = $data[5];
        $this->birthdate = $data[6];
        $this->work = $data[7];
        $this->latitude = $data[8];
        $this->longitude = $data[9];
        $this->profile = "../../images/default.jpg";
        $this->cover = "../../images/tropical-island.jpg";
        $SQL = "INSERT INTO `user`(`id`, `counter`, `fname`, `lname`, `email`, `mobile`, `password`, `gender`, `birthdate`, `work` , `theme`, `latitude`, `longitude`,`profile`,`cover`) VALUES ('$this->id','$this->counter','$this->firstName','$this->lastName','$this->email','$this->mobile','$this->password','$this->gender','$this->birthdate','$this->work','light','$this->latitude','$this->longitude','$this->profile','$this->cover')";
        $result = $this->booleanQuery($SQL);
        return $result;
    }

    public function getUserID($email) {
        $sql = "SELECT `id` FROM `user` WHERE `email`='$email'";

        //$d1 = new database();
        $result = $this->dataQuery($sql);

        foreach ($result as $value) {
            $id = $value['id'];
        }

        return $id;
    }

    public function read($id) {
        $sql = "SELECT * FROM `user` WHERE `id`='$id'";
        //$d1 = new database();
        $result = $this->dataQuery($sql);
        return $result;
    }

    public function login($email, $password) {
        //$d1 = new database();
        $sql = "SELECT * FROM `user` WHERE `email`='$email'";
        $result = $this->dataQuery($sql);
        $loginResult = 0; //email not found
        foreach ($result as $value) {
            $loginResult = 2; //wrong password
            if ($password == $value['password']) {
                $loginResult = 1; //login succeded
            }
        }
        return $loginResult;  // not vaild email
    }

    public function update(array $data) {
        //$id,$firstName,$lastName,$mobile,$birthdate,$work,$extra
        $this->firstName = $data[1];
        $this->lastName = $data[2];
        $this->mobile = $data[3];
        $this->birthdate = $data[4];
        $this->work = $data[5];
        //$d1 = new database();
        $sql = "UPDATE `user` SET `fname`='$this->firstName',`lname`='$this->lastName',`mobile`='$this->mobile',`birthdate`='$this->birthdate',`work`='$this->work' WHERE `id`='$data[0]'";
        $result = $this->booleanQuery($sql);
        return $result;
    }

    public function update_photo($id, $des, $type) {
        $sql = "UPDATE `user` SET `$type`='$des' WHERE `id`='$id'";
        //$d1= new database();
        $p1 = new post();
        $result = $this->booleanQuery($sql);
        if ($result == 1) {
            $time = time();
            $date = date("d-m-y h:i:s a");
            $data = array("", $des, $id, $date, $id, $time, "same", "-", "-", $type);
            $result = $p1->create($data);
        }
        return $result;
    }

    public function updatePassword($id, $password) {
        $this->password = sha1($password);
        //$d1 = new database();
        $sql = "UPDATE `user` SET `password`='$this->password' WHERE `id`='$id'";
        $result = $this->booleanQuery($sql);
        return $result;
    }

    public function delete(array $data) {
        $post = new post();
        $result = $post->read($data[0]);
        if (!empty($result)) {
            foreach ($result as $value) {
                $post->delete_post_by_user($value['postID']);
            }
        }
        $sql6 = "DELETE FROM `actions` WHERE `userID`='$data[0]' OR `ownerID`='$data[0]'";
        $result6 = $this->booleanQuery($sql6);
        $sql6 = "DELETE FROM `notifications` WHERE `userID`='$data[0]'";
        $result6 = $this->booleanQuery($sql6);
        $sql6 = "DELETE FROM `links` WHERE `userID`='$data[0]'";
        $result6 = $this->booleanQuery($sql6);
        $sql7 = "DELETE FROM `friends` WHERE `userID`='$data[0]' OR`friendID`='$data[0]'";
        $result7 = $this->booleanQuery($sql7);

        $sql8 = "DELETE FROM `message` WHERE `sender`='$data[0]' OR `receiver`='$data[0]'";
        $result8 = $this->booleanQuery($sql8);

        $sql9 = "DELETE FROM `conversation` WHERE `side1`='$data[0]' OR `side2`='$data[0]'";
        $result9 = $this->booleanQuery($sql9);

        $sql11 = "DELETE FROM `user` WHERE `id`='$data[0]'";
        $result11 = $this->booleanQuery($sql11);
    }

    public function getTheme($id) {
        $sql = "SELECT theme FROM `user` WHERE `id`='$id'";
        $result = $this->dataQuery($sql);
        if (is_array($result) || is_object($result)) {
            foreach ($result as $value) {
                if ($value['theme'] == "light")
                    return 0;
                else if ($value['theme'] == "dark") {
                    return 1;
                }
            }
        }
    }

    public function setTheme($id, $theme) {
        $this->theme = $theme;
        $sql = "UPDATE `user` SET `theme`='$this->theme' WHERE `id`='$id'";
        $result = $this->booleanQuery($sql);
        return $result;
    }

    public function getlocation($userID) {
        //$d1 = new database();
        $sql = "SELECT `map`,`fname`, `lname`, `latitude`, `longitude` FROM `user` WHERE `id` = '$userID'";
        $result = $this->dataQuery($sql);
        return $result;
    }

    public function setlocation($lat, $long, $userID) {
        //$d1 = new database();
        $sql = "UPDATE `user` SET `latitude`='$lat',`longitude`='$long'WHERE `id`='$userID'";
        $result = $this->booleanQuery($sql);
    }

    public function search($content) {
        $sql = "SELECT * FROM `user` u WHERE CONCAT(u.fname, ' ', u.lname) LIKE '$content%' LIMIT 5";
        $i = 0;
        $result = $this->dataQuery($sql);
        if (!empty($result)) {
            foreach ($result as $value) {
                $i++;
            }
        }
        $limit = 5 - $i;
        if ($i < 5) {
            $sql = "SELECT * FROM `user` u WHERE CONCAT(u.fname, ' ', u.lname) LIKE '%$content%' LIMIT 5 UNION SELECT * FROM `user` WHERE `lname` LIKE '%$content%' LIMIT $limit";
            $result = $this->dataQuery($sql);
        }
        return $result;
    }

    public function udateMap($id, $value) {
        $sql = "UPDATE `user` SET `map`='$value' WHERE `id`='$id'";
        $result = $this->booleanQuery($sql);

        return $result;
    }

}
