<?php
require_once '../model/message.php';
require_once '../model/user.php';

session_start();
$myID=$_SESSION['userID'];
$convID=$_POST['convID'];

$m = new message();

$data=array($convID,$myID);
$m->update($data);

$msg=$m->read($convID);
if (is_array($msg) || is_object($msg)){
    foreach ($msg as $value) {
        $msg_content=$value['content'];
        $sender=$value['sender'];
        $date=$value['date'];
        $seen=$value['seen'];
            
        if($seen=="yes"){
            $seen="seen";
        }else{
            $seen="";
        }

        $u=new user();
        $senderData=$u->read($sender);
        if (is_array($senderData) || is_object($senderData)){
            foreach ($senderData as $valuee) {
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
//call create();

//call read();

//loop result and echo
