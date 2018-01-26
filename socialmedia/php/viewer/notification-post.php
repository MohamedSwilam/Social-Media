<?php
session_start();
if($_SESSION['login']==FALSE){
    $_SESSION['result']=9;
    header("Location: ../viewer/index.php");
}
require_once '../model/user.php';
require_once '../model/post.php';
$id = $_SESSION['userID'];
$u1 = new user();

if (isset($_SESSION['id_of_post']) && !empty($_SESSION['id_of_post'])) {
    $posttID = $_SESSION['id_of_post'];
}

if (isset($_SESSION['actionpostresult']) && !empty($_SESSION['actionpostresult'])) {
    $writepostResult = $_SESSION['actionpostresult'];
} else {
    $writepostResult = 3;
}

$userInfo = $u1->read($id);
if (is_array($userInfo) || is_object($userInfo)) {
    foreach ($userInfo as $value) {
        $firstName = $value['fname'];
        $lastName = $value['lname'];
        $mobile = $value['mobile'];
        $password = $value['password'];
        $birthdate = $value['birthdate'];
        $work = $value['work'];
        $gender = $value['gender'];
        $profilePhoto = $value['profile'];
    }
}

$themeResult = $u1->getTheme($id);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Notification</title>
        <?php
        if ($themeResult == 0) {
            echo "<link rel='stylesheet' href='../../css/notification-post-light.css'>";
            echo "<link rel='stylesheet' href='../../css/post-light.css'>";
            echo "<link rel='stylesheet' href='../../css/light-navbar.css'>";
        } else if ($themeResult == 1) {
            echo "<link rel='stylesheet' href='../../css/notification-post.css'>";
            echo "<link rel='stylesheet' href='../../css/post-post.css'>";
            echo "<link rel='stylesheet' href='../../css/navbar.css'>";
        }
        ?>
        <link rel="stylesheet" href="../../css/sweetalert2.min.css">
        <script src="../../js/jquery-3.2.1.min.js"></script>
        <script src="../../js/sweetalert2.min.js"></script>
        <script src="../../js/getlocation.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCzdpGWJV2ahuUCfJnQo5VGYtJAB90Zea4&callback=initMap" async defer></script>
    </head>

    <body>

        <!-- ------------------ Start Navbar ------------------ -->
        <?php 
        include 'navbar.php';
        ?>

        <!-- ------------------ End Navbar ------------------ -->

        <!-- ------------------ Start Posts ------------------ -->
        <div class="post-container" style="margin-top: 100px;margin-bottom: 10px;">
            <?php
            $p1 = new post();
            $postsResult = $p1->read_single_post($posttID);
            $page = "notification";
            $top="0px";
            require 'post-viewer.php';
            ?>

        </div>
        <!-- ------------------ End Posts ------------------ -->


        <script src="../../js/jquery.nicescroll.js"></script>
        <script src="../../js/jquery.smooth-scroll.min.js"></script>
        <script src="../../js/post.js"></script>
        <script src="../../js/navbar.js"></script>
        <script src="../../js/scroll-light.js"></script>
        
    </body>
</html>