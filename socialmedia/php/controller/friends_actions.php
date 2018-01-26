<?php

require '../model/friend.php';
$f = new friend();

if (isset($_POST['btn-accept'])) {
    $friendID = $_POST['id'];
    $userID = $_POST['myid'];
    $data = array($userID, $friendID);
    $f->accept_friend_requst($data);
    header("Location: ../viewer/friends.php");
}

if (isset($_POST['btn-remove'])) {
    $friendID = $_POST['id'];
    $userID = $_POST['myid'];
    $data = array($userID, $friendID);
    $f->delete_friend_requst($data);
    header("Location: ../viewer/friends.php");
}

if (isset($_POST['btn-connect'])) {
    $friendID = $_POST['id'];
    $userID = $_POST['myid'];
    $data = array($userID, $friendID);
    $result = $f->get_Friend_Relation($userID, $friendID);
    if (empty($result)) {
        $result = $f->create($data);
    }
    header("Location: ../viewer/friends.php");
}