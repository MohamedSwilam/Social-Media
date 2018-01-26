<?php
session_start();
if($_SESSION['login']==FALSE){
    $_SESSION['result']=9;
    header("Location: ../viewer/index.php");
}
require_once '../model/user.php';
require_once '../model/post.php';
require_once '../model/userLinks.php';
$id = $_SESSION['userID'];

if (isset($_SESSION['actionpostresult']) && !empty($_SESSION['actionpostresult'])) {
    $writepostResult = $_SESSION['actionpostresult'];
} else {
    $writepostResult = 3;
}

$u1 = new user();

$result = $u1->read($id);
if (is_array($result) || is_object($result)) {
    foreach ($result as $value) {
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

$facebook = "#";
$twitter = "#";
$instgram = "#";
$linkedin = "#";
$googleplus = "#";
$l1 = new userLinks();
$LinksResult = $l1->read($id);
if (is_array($LinksResult) || is_object($LinksResult)) {
    foreach ($LinksResult as $value) {
        $facebook = $value['facebook'];
        $twitter = $value['twitter'];
        $instgram = $value['instgram'];
        $linkedin = $value['linkedin'];
        $googleplus = $value['googleplus'];
    }
}

$themeResult = $u1->getTheme($id);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Saved Items</title>
        <link rel="stylesheet" href="../../css/sweetalert2.min.css">
        <script src="../../js/jquery-3.2.1.min.js"></script>
        <script src="../../js/sweetalert2.min.js"></script>
        <script src="../../js/getlocation.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCzdpGWJV2ahuUCfJnQo5VGYtJAB90Zea4&callback=initMap" async defer></script>
        <?php
        if ($themeResult == 0) {
            echo "<link rel='stylesheet' href='../../css/saved-items-light.css'>";
            echo "<link rel='stylesheet' href='../../css/post-light.css'>";
            echo "<link rel='stylesheet' href='../../css/light-navbar.css'>";
            echo "<link rel='stylesheet' href='../../css/myinfo-light.css'>";
        } else if ($themeResult == 1) {
            echo "<link rel='stylesheet' href='../../css/saved-items.css'>";
            echo "<link rel='stylesheet' href='../../css/post.css'>";
            echo "<link rel='stylesheet' href='../../css/navbar.css'>";
            echo "<link rel='stylesheet' href='../../css/myinfo.css'>";
        }
        ?>
    </head>

    <body>

        <!-- ------------------ Start Navbar ------------------ -->
        <?php
        include 'navbar.php';
        include 'myinfo.php';
        include 'actions.php';
        ?>

        <!-- ------------------ End Navbar ------------------ -->

        <!-- ------------------ Start Posts ------------------ -->
        <?php
        $page = "save";
        $p1 = new post();
        $top="0px";
        $postsResult = $p1->readSavedPosts($id);
        require 'post-viewer.php';
        ?>
        
        <!-- ------------------ End Posts ------------------ -->

        <script src="../../js/jquery.nicescroll.js"></script>
        <script src="../../js/jquery.smooth-scroll.min.js"></script>
        <script src="../../js/post.js"></script>
        <script src="../../js/navbar.js"></script>
        <script src="../../js/myinfo.js"></script>
        <script src="../../js/scroll-light.js"></script>
        
    </body>
</html>