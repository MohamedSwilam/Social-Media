<?php
require_once '../model/message.php';
require_once '../model/user.php';

session_start();
$myID=$_SESSION['userID'];

$convID=$_GET['convID'];
$content=$_GET['msg'];
$sender=$myID;
$receiver=$_GET['receiver'];
$data=array($convID,$sender,$receiver,$content);

$m1 = new message();
$result=$m1->create($data);

$data2=array($convID,$myID);
$m1->update($data2);

if($result==1){
    $msgs=$m1->read($convID);
    if (is_array($msgs) || is_object($msgs)){
        foreach ($msgs as $value) {
            $msg_content=$value['content'];
            $sender=$value['sender'];
            $date=$value['date'];
            $seen=$value['seen'];
            
            if($seen=="yes"){
                $seen="seen";
            }else{
                $seen="";
            }
            
            $u1=new user();
            $senderInfo=$u1->read($sender);
            if (is_array($senderInfo) || is_object($senderInfo)){
                foreach ($senderInfo as $valuee) {
                    $name=$valuee['fname']." ".$valuee['lname'];
                }
            }
            if($myID==$sender){
                $class="right-msg";
                $name=$seen;
            }else{
                $class="left-msg";
            }
            
            echo "<div class='msg'>
                    <div class='$class'>$msg_content<span class='footer'><span class='sender'>$name</span><span class='time'>$date</span><span></div>
                </div>";
        }
    }
}

