<?php
require_once '../model/message.php';
require_once '../model/friend.php';
require_once '../model/notification.php';
require_once '../model/conversation.php';

$id = $_SESSION['userID'];
$friendCounter = 0;
$messageCounter = 0;
$notificationCounter = 0;
$f1 = new friend();
$n1 = new notification();
$m1 = new message();
$c1 = new conversation();

$result = $c1->read($id);
if (!empty($result)) {
    foreach ($result as $value) {
        $con_id = $value['id'];
        $result2 = $m1->read($con_id);
        if (!empty($result2)) {
            foreach ($result2 as $value) {
                if ($value['seen'] == "no" && $value['receiver'] == $id) {
                    $messageCounter++;
                }
            }
        }
    }
}


$result = $n1->read($id);
if (!empty($result)) {
    foreach ($result as $value) {
        if ($value['seen'] == "false") {
            $notificationCounter++;
        }
    }
}


$result = $f1->read($id);

if (!empty($result)) {
    foreach ($result as $value) {
        if ($value['relation'] == "gr") {
            $friendCounter++;
        }
    }
}

$total = $friendCounter + $notificationCounter + $messageCounter;
?>
<div class="nav-bar">
    <div class="logo"><span>C</span>onnect</div>
    <div class="search">
        <form class="search-form" method="post">
            <input class="input-search" type="text" placeholder="Search" required>
        </form>
    </div>
    <div class="nav-btns">
        <form method="post">
            <button name="btn-home" class="home-btn">Home</button>
            <button name="btn-maps" class="map-btn">Maps</button>
            <button name="btn-profile" class="profile-btn">Profile</button>
            <?php
            if (isset($_POST['btn-home'])) {
                header("Location: ../viewer/home.php");
            }
            if (isset($_POST['btn-profile'])) {
                $_SESSION['profileOwnerID'] = $id;
                header("Location: ../viewer/profile.php");
            }
             if (isset($_POST['btn-maps'])) {
                header("Location: ../viewer/maps.php");
            }
            ?>
        </form>
    </div>

    <div class="search-result" id="search-result">

    </div>

    <?php
    if ($total > 0) {
        echo "<div class='total-counter'><span>$total</span></div>";
    }
    ?>

    <img class="nav-menu" src="../../images/line-menu.png"> 
    <div class="nav-bar-dropdown-menu">

        <button onclick="redirectFriends()"><img src="../../images/avatar.png">Friends
            <?php
            if ($friendCounter > 0) {
                echo "<div class='counter'>$friendCounter</div>";
            }
            ?></button>
        <button onclick="redirectMessages()"><img src="../../images/envelope.png">Messages 
            <?php
            if ($messageCounter > 0) {
                echo "<div class='counter'>$messageCounter</div>";
            }
            ?>
        </button>
        <button onclick="redirectNotifications()"><img src="../../images/notification.png">Notifications
            <?php
            if ($notificationCounter > 0) {
                echo "<div class='counter'>$notificationCounter</div>";
            }
            ?>
        </button>
    </div>
</div>
