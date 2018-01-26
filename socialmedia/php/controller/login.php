<?php
session_start();
require '../model/user.php';

$u1= new user();

if (isset($_POST['btn-login'])){
    $email=$_POST['email'];
    $password=  sha1($_POST['password']);
    $result=$u1->login($email , $password);

    if($result==0){ // email not found
        $_SESSION['result'] = 4;
        header("Location: ../viewer/index.php");
    }else if($result==1){   //success
        
        $id= $u1->getUserID($email);
        $u1->setlocation($_POST['lat'], $_POST['long'], $id);
        $_SESSION['userID'] = $id;
        $_SESSION['profileOwnerID'] = $id;
        $_SESSION['writepostresult']="";
        $_SESSION['login']=TRUE;
        header("Location: ../viewer/home.php");
    }else if($result==2){ //wrong password
        $_SESSION['result'] = 6;
        header("Location: ../viewer/index.php");
    }
}