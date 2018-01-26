<?php 
    session_start();
    if($_SESSION['login']==FALSE){
        $_SESSION['result']=9;
        header("Location: ../viewer/index.php");
    }
    require '../model/user.php';
    require '../model/conversation.php';
    require '../model/message.php';
    $id = $_SESSION['userID'];
    
    $u1= new user();
    $c1 = new conversation();
    
    $themeResult=$u1->getTheme($id);
    
    if(isset($_SESSION['convID']) && !empty($_SESSION['convID'])) {
        $convID=$_SESSION['convID'];
    }else{
        $convID="no";
    }
    $result=$c1->read_sides($convID);
    if (is_array($result) || is_object($result)){
        foreach ($result as $value) {
            $side1=$value['side1'];
            $side2=$value['side2'];
        }
    }
    if($side1==$id){
        $receiver=$side2;
    }else{
        $receiver=$side1;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Conversation</title>
         <?php 
            if($themeResult==0){
                echo "<link rel='stylesheet' href='../../css/conversation-light.css'>";
                echo "<link rel='stylesheet' href='../../css/light-navbar.css'>";
            }
            else if($themeResult==1){
                echo "<link rel='stylesheet' href='../../css/conversation.css'>";
                echo "<link rel='stylesheet' href='../../css/navbar.css'>";
            }
        ?>
    </head>
    <body>
         <?php
       include 'navbar.php';
         ?> 
      
        
        <div class="conversation-content" id="msgs">
            
        </div>
        
        
        <div class="send-message">
                <textarea class="txt-msg" placeholder="Type your message here.."></textarea>
                <input type="hidden" class="convID" value="<?php echo $convID; ?>">
                <input type="hidden" class="receiver" value="<?php echo $receiver; ?>">
                <input type="hidden" class="sender" value="<?php echo $id; ?>">
                <button class="btn-send-msg">Send Message</button>
        </div>
        
        <script src="../../js/jquery-3.2.1.min.js"></script>
        <script src="../../js/jquery.nicescroll.js"></script>
        <script src="../../js/jquery.smooth-scroll.min.js"></script>
        <script src="../../js/conversation.js"></script>
        <script src="../../js/navbar.js"></script>
        <script src="../../js/scroll-light.js"></script>
    </body>
</html>