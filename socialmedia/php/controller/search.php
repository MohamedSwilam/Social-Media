<?php
require_once '../model/user.php';

$u1 = new user();

$content=$_POST['content'];

$result=$u1->search($content);
$c=1;
if(!empty($result)){
    foreach ($result as $value){
        $name=$value['fname']." ".$value['lname'];
        $img=$value['profile'];
        $id=$value['id'];
        $value_id="value-".$c;
        
        echo "<div class='value' id='$value_id'>
              <form method='post' action='profile.php' style='display:none'>
              <input type='hidden' name='id' value='$id'>
              <button name='redirect' id='btn-$value_id'>redirect</button>
              </form>
              <img src='$img'>
              <p class='value-Name'>$name</p>
              </div>";
        $c++;
    }
}