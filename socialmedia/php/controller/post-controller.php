<?php

session_start();
require_once '../model/post.php';
require_once '../model/notification.php';

if (isset($_POST['btn-post'])) {
    $content = $_POST['content'];
    $owner = $_POST['id'];
    $from = $_POST['from'];
    $userID = $owner;
    $time = time();
    $date = date("d-m-y h:i:s a");
    $test = "unused";
    $postID = "same";
    $postOwnerID = "same";
    $longitude = "-";
    $latitude = "-";
    $parameter10 = "-";
    $img = $_FILES['img'];

    $extension = pathinfo($img['name'], PATHINFO_EXTENSION);
    $des = "../../images/posts/" . uniqid() . "." . $extension;

    if (move_uploaded_file($img['tmp_name'], $des)) {
        echo "<img src='$des'>";
    } else {
        $des = "no";
    }

    $p1 = new post();
    $data = array($content, $des, $owner, $date, $userID, $time, $postOwnerID, $longitude, $latitude, "post");
    $result = $p1->create($data);

    if ($result == 1) {
        $_SESSION['actionpostresult'] = 1;
    } else if ($result == 0) {
        $_SESSION['actionpostresult'] = 0;
    }
    $_SESSION['userID'] = $userID;
    if ($from == "home") {
        header("Location: ../viewer/home.php");
    } else if ($from == "save") {
        header("Location: ../viewer/saved-items.php");
    } else if ($from == "notification") {
        header("Location: ../viewer/notification-post.php");
    } else {
        header("Location: ../viewer/profile.php");
    }
}

if (isset($_POST['btn-location'])) {
    $content = $_POST['content'];
    $owner = $_POST['id'];
    $from = $_POST['from'];
    $userID = $owner;
    $time = time();
    $date = date("d-m-y h:i:s a");
    $test = "unused";
    $postID = "same";
    $postOwnerID = "same";
    $long = $_POST['long'];
    $lat = $_POST['lat'];

    $p1 = new post();
    $data = array($content, "no", $owner, $date, $userID, $time, $postOwnerID, $long, $lat, "post");
    $result = $p1->create($data);

    if ($result == 1) {
        $_SESSION['actionpostresult'] = 1;
    } else if ($result == 0) {
        $_SESSION['actionpostresult'] = 0;
    }
    $_SESSION['userID'] = $userID;
    if ($from == "home") {
        header("Location: ../viewer/home.php");
    } else if ($from == "save") {
        header("Location: ../viewer/saved-items.php");
    } else if ($from == "notification") {
        header("Location: ../viewer/notification-post.php");
    } else {
        header("Location: ../viewer/profile.php");
    }
}

if (isset($_POST['btn-like'])) {
    $date = date("d-m-y h:i:s a");
    $postCounter = $_POST['postCounter'];
    $fromSave = $postCounter . "saveFrom";
    $ownerpostIDSave = $postCounter . "saveOwnerPostID";
    $postIDSave = $postCounter . "savePostID";
    $dateSave = $postCounter . "saveDate";
    $idSave = $postCounter . "saveID";
    $postUserIDSave = $postCounter . "savePostUserID";

    $userID2 = $_SESSION[$postUserIDSave];
    $from = $_SESSION[$fromSave];
    $postID = $_SESSION[$postIDSave];
    $postOwnerID = $_SESSION[$ownerpostIDSave];
    $userID = $_SESSION[$idSave];

    $p1 = new post();

    if ($p1->checkLike($postID, $userID) == FALSE) {
        $result = $p1->addLike($postID, $userID, $postOwnerID, $date, $userID2);

        if ($result == 1) {
            $_SESSION['actionpostresult'] = 5; //like submitted
        } else if ($result == 0) {
            $_SESSION['actionpostresult'] = 4; //failed to submit the like
        }
    } else {
        //removeLike
        $result = $p1->removeLike($postID, $userID);

        if ($result == 1) {
            $_SESSION['actionpostresult'] = 6; //like submitted
        } else if ($result == 0) {
            $_SESSION['actionpostresult'] = 7; //failed to submit the like
        }
    }

    $_SESSION['userID'] = $userID;

    if ($from == "home") {
        header("Location: ../viewer/home.php");
    } else if ($from == "save") {
        header("Location: ../viewer/saved-items.php");
    } else if ($from == "notification") {
        header("Location: ../viewer/notification-post.php");
        //echo $_SESSION['actionpostresult'];
    } else {
        header("Location: ../viewer/profile.php");
    }
}

if (isset($_POST['btn-comment'])) {
    $postCounter = $_POST['postCounter'];
    $fromSave = $postCounter . "saveFrom";
    $ownerpostIDSave = $postCounter . "saveOwnerPostID";
    $postIDSave = $postCounter . "savePostID";
    $dateSave = $postCounter . "saveDate";
    $idSave = $postCounter . "saveID";
    $ownerSave = $postCounter . "saveownerID";
    $postUserIDSave = $postCounter . "savePostUserID";
    $userID2=$_SESSION[$postUserIDSave];
    $owner = $_SESSION[$ownerSave];
    $from = $_SESSION[$fromSave];
    $postID = $_SESSION[$postIDSave];
    $postOwnerID = $_SESSION[$ownerpostIDSave];
    $userID = $_SESSION[$idSave];
    $date = date("d-m-y h:i:s a");
    $content = $_POST['comment-content'];

    $p1 = new post();
    $result = $p1->addcomment($postID, $postOwnerID, $userID, $date, $content, $userID2);

    if ($result == 1) {
        $_SESSION['actionpostresult'] = 8;
    } else if ($result == 0) {
        $_SESSION['actionpostresult'] = 9;
    }

    $_SESSION['userID'] = $userID;

    if ($from == "home") {
        header("Location: ../viewer/home.php");
    } else if ($from == "save") {
        header("Location: ../viewer/saved-items.php");
    } else if ($from == "notification") {
        header("Location: ../viewer/notification-post.php");
    } else
        header("Location: ../viewer/profile.php");
}

if (isset($_POST['btn-share'])) {
    $postCounter = $_POST['postCounter'];
    $idSave = $postCounter . "saveID";
    $ownerSave = $postCounter . "saveownerID";
    $fromSave = $postCounter . "saveFrom";
    $postIDSave = $postCounter . "savePostID";
    $ownerpostIDSave = $postCounter . "saveOwnerPostID";
    $contentSave = $postCounter . "saveContent";
    $imgSave = $postCounter . "saveImg";

    $userID = $_SESSION[$idSave];
    $owner = $_SESSION[$ownerSave];
    $from = $_SESSION[$fromSave];
    $postOwnerID = $_SESSION[$ownerpostIDSave];
    $postID = $_SESSION[$postIDSave];
    $content = $_SESSION[$contentSave];
    $img = $_SESSION[$imgSave];
    $longitude = "-";
    $latitude = "-";
    $parameter10 = "-";
    $time = time();
    $date = date("d-m-y h:i:s a");

    $p1 = new post();
    $data = array($content, $img, $owner, $date, $userID, $time, $postOwnerID, $longitude, $latitude);
    $result = $p1->create($data);

    if ($result == 1) {
        $_SESSION['actionpostresult'] = 10;
    } else if ($result == 0) {
        $_SESSION['actionpostresult'] = 11;
    }

    $_SESSION['userID'] = $userID;

    if ($from == "home") {
        header("Location: ../viewer/home.php");
    } else if ($from == "save") {
        header("Location: ../viewer/saved-items.php");
    } else if ($from == "notification") {
        header("Location: ../viewer/notification-post.php");
    } else if ($from == "profile") {
        header("Location: ../viewer/profile.php");
    }
}

if (isset($_POST['btn-save'])) {
    $postCounter = $_POST['postCounter'];
    $idSave = $postCounter . "saveID";
    $fromSave = $postCounter . "saveFrom";
    $ownerpostIDSave = $postCounter . "saveOwnerPostID";

    $from = $_SESSION[$fromSave];
    $id = $_SESSION[$idSave];
    $ownerPostID = $_SESSION[$ownerpostIDSave];
    $p1 = new post();
    if ($p1->checkSavePost($id, $ownerPostID) == FALSE) {
        $result = $p1->savePost($id, $ownerPostID);
        if ($result == 1) {
            $_SESSION['actionpostresult'] = 12;
        } else if ($result == 0) {
            $_SESSION['actionpostresult'] = 13;
        }
    } else {
        $result = $p1->unsavePost($id, $ownerPostID);
        if ($result == 1) {
            $_SESSION['actionpostresult'] = 14;
        } else if ($result == 0) {
            $_SESSION['actionpostresult'] = 15;
        }
    }
    $_SESSION['userID'] = $id;
    //echo $from;
    if ($from == "home") {
        header("Location: ../viewer/home.php");
    } else if ($from == "save") {
        header("Location: ../viewer/saved-items.php");
    } else if ($from == "notification") {
        header("Location: ../viewer/notification-post.php");
    } else if ($from == "profile") {
        header("Location: ../viewer/profile.php");
    }
}

if (isset($_POST['btn-update'])) {
    //postID,Content
    $postCounter = $_POST['postCounter'];
    $newContent = $_POST['editedContent'];
    $ownerpostIDSave = $postCounter . "saveOwnerPostID";
    $contentSave = $postCounter . "saveContent";
    $imgSave = $postCounter . "saveImg";
    $fromSave = $postCounter . "saveFrom";

    $postID = $_SESSION[$ownerpostIDSave];
    $content = $_SESSION[$contentSave];
    $img = $_SESSION[$imgSave];
    $from = $_SESSION[$fromSave];

    if ($img == "no" && $newContent == "") {
        $_SESSION['actionpostresult'] = 18; //empty post
    } else {
        $p1 = new post();
        $data = array($postID, $newContent);
        $result = $p1->update($data);
        if ($result == 1) {
            $_SESSION['actionpostresult'] = 19; //updated
        } else {
            $_SESSION['actionpostresult'] = 20; //failed
        }
    }
    if ($from == "home") {
        header("Location: ../viewer/home.php");
    } else if ($from == "save") {
        header("Location: ../viewer/saved-items.php");
    } else if ($from == "notification") {
        header("Location: ../viewer/notification-post.php");
    } else if ($from == "profile") {
        header("Location: ../viewer/profile.php");
    }
}

if (isset($_POST['btn-delete'])) {
    $postCounter = $_POST['postCounter'];
    $idSave = $postCounter . "saveID";
    $fromSave = $postCounter . "saveFrom";
    $ownerpostIDSave = $postCounter . "saveOwnerPostID";
    $postIDSave = $postCounter . "savePostID";
    $ownerSave = $postCounter . "saveownerID";

    $from = $_SESSION[$fromSave];
    $id = $_SESSION[$idSave];
    $postID = $_SESSION[$postIDSave];
    $owner = $_SESSION[$ownerSave];
    $ownerPostID = $_SESSION[$ownerpostIDSave];

    $p1 = new post();
    $data = array($ownerPostID, $postID, $owner, $id);
    $result = $p1->delete($data);

    if ($result == 1) {
        $_SESSION['actionpostresult'] = 16;
    } else if ($result == 0) {
        $_SESSION['actionpostresult'] = 17;
    }

    if ($from == "home") {
        header("Location: ../viewer/home.php");
    } else if ($from == "save") {
        header("Location: ../viewer/saved-items.php");
    } else if ($from == "notification") {
        header("Location: ../viewer/notification-post.php");
    } else if ($from == "profile") {
        header("Location: ../viewer/profile.php");
    }
}

if(isset($_POST['btn-update-comment'])){
    //postID,Content
    $postCounter=$_POST['postCounter'];
    $fromSave=$postCounter."saveFrom";
    $from=$_SESSION[$fromSave];
    
    $commentID=$_POST['commentID'];
    $newContent=$_POST['editedCommentContent'];
    echo $commentID ,$newContent;
    
    if(empty($newContent)){
        $_SESSION['actionpostresult'] = 18;//empty post
    }else{
        $p1 = new post();
        $data=array($commentID,$newContent);
        $result=$p1->editComment($data);
        if($result==1){
            $_SESSION['actionpostresult'] = 19;//updated
        }else{
            $_SESSION['actionpostresult'] = 20;//failed
        }
    }

   if($from=="home"){
        header("Location: ../viewer/home.php");
    }
    else if($from=="save"){
        header("Location: ../viewer/saved-items.php");
    }
    else if($from=="notification"){
        header("Location: ../viewer/notification-post.php");
    }
    else if($from=="profile"){
        header("Location: ../viewer/profile.php");
    }
}
