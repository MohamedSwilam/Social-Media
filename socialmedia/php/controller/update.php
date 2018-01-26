<?php

session_start();
require_once '../model/user.php';
require_once '../model/userLinks.php';

$u1 = new user();

if (isset($_POST['btn-update'])) {
    $id = $_POST['id'];
    $firstName = $_POST['firstname'];
    $lastName = $_POST['lastname'];
    $mobile = $_POST['mobile'];
    $birthdate = $_POST['birthdate'];
    $work = $_POST['work'];
    $data = array($id, $firstName, $lastName, $mobile, $birthdate, $work, "");
    $result = $u1->update($data);

    if ($result == 1) {
        $_SESSION['userID'] = $id;
        $_SESSION['result'] = 1;
        header("Location: ../viewer/settings.php");
    } else if ($result == 0) {
        $_SESSION['userID'] = $id;
        $_SESSION['result'] = 0;
        header("Location: ../viewer/settings.php");
    }
}

if (isset($_POST['btn-updateLinks'])) {

    $facebookLink = $_POST['facebookLink'];
    $twitterLink = $_POST['twitterLink'];
    $instagramLink = $_POST['instagramLink'];
    $linkedinLink = $_POST['linkedinLink'];
    $googleplusLink = $_POST['googleplusLink'];
    $id = $_POST['id'];

    $user2 = new userLinks();
    $resultt = $user2->read($id);
    $empty = 0;
    foreach ($resultt as $value) {
        $empty = 1;
        $data = array($id, $facebookLink, $twitterLink, $instagramLink, $linkedinLink, $googleplusLink);
        $result = $user2->update($data);
        if ($result == 1) {
            $_SESSION['userID'] = $id;
            $_SESSION['result'] = 5;
            header("Location: ../viewer/settings.php");
        } else if ($result == 0) {
            $_SESSION['userID'] = $id;
            $_SESSION['result'] = 6;
            header("Location: ../viewer/settings.php");
        }
    }
    if ($empty == 0) {
        //create
        $data = array($id, $facebookLink, $twitterLink, $instagramLink, $linkedinLink, $googleplusLink);
        $result = $user2->create($data);

        if ($result == 1) {
            $_SESSION['userID'] = $id;
            $_SESSION['result'] = 1;
            header("Location: ../viewer/settings.php");
        } else if ($result == 0) {
            $_SESSION['userID'] = $id;
            $_SESSION['result'] = 0;
            header("Location: ../viewer/settings.php");
        }
    }
}

if (isset($_POST['submit-coverPhoto'])) {
    $profilePhoto = $_FILES['profilePhoto'];
    $coverPhoto = $_FILES['coverPhoto'];
    $profileChange = $_POST['profile'];
    $coverChange = $_POST['cover'];
    $id = $_SESSION['userID'];
    $result = 11; //no change

    if ($profileChange == "yes") {
        $extensionProfile = pathinfo($profilePhoto['name'], PATHINFO_EXTENSION);
        $destinationProfile = "../../images/profilephotos/" . uniqid() . "." . $extensionProfile;
        if (move_uploaded_file($profilePhoto['tmp_name'], $destinationProfile)) {
            $result = $u1->update_photo($id, $destinationProfile, "profile");
            if ($result == 1) {
                $result = 12; // DONE
            } else {
                $result = 13; //Failed
            }
        } else {
            $result = 14; //failed
        }
    }
    if ($result == 11 || $result == 12) {
        if ($coverChange == "yes") {
            $extensionCover = pathinfo($coverPhoto['name'], PATHINFO_EXTENSION);
            $destinationCover = "../../images/coverphotos/" . uniqid() . "." . $extensionCover;
            if (move_uploaded_file($coverPhoto['tmp_name'], $destinationCover)) {
                $result = $u1->update_photo($id, $destinationCover, "cover");
                if ($result == 1) {
                    $result = 15; //DONE
                } else {
                    $result = 16; //Failed
                }
            } else {
                $result = 17; //failed
            }
        }
    }
    $_SESSION['result'] = $result; //Not matched
    header("Location: ../viewer/settings.php");
}

if (isset($_POST['btn-save'])) {
    $truepassword = $_SESSION['password2'];
    $id = $_SESSION['userID'];
    $oldPassword = sha1($_POST['old-password']);
    $newPassword = $_POST['new-password'];
    $confirm = $_POST['confirm'];
    if ($truepassword != $oldPassword) {
        $_SESSION['result'] = 7; //Wrong Password
        header("Location: ../viewer/settings.php");
    } else if ($newPassword != $confirm) {
        $_SESSION['result'] = 8; //Not matched
        header("Location: ../viewer/settings.php");
    } else {
        $result = $u1->updatePassword($id, $newPassword);
        if ($result == 1) {
            $_SESSION['result'] = 9; //DONE
            header("Location: ../viewer/settings.php");
        } else {
            $_SESSION['result'] = 10; //Failed
            header("Location: ../viewer/settings.php");
        }
    }
}

if (isset($_POST['btn-light'])) {
    $id = $_POST['id'];
    $u1->setTheme($id, "light");
    $_SESSION['userID'] = $id;
    $_SESSION['result'] = 3;
    header("Location: ../viewer/settings.php");
}

if (isset($_POST['btn-dark'])) {
    $id = $_POST['id'];
    $u1->setTheme($id, "dark");
    $_SESSION['userID'] = $id;
    $_SESSION['result'] = 3;
    header("Location: ../viewer/settings.php");
}

if (isset($_POST['btn-map'])){
    $id = $_POST['id'];
    $check = $_POST['check'];
    $u1->udateMap($id, $check);
    $_SESSION['userID'] = $id;
    $_SESSION['result'] = 3;
    header("Location: ../viewer/settings.php");
}

if (isset($_POST['btn-d'])) {
    $id = $_POST['id'];
    $data = array($id);
    $u1->delete($data);

    header("Location: ../viewer/index.php");
}
?>
