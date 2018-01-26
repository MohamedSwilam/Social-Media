<?php

require_once '../model/conversation.php';
require_once '../model/message.php';
session_start();

$myID = $_SESSION['userID'];
$friendID = $_POST['side2'];
$content = $_POST['msg'];

$c1 = new conversation();
$exist = $c1->check($myID, $friendID);
if ($exist == "no") {
    $data = array($myID, $friendID);
    $result = $c1->create($data);
    //echo $result;
    if ($result == 1) {
        $get_convID = $c1->get_convID($myID, $friendID);
        if (is_array($get_convID) || is_object($get_convID)) {
            foreach ($get_convID as $value) {
                $convID = $value['id'];
            }
        }
    }
} else {
    $convID = $exist;
}

$data=array($convID,$myID,$friendID,$content);

$m1 = new message();
$result=$m1->create($data);
if($result==1){
    echo "done";
}else{
    echo "failed";
}
//header("Location: ../viewer/conversation.php");
