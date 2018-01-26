<?php
require_once '../model/post.php';
require_once '../model/notification.php';
$n1 = new notification();
session_start();

if(isset($_POST['btn-show'])){
    if($_POST['kind']=="none"){
        $postID=$_POST['postID'];
        $userID=$_POST['userID'];
        $_SESSION['id_of_post']=$postID;
        header("Location: ../viewer/notification-post.php");
    }else{
        $postID=$_POST['postID'];
        $userID=$_POST['userID'];
        $kind=$_POST['kind'];
        $data=array($userID,$postID,$kind);
        $n1->update($data);
        $_SESSION['id_of_post']=$postID;
        header("Location: ../viewer/notification-post.php");
    }
}

