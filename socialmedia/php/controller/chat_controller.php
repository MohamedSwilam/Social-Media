<?php

require_once '../model/conversation.php';
session_start();

if (isset($_POST['create'])) {
    $friendID = $_POST['side2'];
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

if (isset($_POST['redirect'])) {
    $_SESSION['convID'] = $_POST['convID'];
    header("Location: ../viewer/conversation.php");
}