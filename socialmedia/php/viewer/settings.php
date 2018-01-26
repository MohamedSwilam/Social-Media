<?php
session_start();
if ($_SESSION['login'] == FALSE) {
    $_SESSION['result'] = 9;
    header("Location: ../viewer/index.php");
}
if (isset($_SESSION['userID']) && !empty($_SESSION['userID'])) {
    $id = $_SESSION['userID'];
} else {
    header("Location: ../viewer/index.php");
}
if (isset($_SESSION['userID']) && !empty($_SESSION['userID'])) {

    $updateresult = $_SESSION['result'];
} else {
    $updateresult = 3;
}

require_once '../model/user.php';
require_once '../model/userLinks.php';
$user1 = new user();
$result = $user1->read($id);

$themeResult = $user1->getTheme($id);
if (is_array($result) || is_object($result)) {
    foreach ($result as $value) {
        $firstName = $value['fname'];
        $lastName = $value['lname'];
        $mobile = $value['mobile'];
        $password = $value['password'];
        $birthdate = $value['birthdate'];
        $work = $value['work'];
        $profilePhoto = $value['profile'];
        $coverPhoto = $value['cover'];
    }
}
$_SESSION['password2'] = $password;
$user2 = new userLinks();
$resultt = $user2->read($id);
$empty = 0;
if (is_array($resultt) || is_object($resultt)) {
    foreach ($resultt as $value) {
        $empty = 1;
        $facebooklink = $value['facebook'];
        $twitterlink = $value['twitter'];
        $instagramlink = $value['instgram'];
        $linkedinlink = $value['linkedin'];
        $googlepluslink = $value['googleplus'];
    }
}
if ($empty == 0) {
    $facebooklink = "";
    $twitterlink = "";
    $instagramlink = "";
    $linkedinlink = "";
    $googlepluslink = "";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Settings</title>
        <link rel="stylesheet" href="../../css/sweetalert2.min.css">
        <script src="../../js/sweetalert2.min.js"></script>
<?php
if ($themeResult == 0) {
    echo "<link rel='stylesheet' href='../../css/settings-light.css'>";
    echo "<link rel='stylesheet' href='../../css/light-navbar.css'>";
} else if ($themeResult == 1) {
    echo "<link rel='stylesheet' href='../../css/settings.css'>";
    echo "<link rel='stylesheet' href='../../css/navbar.css'>";
}
?>

    </head>
    <body>
        <?php
        include './navbar.php';
        ?>


        <div class="personal-info">
            <img src="../../images/personal-info.png">
            <p>personal Information</p>
            <img class="arrowOpen personal-info-arrow" src="../../images/angle-arrow-down.png">
        </div>
        <div class="personal-info-form">
            <form method="post" action="../controller/update.php">
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <div>
                    <label class="lbl lbl-fname">First Name: </label>
                    <input type="text" name="firstname" class="input fname" placeholder="First Name" value="<?php echo $firstName ?>" required>
                </div>
                <div>
                    <label class="lbl lbl-lname">Last Name: </label>
                    <input type="text" name="lastname" class="input lname" placeholder="Last Name" value="<?php echo $lastName ?>" required>
                </div>
                <div>
                    <label class="lbl lbl-mobile">Mobile: </label>
                    <input type="number" name="mobile" class="input mobile" placeholder="Mobile" value="<?php echo $mobile ?>" required>
                </div>

                <div>  
                    <label class="lbl lbl-birthdate">Birthdate: </label>
                    <input type="date" name="birthdate" class="input birthdate" value="<?php echo $birthdate ?>" required>
                </div>

                <label class="lbl lbl-Work">Work: </label>
                <input type="text" name="work" class="input work" placeholder="Work title" value="<?php echo $work ?>" required>

                <button class="btn-update" name="btn-update">Save Changes</button>
            </form>
        </div>

        <div class="links-info">
            <img src="../../images/unlink.png">
            <p>Link Accounts</p>
            <img class="arrowOpen link-accounts-arrow" src="../../images/angle-arrow-down.png">
        </div>
        <div class="links-info-form">
            <form method="post" action="../controller/update.php">
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <div>
                    <label class="lbl lbl-facebook">Facebook: </label>
                    <input type="text" class="input facebook" placeholder="Facebook"  name="facebookLink" value="<?php echo $facebooklink ?>" required>
                </div>
                <div>
                    <label class="lbl lbl-twitter">Twitter: </label>
                    <input type="text" class="input twitter" placeholder="Twitter" name="twitterLink" value="<?php echo $twitterlink ?>" required>
                </div>
                <div>
                    <label class="lbl lbl-instgram">Instgram: </label>
                    <input type="text" class="input instgram" placeholder="Instgram" name="instagramLink" value="<?php echo $instagramlink ?>" required>
                </div>
                <div>
                    <label class="lbl lbl-linkedin">Linkedin: </label>
                    <input type="text" class="input linkedin" placeholder="Linkedin" name="linkedinLink" value="<?php echo $linkedinlink ?>" required>
                </div>

                <label class="lbl lbl-google">Google+: </label>
                <input type="text" class="input google+" placeholder="Google+" name="googleplusLink" value="<?php echo $googlepluslink ?>" required>

                <button class="btn-update" name="btn-updateLinks">Save Changes</button>
            </form>
        </div> 

        <div class="pic-info">
            <img src="../../images/user-avatar-main-picture.png">
            <p>Profile picture & Cover photo</p>
            <img class="arrowOpen pic-info-arrow" src="../../images/angle-arrow-down.png">
        </div>
        <div class="pic-info-form">
            <div style="display: inline;" class="cover-photo-div">
                <img class="cover-photo-img" src="<?php echo $coverPhoto; ?>">
            </div>
            <div style="display: inline;" class="profile-pic-div">
                <img class="profile-pic" src="<?php echo $profilePhoto; ?>">
            </div>
            <button onclick="document.getElementById('profile-img').click()" id="profile-upload" class="upload-img">Update Profile Picture</button>
            <button onclick="document.getElementById('cover-img').click()" id="cover-upload" class="upload-img">Update Cover Photo</button>
            <form method="post" action="../controller/update.php" enctype="multipart/form-data">
                <input type="file" id="profile-img" name="profilePhoto" accept="image/*" style="display: none;">
                <input type="file" id="cover-img" name="coverPhoto" accept="image/*" style="display: none;">
                <input type="hidden" class="profile-check" name="profile" value="no">
                <input type="hidden" class="cover-check" name="cover" value="no">
                <button class="btn-update" name="submit-coverPhoto">Save Changes</button>
            </form>
        </div>

        <div class="password-info">
            <img src="../../images/lock.png">
            <p>Change password</p>
            <img class="arrowOpen password-info-arrow" src="../../images/angle-arrow-down.png">
        </div>
        <div class="password-info-form">
            <form method="post" action="../controller/update.php">
                <div>
                    <label class="lbl lbl-password">Current password: </label>
                    <input type="password" name="old-password" class="input password1" placeholder="Current Password" required>
                </div>
                <div>
                    <label class="lbl lbl-password">New password: </label>
                    <input type="password" name="new-password" class="input password2" placeholder="New password"  required>
                </div>
                <div>
                    <label class="lbl lbl-password">Confirm password: </label>
                    <input type="password" name="confirm" class="input password3" placeholder="Confirm new password" required>
                </div>

                <button class="btn-save" name="btn-save">Save Changes</button>
            </form>
        </div>

        <div class="theme-info">
            <img src="../../images/image.png">
            <p>Change Theme</p>
            <img class="arrowOpen theme-info-arrow" src="../../images/angle-arrow-down.png">
        </div>
        <div class="theme-info-form">
            <form method="post" action="../controller/update.php">
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <button name="btn-light" class="light-theme">Light Theme</button>
                <button name="btn-dark" class="dark-theme">Dark Theme</button>
            </form>
        </div>

        <div class="map-info">
            <img src="../../images/map.png">
            <p>Map settings</p>
            <img class="arrowOpen map-info-arrow" src="../../images/angle-arrow-down.png">
        </div>

        <div class="map-info-form">
            <form method="post" action="../controller/update.php">
                <input type="hidden" name="id" value="<?php echo $id ?>"> 
                <label class="map-approval">Map approval</label><br>
                <label class="lbl-yes">Yes</label>
                <label class="lbl-no">No</label><br>
                <input type="radio" name="check" value="yes" >
                <input type="radio" name="check" value="no" >
                <button name="btn-map">Save Changes</button>

            </form>
        </div>
        <div class="delete-acc">
            <img src="../../images/delete.png">
            <p>Delete account</p>
            <img class="arrowOpen delete-acc-arrow" src="../../images/angle-arrow-down.png">
        </div>
        
        <div class="delete-acc-form">
            <form method="post" action="../controller/update.php">
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <button name="btn-d">Delete account</button>
            </form>
        </div>
      
<?php
if ($updateresult == 1) {
    $_SESSION['result'] = 3;
    ?>
            <script>swal('Done', 'Data Successfully Updated!', 'success');</script>
            <?php
        } else if ($updateresult == 0) {
            $_SESSION['result'] = 3;
            ?>
            <script>swal('Oops...', 'Failed to update the data!', 'error');</script>
            <?php
        } else if ($updateresult == 5) {
            $_SESSION['result'] = 3;
            ?>
            <script>swal('Done', 'Data Successfully Updated!', 'success');</script>
            <?php
        } else if ($updateresult == 6) {
            $_SESSION['result'] = 3;
            ?>
            <script>swal('Oops...', 'Failed to update the data!', 'error');</script>
            <?php
        } else if ($updateresult == 7) {
            $_SESSION['result'] = 3;
            ?>
            <script>swal('Oops...', 'Wrong Password!', 'error');</script>
            <?php
        } else if ($updateresult == 8) {
            $_SESSION['result'] = 3;
            ?>
            <script>swal('Oops...', 'The passwords entered are not matched!', 'error');</script>
            <?php
        } else if ($updateresult == 9) {
            $_SESSION['result'] = 3;
            ?>
            <script>swal('Done', 'Password Successfully Updated', 'success');</script>
            <?php
        } else if ($updateresult == 10) {
            $_SESSION['result'] = 3;
            ?>
            <script>swal('Oops...', 'Failed to update the Password!', 'error');</script>
            <?php
        } else if ($updateresult == 11) {
            $_SESSION['result'] = 3;
            ?>
            <script>swal('Oops...', 'No Photos Uploaded!', 'error');</script>
            <?php
        } else if ($updateresult == 12) {
            $_SESSION['result'] = 3;
            ?>
            <script>swal('Done', 'Profile Picture Successfully Updated', 'success');</script>
            <?php
        } else if ($updateresult == 13 || $updateresult == 14) {
            $_SESSION['result'] = 3;
            ?>
            <script>swal('Oops...', 'Failed to Upload Profile Picture!', 'error');</script>
            <?php
        } else if ($updateresult == 15) {
            $_SESSION['result'] = 3;
            ?>
            <script>swal('Done', 'Cover Photo Successfully Updated', 'success');</script>
            <?php
        } else if ($updateresult == 16 || $updateresult == 17) {
            $_SESSION['result'] = 3;
            ?>
            <script>swal('Oops...', 'Failed to Upload Cover Photo!', 'error');</script>
            <?php
        }
        ?>


        <script src="../../js/jquery-3.2.1.min.js"></script>
        <script src="../../js/jquery.nicescroll.js"></script>
        <script src="../../js/settings.js"></script>
        <script src="../../js/navbar.js"></script>
        <script src="../../js/scroll-light.js"></script>

    </body>
</html>