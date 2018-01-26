<?php
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
?>
<div class="my-info">
    <center><img class="my-info-img" src="<?php echo $profilePhoto; ?>" width="100px" height="100px" style="border-radius: 50px;"></center>
    <hr class="hr1">
    <div class="info-title"><a class="info-name" href="Profile.php?profileOwnerID=<?php echo $id; ?>"><?php echo $firstName . " " . $lastName; ?></a><p class="info-job"><?php echo $work; ?></p></div>

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