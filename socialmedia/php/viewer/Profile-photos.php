<?php 
    session_start();
    if($_SESSION['login']==FALSE){
        $_SESSION['result']=9;
        header("Location: ../viewer/index.php");
    }
    require_once '../model/user.php';
    require_once '../model/post.php';
    
    $id = $_SESSION['userID'];
    
    if(isset($_SESSION['profileOwnerID']) && !empty($_SESSION['profileOwnerID'])) {
        $ProfileOwnerid=$_SESSION['profileOwnerID'];
    }else{
         $ProfileOwnerid=$_SESSION['userID'];;
    }
    
    $u1= new user();
    $p1 = new post();
    $themeResult=$u1->getTheme($id);
    
    $data=$p1->getPhotos($ProfileOwnerid);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Profile</title>
        <link rel="stylesheet" href="../../css/sweetalert2.min.css">
        
        <?php 
            if($themeResult==0){
                echo "<link rel='stylesheet' href='../../css/Profile-photos-light.css'>";
                echo "<link rel='stylesheet' href='../../css/light-navbar.css'>";
            }
            else if($themeResult==1){
                echo "<link rel='stylesheet' href='../../css/Profile-photos.css'>";
                echo "<link rel='stylesheet' href='../../css/navbar.css'>";
            }
        ?>
        
    </head>
    
    <body>
          
        <?php 
        include 'navbar.php';
        ?>
        
        
        
       
         <!-- ------------------ Start My photos ------------------ -->
        
       <div class='photos-form'>
           
        <?php
        $c=0;
        
        if (is_array($data) || is_object($data)){
            foreach ($data as $value) {
                $idIMG="id".$c;
                $btn_id="btn".$idIMG;
                $img=$value['img'];
                $postID=$value['postID'];
                $userID=$value['userID'];
                echo "<form style='display:inline;' method='post' action='../controller/notification_controller.php'><input type='hidden' value='$postID'>
                      <input type='hidden' name='userID' value='$userID'>
                      <input type='hidden' name='postID' value='$postID'>
                      <input type='hidden' name='kind' value='none'>
                      <button id='$btn_id' style='display:none;' name='btn-show'>show</button>
                      <img class='photo' id='$idIMG' src='$img'></form>";
                $c++;
            }
        }
        ?>
        </div>
        
        <!-- ------------------ End My photos ------------------ -->
         <script src="../../js/jquery-3.2.1.min.js"></script>
        <script src="../../js/sweetalert2.min.js"></script>
        <script src="../../js/jquery.nicescroll.js"></script>
        <script src="../../js/jquery.smooth-scroll.min.js"></script>
        <script src="../../js/Profile-photos.js"></script>
        <script src="../../js/navbar.js"></script>
        <script src="../../js/scroll-light.js"></script>
        
        
    </body>
</html>
