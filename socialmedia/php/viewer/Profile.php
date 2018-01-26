<?php
session_start();
if ($_SESSION['login'] == FALSE) {
    $_SESSION['result'] = 9;
    header("Location: ../viewer/index.php");
}

require_once '../model/user.php';
require_once '../model/userLinks.php';
require_once '../model/post.php';
require_once '../model/friend.php';

$id = $_SESSION['userID'];
if (isset($_SESSION['profileOwnerID']) && !empty($_SESSION['profileOwnerID'])) {
    $ProfileOwnerid = $_SESSION['profileOwnerID'];
} else {
    $ProfileOwnerid = $_SESSION['userID'];
}

if (isset($_SESSION['actionpostresult']) && !empty($_SESSION['actionpostresult'])) {
    $writepostResult = $_SESSION['actionpostresult'];
} else {
    $writepostResult = 3;
}

if (isset($_GET['profileOwnerID'])) {
    $_SESSION['profileOwnerID'] = $_GET['profileOwnerID'];
    $ProfileOwnerid = $_GET['profileOwnerID'];
}

if (isset($_POST['btn-view-profile'])) {
    $_SESSION['profileOwnerID'] = $_POST['friend-id'];
    $ProfileOwnerid = $_POST['friend-id'];
}

if (isset($_POST['redirect'])) {
    $ProfileOwnerid = $_POST['id'];
    $_SESSION['profileOwnerID'] = $_POST['id'];
    header("Location: ../viewer/profile.php");
}


$u1 = new user();
$p1 = new post();
$f1 = new friend();

$themeResult = $u1->getTheme($id);

$result = $u1->read($ProfileOwnerid);
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
        $coverPhoto = $value['cover'];
    }
}

$facebook = "#";
$twitter = "#";
$instgram = "#";
$linkedin = "#";
$googleplus = "#";
$l1 = new userLinks();
$LinksResult = $l1->read($ProfileOwnerid);
if (is_array($LinksResult) || is_object($LinksResult)) {
    foreach ($LinksResult as $value) {
        $facebook = $value['facebook'];
        $twitter = $value['twitter'];
        $instgram = $value['instgram'];
        $linkedin = $value['linkedin'];
        $googleplus = $value['googleplus'];
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Profile</title>
        <script src="../../js/jquery-3.2.1.min.js"></script>
        <script src="../../js/sweetalert2.min.js"></script>
        <script src="../../js/getlocation.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCzdpGWJV2ahuUCfJnQo5VGYtJAB90Zea4&callback=initMap" async defer></script>
        <link rel="stylesheet" href="../../css/sweetalert2.min.css">

        <?php
        if ($themeResult == 0) {
            echo "<link rel='stylesheet' href='../../css/profile-light.css'>";
            echo "<link rel='stylesheet' href='../../css/post-light.css'>";
            echo "<link rel='stylesheet' href='../../css/light-navbar.css'>";
        } else if ($themeResult == 1) {
            echo "<link rel='stylesheet' href='../../css/profile.css'>";
            echo "<link rel='stylesheet' href='../../css/navbar.css'>";
            echo "<link rel='stylesheet' href='../../css/post.css'>";
        }
        ?>

    </head>

    <body>
        <?php
        include 'navbar.php';
        ?>

        <div class="header">
            <img src="<?php echo $coverPhoto; ?>" class="cover-photo">
            <img src="<?php echo $profilePhoto; ?>" class="profile-picture">
            <p class="profle-name"><a href="profile.php"><?php echo $firstName . " " . $lastName ?></a></p>
        </div>

        <!-- ------------------ Start MyInfo ------------------ -->

        <div class="my-info">
            <div class="info-title">About</div>
            <p class="general-info"><span>Birthdate</span> : <?php echo $birthdate ?></p>
            <p class="general-info"><span>Mobile</span> : <?php echo $mobile ?></p>
            <p class="general-info"><span>Work:</span> <?php echo $work ?></p>

            <?php
            $relation = $f1->get_Friend_Relation($id, $ProfileOwnerid);
            if ($relation == 1 || $relation==-1) {
                echo "<div class='profile-progress'>
                <p>IMAGES</p>
                </div>";
            }
            ?>
            <center><div class="social-media">
                    <a href="<?php echo $facebook ?>"><img src="../../images/facebook.png" title="Facebook !"></a>
                    <a href="<?php echo $twitter ?>"><img src="../../images/twitter.png" title="Twitter !"></a>
                    <a href="<?php echo $instgram ?>"><img src="../../images/instagram.png" title="Instgram !"></a>
                    <a href="<?php echo $linkedin ?>"><img src="../../images/linkedin.png" title="Linkedin !"></a>
                    <a href="<?php echo $googleplus ?>"><img src="../../images/google-plus.png" title="Google+ !"></a>
                </div></center>

            <center>
                <div class="info-menu">
                    <div onclick="redirectSettings()"><p><img src="../../images/settings.png">Settings</p></div>
                    <div onclick="redirectSavedItems()"><p><img src="../../images/star.png">Saved Items</p></div>
                    <div onclick="redirectIndex()"><p><img src="../../images/exit.png">Logout</p></div>
                </div>
            </center>

            <center>
                <div class="down-arrow-menu">
                    <img class="down-arrow-menu-img" src="../../images/down-arrow.png">
                </div>
            </center> 
        </div>

        <div class="my-buttons">
            <form method="post" action="../controller/profile_controller.php">
                <input type="hidden" name="myid" value="<?php echo $id; ?>">
                <input type="hidden" name="ProfileOwnerid" value="<?php echo $ProfileOwnerid; ?>">
                <?php
                $relation = $f1->get_Friend_Relation($id, $ProfileOwnerid);
                if ($relation == 0) {//not friends
                    ?>
                    <button class="btn-remove" name="btn-add">Add</button>
                    <button class="btn-message" name="btn-message">Message</button>

                    <?php
                } else if ($relation == 1) {//friends
                    ?>
                    <button class="btn-remove" name="btn-remove">Remove</button>
                    <button class="btn-message" name="btn-message">Message</button>


                    <?php
                } else if ($relation == 2) {//sender request
                    ?>
                    <button class="btn-accept" name="btn-Cancel">Cancel</button>
                    <button class="btn-remove" name="btn-remove">Message</button>
                    <?php
                } else if ($relation == 3) {//receiving request
                    ?>
                    <button class="btn-accept" name="btn-accept">Accept</button>
                    <button class="btn-remove" name="btn-remove">Remove</button>
                    <?php
                }
                ?>
            </form>
        </div>
        <!-- ------------------ End MyInfo ------------------ -->

        <!-- ------------------ Start Write Post ----------------- -->
        <?php
        $x = 0;
        if ($relation == 1 || $id == $ProfileOwnerid) {
            $top = "150px";
            if ($ProfileOwnerid == $id) {
                $top = "335px";
                echo "<div class='write-post'>
            <form method='post' action='../controller/post-controller.php'>
                <input type='hidden' name='id' value='$id'>
                <input type='hidden' name='from' value='profile'>
                <textarea required name='content' class='txt-post' placeholder='Enter your post here..'></textarea>
                <button onclick='document.getElementById('fileUpload').click()' class='uploadImage'>Upload Image</button>
                <input type='file' id='fileUpload' name='files' style='display:none'>
                <button name='btn-post' class='btn-post'>Post</button>
            </form>
        </div>";
            }

            //<!-- ------------------ End Write Post ----------------- -->
            //<!-- ------------------ Start Post ------------------ -->

            $page = "profile";
            $postsResult = $p1->read($ProfileOwnerid);
            require 'post-viewer.php';



            //<!-- ------------------ End Post ------------------ -->
        }
        ?>
        <!-- ------------------ Start actions ------------------ -->

        <?php
        include 'actions.php';
        ?>

        <!-- ------------------ End actions ------------------ -->


        <!-- ------------------ Start owner ------------------ -->

        <div class="owner">
            <h1>CONNECT</h1>
            <p>All rights reserved 2017 &copy;</p>
        </div>

        <!-- ------------------ End owner ------------------ -->

        <div class="go-top"><span>UP</span></div>

        <script src="../../js/jquery.nicescroll.js"></script>
        <script src="../../js/jquery.smooth-scroll.min.js"></script>
        <script src="../../js/profile.js"></script>
        <script src="../../js/post.js"></script>
        <script src="../../js/navbar.js"></script>
        <script src="../../js/scroll-light.js"></script>
    </body> 
</html>