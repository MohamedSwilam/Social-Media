<?php
session_start();
if ($_SESSION['login'] == FALSE) {
    $_SESSION['result'] = 9;
    header("Location: ../viewer/index.php");
}
require_once '../model/user.php';
require_once '../model/friend.php';
require_once '../model/conversation.php';
require_once '../model/message.php';
require_once '../model/userLinks.php';
$id = $_SESSION['userID'];

$u1 = new user();
$f1 = new friend();
$c1 = new conversation();
$m1 = new message();


$themeResult = $u1->getTheme($id);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Messages</title>
        <?php
        if ($themeResult == 0) {
            echo "<link rel='stylesheet' href='../../css/messages-light.css'>";
            echo "<link rel='stylesheet' href='../../css/light-navbar.css'>";
            echo "<link rel='stylesheet' href='../../css/myinfo-light.css'>";
        } else if ($themeResult == 1) {
            echo "<link rel='stylesheet' href='../../css/messages.css'>";
            echo "<link rel='stylesheet' href='../../css/navbar.css'>";
            echo "<link rel='stylesheet' href='../../css/myinfo.css'>";
        }
        ?>
    </head>

    <body>
        <!-- ------------------- Start Navbar ------------------- -->
        <?php
        include 'navbar.php';
        include 'myinfo.php';
        ?> 
        <!-- ------------------- End Navbar ------------------- -->

        <!-- ------------------ Start Messages ------------------ -->
        <div class="perspective">
            <?php
            $convs = $c1->read($id);
            $counter = 1;
            if (is_array($convs) || is_object($convs)) {
                foreach ($convs as $value) {
                    $side1 = $value['side1'];
                    $side2 = $value['side2'];
                    $cov_id = $value['id'];

                    $idName = "c" . $counter;

                    if ($side1 == $id) {
                        $friend_id = $side2;
                    } else {
                        $friend_id = $side1;
                    }
                    $friendInfo = $u1->read($friend_id);
                    if (is_array($friendInfo) || is_object($friendInfo)) {
                        foreach ($friendInfo as $valuee) {
                            $friendName = $valuee['fname'] . " " . $valuee['lname'];
                            $friendProfile = $valuee['profile'];
                        }
                    }

                    $last_msg_info = $m1->read_last_msg($cov_id);
                    if (is_array($last_msg_info) || is_object($last_msg_info)) {
                        foreach ($last_msg_info as $valuee) {
                            $content = $valuee['content'];
                        }
                    }
                    if (!empty($content)) {
                        echo "<div class='message-container' id='$idName'>
                              <form method='post' action='../controller/chat_controller' style='display:none;'>
                              <input type='hidden' name='convID' value='$cov_id'>
                              <button name='redirect' id='$idName-btn'>redirect</button>
                              </form>
                              <img src='$friendProfile' width='50px' height='50px' style='border-radius: 25px'>
                              <h1><span>$friendName </span><p>$content</p></h1>
                              </div>";
                    }
                    $counter++;
                }
            }
            ?>
        </div>
        <!-- ------------------- End Messages ------------------- -->


        <!-- ----------------- Start New Message ----------------- --> 
        <div class="new-message"><center>+</center></div>
        <!-- ----------------- End New Message ----------------- --> 
        <div class="choose-friend">
            <input class="friend-search-input" type="text" placeholder="Find Friends..">
            <div class="friend-list">
                <?php
                $c = 1;
                $numberOfFriends = 0;
                $result = $f1->read($id);
                if (is_array($result) || is_object($result)) {
                    foreach ($result as $value) {
                        if ($value['relation'] == "f") {
                            $numberOfFriends++;
                        }
                    }
                }

                if (is_array($result) || is_object($result)) {
                    foreach ($result as $value) {
                        if ($value['relation'] == "f") {
                            $class = "friend" . $c;
                            $class2 = "";
                            $class3 = "";
                            if ($c == 1) {
                                $class2 = "first";
                            }
                            if ($c == $numberOfFriends) {
                                $class3 = "last";
                            }
                            $getID = $value['friendID'];
                            $friendInfo = $u1->read($getID);
                            if (is_array($friendInfo) || is_object($friendInfo)) {
                                foreach ($friendInfo as $valuee) {
                                    $friendID = $valuee['id'];
                                    $name = $valuee['fname'] . " " . $valuee['lname'];
                                    $profilePhoto = $valuee['profile'];
                                }
                            }
                            echo"<div class='friend $class $class2 $class3' id='$class'>
                        <form method='post' action='../controller/chat_controller.php' style='display:none'>
                        <input type='hidden' name='side2' value='$friendID'>
                        <button name='create' id='btn-$class'>go</button>
                        </form>
                        <img src='$profilePhoto'>
                        <span class='Name'>$name</span>
                        </div>";
                            $c++;
                        }
                    }
                }
                ?>
                <div class="close"><center>Close</center></div>
            </div>
        </div>

        <script src="../../js/jquery-3.2.1.min.js"></script>
        <script src="../../js/jquery.nicescroll.js"></script>
        <script src="../../js/jquery.smooth-scroll.min.js"></script>
        <script src="../../js/messages.js"></script>
        <script src="../../js/navbar.js"></script>
        <script src="../../js/myinfo.js"></script>
        <script src="../../js/scroll-light.js"></script>

    </body>
</html>