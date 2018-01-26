<?php

require_once '../model/post.php';
$postID = $_POST['postID'];

$p1 = new post();
$likers = $p1->readLike($postID);

if(!empty($likers)){
    foreach ($likers as $value){
        $name=$value['fname']." ".$value['lname'];
        $img=$value['profile'];
        echo "<div>
                <img src='$img' width='50px' height='50px' style='border-radius: 25px;'>
                <span class='like-name'>$name</span>
            </div>";
    }
}
