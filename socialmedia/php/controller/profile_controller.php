<?php

require_once '../model/friend.php';
require_once '../model/conversation.php';
$f1 = new friend();

if (isset($_POST['btn-remove'])) {
    $data = array($_POST['ProfileOwnerid'], $_POST['myid']);
    $f1->delete($data);
    header("Location: ../viewer/profile.php");
}

if (isset($_POST['btn-add'])) {
    $data = array($_POST['myid'], $_POST['ProfileOwnerid']);
    $f1->create($data);
    header("Location: ../viewer/profile.php");
}

if (isset($_POST['btn-Cancel'])) {
    $data = array($_POST['ProfileOwnerid'], $_POST['myid']);
    $f1->delete_friend_requst($data);
    header("Location: ../viewer/profile.php");
}

if (isset($_POST['btn-accept'])) {
    $data = array($_POST['myid'], $_POST['ProfileOwnerid']);
    $f1->accept_friend_requst($data);
    header("Location: ../viewer/profile.php");
}

if (isset($_POST['btn-message'])) {
    $friendID = $_POST['ProfileOwnerid'];
    $myID = $_SESSION['userID'];
    $c1 = new conversation();
    $exist = $c1->check($myID, $friendID);
    if ($exist == "no") {
        $data = array($myID, $friendID);
        $result = $c1->create($data);
        echo $result;
        if ($result == 1) {
            $get_convID = $c1->get_convID($myID, $friendID);
            if (is_array($get_convID) || is_object($get_convID)) {
                foreach ($get_convID as $value) {
                    $_SESSION['convID'] = $value['id'];
                }
            }
        }
    } else {
        $_SESSION['convID'] = $exist;
    }
    header("Location: ../viewer/conversation.php");
}


