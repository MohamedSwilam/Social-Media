<?php
session_start();
if ($_SESSION['login'] == FALSE) {
    $_SESSION['result'] = 9;
    header("Location: ../viewer/index.php");
}
require_once '../model/user.php';
require_once '../model/friend.php';
require_once '../model/userLinks.php';
$ID = $_SESSION['userID'];

$user1 = new user();
$u1 = new user();
$f = new friend();
$links = new userLinks();
$themeResult = $user1->getTheme($ID);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>friends</title>
        <link rel="stylesheet" href="../../css/sweetalert2.min.css">
        <?php
        if ($themeResult == 0) {
            echo "<link rel='stylesheet' href='../../css/friends-light.css'>";
            echo "<link rel='stylesheet' href='../../css/light-navbar.css'>";
            echo "<link rel='stylesheet' href='../../css/myinfo-light.css'>";
        } else if ($themeResult == 1) {
            echo "<link rel='stylesheet' href='../../css/friends.css'>";
            echo "<link rel='stylesheet' href='../../css/navbar.css'>";
            echo "<link rel='stylesheet' href='../../css/myinfo.css'>";
        }
        ?>
    </head>

    <body>
        <!-- ******************* Start Navbar ******************** -->
        <?php
        include 'navbar.php';
        include 'myinfo.php';
        ?>

        <!-- ******************* End Navbar ******************** -->

    <center>
        <div class="friend-requests">
            <fieldset>
                <legend>Friend Requests</legend>
                <?php
                $result = $f->read($ID);
                if (!empty($result)) {
                    foreach ($result as $value) {
                        if ($value['relation'] == "gr") {
                            $id = $value['friendID'];
                            $result2 = $user1->read($id);
                            $result5 = $links->read($id);
                            if (is_array($result5) || is_object($result)) {
                                foreach ($result5 as $value) {
                                    $facebook = $value['facebook'];
                                    $twitter = $value['twitter'];
                                    $instgram = $value['instgram'];
                                    $linkedin = $value['linkedin'];
                                    $googleplus = $value['googleplus'];
                                }
                            } else {
                                $facebook = "#";
                                $twitter = "#";
                                $instgram = "#";
                                $linkedin = "#";
                                $googleplus = "#";
                            }
                            foreach ($result2 as $value) {
                                $userid = $value['id'];
                                $firstName = $value['fname'];
                                $lastName = $value['lname'];
                                $mobile = $value['mobile'];
                                $password = $value['password'];
                                $birthdate = $value['birthdate'];
                                $work = $value['work'];
                                $profile = $value['profile'];
                                $cover = $value['cover'];

                                echo "<div class='card'>
                                        <div class='front'>
                                            <center>
                                            <img class='card-cover' src='$cover'>
                                            <img class ='card-img' src='$profile'>
                                                <p class='card-name'>
                                                    " . $firstName . " " . $lastName . "
                                                </p>
                                                <p class='job'>$work</p>
                                            </center>                
                                        </div>
                                        <div class='back'>
                                        <form method='post' action='profile.php'>
                                           <input type='hidden' name='friend-id' value='$id'>
                                            <button class='btn-view-profile' name='btn-view-profile' >View Profile</button>
                                     </form>
                                          
                                            <div class='social-media' style='border: none'>
                                               <a href='$facebook'><img src='../../images/facebook.png' title='Facebook !'></a>
                                               <a href='$twitter'><img src='../../images/twitter.png' title='Twitter !'></a>
                                               <a href='$instgram'><img src='../../images/instagram.png' title='Instgram !'></a>
                                               <a href='$linkedin'><img src='../../images/linkedin.png' title='Linkedin !'></a>
                                               <a href='$googleplus'><img src='../../images/google-plus.png' title='Google+ !'></a>
                                                </div>
                                                <form method='post' action='../controller/friends_actions.php'>
                                                <input type='hidden' name='id' value='$userid'>
                                                <input type='hidden' name='myid' value='$ID'>
                                                <button class='btn-accept' name='btn-accept'>Accept</button><button class='btn-remove' name='btn-remove' >Remove</button>
                                            </form>
                                        </div>
                                    </div>";
                            }
                        }
                    }
                }
                ?>
            </fieldset>
        </div>

        <div class="suggestions">
            <fieldset>
                <legend>Suggestions</legend>
                <?php
                $Suggestions_number = 0;
                $result = $f->read_Rand_For_Suggestions();
                if (!empty($result)) {
                    foreach ($result as $value) {
                        $id = $value['id'];
                        $relation = $f->get_Friend_Relation($ID, $id);
                        if ($Suggestions_number < 3) {
                            if ($relation == 0) {
                                $result4 = $user1->read($id);
                                $result5 = $links->read($id);
                                if (is_array($result5) || is_object($result)) {
                                    foreach ($result5 as $value) {
                                        $facebook = $value['facebook'];
                                        $twitter = $value['twitter'];
                                        $instgram = $value['instgram'];
                                        $linkedin = $value['linkedin'];
                                        $googleplus = $value['googleplus'];
                                    }
                                } else {
                                    $facebook = "#";
                                    $twitter = "#";
                                    $instgram = "#";
                                    $linkedin = "#";
                                    $googleplus = "#";
                                }


                                $Suggestions_number++;
                                foreach ($result4 as $value) {


                                    $firstName = $value['fname'];
                                    $lastName = $value['lname'];
                                    $userid = $value['id'];
                                    $work = $value['work'];
                                    $profile = $value['profile'];
                                    $cover = $value['cover'];

                                    echo "<div class='card'>
                                    <div class='front'>
                                       <center>
                                       <img class='card-cover' src='$cover'>
                                       <img class ='card-img' src='$profile'>
                                           <p class='card-name'>" . $firstName . " " . $lastName . "</p>
                                           <p class='job'>" . $work . "</p>
                                       </center>                
                                   </div>
                                   <div class='back'>
                                    <form method='post' action='profile.php'>
                                           <input type='hidden' name='friend-id' value='$id'>
                                            <button class='btn-view-profile' name='btn-view-profile' >View Profile</button>
                                     </form>
                                      
                                       <div class='social-media' style='border: none'>
                                               <a href='$facebook'><img src='../../images/facebook.png' title='Facebook !'></a>
                                               <a href='$twitter'><img src='../../images/twitter.png' title='Twitter !'></a>
                                               <a href='$instgram'><img src='../../images/instagram.png' title='Instgram !'></a>
                                               <a href='$linkedin'><img src='../../images/linkedin.png' title='Linkedin !'></a>
                                               <a href='$googleplus'><img src='../../images/google-plus.png' title='Google+ !'></a>
                                           </div>
                                               <form method='post' action='../controller/friends_actions.php'>
                                                    <input type='hidden' name='id' value='$userid'>
                                                    <input type='hidden' name='myid' value='$ID'>
                                                    <button class='btn-connect' name='btn-connect'>Connect</button>
                                                    </form>
                                   </div>
                               </div>";
                                }
                            }
                        }
                    }
                }
                ?>


            </fieldset>
        </div>

        <div class="friends-list">
            <fieldset>
                <legend>Friends List</legend>
                <?php
                $result = $f->read($ID);
                $fc=1;
                if (is_array($result) || is_object($result)) {
                    foreach ($result as $value) {
                        $fcid="f".$fc;
                        $id = $value['friendID'];
                        if ($value['relation'] == "f") {
                            $result2 = $user1->read($id);
                            $result5 = $links->read($id);
                            if (is_array($result5) || is_object($result)) {
                                foreach ($result5 as $value) {
                                    $facebook = $value['facebook'];
                                    $twitter = $value['twitter'];
                                    $instgram = $value['instgram'];
                                    $linkedin = $value['linkedin'];
                                    $googleplus = $value['googleplus'];
                                }
                            } else {
                                $facebook = "#";
                                $twitter = "#";
                                $instgram = "#";
                                $linkedin = "#";
                                $googleplus = "#";
                            }
                            foreach ($result2 as $value) {
                                $firstName = $value['fname'];
                                $lastName = $value['lname'];
                                $mobile = $value['mobile'];
                                $password = $value['password'];
                                $birthdate = $value['birthdate'];
                                $work = $value['work'];
                                $profile = $value['profile'];
                                $cover = $value['cover'];
                                echo "<div class='card'>
                                        <div class='front'>
                                            <center>
                                            <img class='card-cover' src='$cover'>
                                            <img class ='card-img' src='$profile'>
                                            <p class='card-name'>" . $firstName . " " . $lastName . "</p>
                                            <p class='job'>" . $work . "</p>
                                            </center>                
                                        </div>
                                        <div class='back'>
                                            <form method='post' action='profile.php'>
                                                <input type='hidden' name='friend-id' value='$id'>
                                                <button name='btn-view-profile' class='btn-view-profile' >View Profile</button>
                                            </form>
                                            <div class='social-media' style='border: none'>
                                               <a href='$facebook'><img src='../../images/facebook.png' title='Facebook !'></a>
                                               <a href='$twitter'><img src='../../images/twitter.png' title='Twitter !'></a>
                                               <a href='$instgram'><img src='../../images/instagram.png' title='Instgram !'></a>
                                               <a href='$linkedin'><img src='../../images/linkedin.png' title='Linkedin !'></a>
                                               <a href='$googleplus'><img src='../../images/google-plus.png' title='Google+ !'></a>
                                            </div>
                                            <input type='hidden' class='$fcid'  value='$id'>
                                            <button class='btn-message' id='$fcid'>Message</button>
                                        </div>
                                    </div>";
                            }
                        }
                        $fc++;
                    }
                }
                ?>
               
            </fieldset>
        </div>
    </center>

    <script src="../../js/jquery-3.2.1.min.js"></script>
    <script src="../../js/sweetalert2.min.js"></script>
    <script src="../../js/jquery.nicescroll.js"></script>
    <script src="../../js/friends.js"></script>
    <script src="../../js/navbar.js"></script>
    <script src="../../js/myinfo.js"></script>
    <script src="../../js/scroll-light.js"></script>
</body>
</html>
