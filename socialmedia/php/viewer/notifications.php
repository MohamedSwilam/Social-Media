<?php 
    session_start();
    if($_SESSION['login']==FALSE){
        $_SESSION['result']=9;
        header("Location: ../viewer/index.php");
    }
    require_once '../model/user.php';
    require_once '../model/notification.php';
    require_once '../model/userLinks.php';
    
    $id = $_SESSION['userID'];
    
    $u1= new user();
    
    $themeResult=$u1->getTheme($id);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
		<title>notifications</title>
		<link rel="stylesheet" href="../../css/notifications-light.css">
                <?php 
                    if($themeResult==0){
                        echo "<link rel='stylesheet' href='../../css/notifications-light.css'>";
                        echo "<link rel='stylesheet' href='../../css/light-navbar.css'>";
                        echo "<link rel='stylesheet' href='../../css/myinfo-light.css'>";
                        
                    }
                    else if($themeResult==1){
                        echo "<link rel='stylesheet' href='../../css/notifications.css'>";
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
    ?> 
      
        
        <!-- ------------------ End Navbar ------------------ -->
         <center><h1 class="notifications-title">Notifications</h1></center>
		 <br><br>
        <!-- ---------------- Start Notifications ---------------- -->
        <div class="perspective">
            <?php 
                $n1=new notification();
                $result=$n1->read($id);
                $c=1;
                if (is_array($result) || is_object($result)){
                    foreach ($result as $value) {
                        $userID=$value['userID'];
                        $postID=$value['postID'];
                        $kind=$value['kind'];
                        $date=$value['date'];
                        $time=$value['time'];
                        $seen=$value['seen'];
                        
                        $action="";
                        if($kind=="like"){
                            $action=" Liked";
                        }else if($kind=="comment"){
                            $action=" Commented on";
                        }else if($kind=="share"){
                            $action=" Shared";
                        }
                        $style="";
                        if($seen=="false"){
                            $style="box-shadow: 0 4px 10px #0091ff;";
                        }
                        
                        $notID="n".$c;
                        $btn="btn-".$notID;
                        
                        $userData=$u1->read($userID);
                        if (is_array($userData) || is_object($userData)){
                            foreach ($userData as $valuee) {
                                $notifierName=$valuee['fname']." ".$valuee['lname'];
                                $notifierImg=$valuee['profile'];
                            }
                        }
                        echo "<div class='notifications-container' style='$style' id='$notID'>
                                <form method='post' action='../controller/notification_controller.php'>
                                <input type='hidden' name='postID' value='$postID'>
                                    <input type='hidden' name='userID' value='$userID'>
                                        <input type='hidden' name='kind' value='$kind'>
                                <button id='$btn' name='btn-show' style='display:none;'>show</button>
                                </form>
                                <img src='$notifierImg'>
                                <h1><span>$notifierName</span>$action Your post<span style='color:white;float:right;font-size:18px;margin-top:15px;'>$date<span></h1>
                            </div>";
                        $c++;
                    }
                }
            ?>
	</div>
	
        <script src="../../js/jquery-3.2.1.min.js"></script>
        <script src="../../js/jquery.nicescroll.js"></script>
        <script src="../../js/jquery.smooth-scroll.min.js"></script>
        <script src="../../js/notifications.js"></script>
        <script src="../../js/navbar.js"></script>
        <script src="../../js/myinfo.js"></script>
        <script src="../../js/scroll-light.js"></script>
        
    </body>
</html>