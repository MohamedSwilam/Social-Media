<?php
if ($page == "home" || $page == "save") {
    $style = "";
} else {
    $style = "position: relative;top:$top;";
}
?>

<div class="post-container" style="<?php echo $style; ?>">
    <?php
    $longarr;
    $latgarr;
    $postCounterr;
    $ii = 0;
    $c = 1;
    $c2 = 1;
    $c3 = 0;
    $numOfPosts = 0;

    if (is_array($postsResult) || is_object($postsResult)) {
        foreach ($postsResult as $value) {
            $postcount[$c3] = "p" . $c2;
            if ($value['longitude'] != '-') {
                $numOfPosts++;
                $longarr[$ii] = $value['longitude'];
                $latgarr[$ii] = $value['latitude'];
                $postCounterr[$ii] = $postcount[$c3];
                $ii++;
            }
            $c2++;
            $c3++;
        }
    }

    if (is_array($postsResult) || is_object($postsResult)) {
        foreach ($postsResult as $value) {
            $postID = $value['postID'];
            $ownerPostID = $value['ownerPostID'];
            $counter = $value['counter'];
            $content = $value['content'];
            $img = $value['img'];
            $date = $value['date'];
            $time = $value['time'];
            $userID = $value['userID'];
            $owner = $value['owner'];
            $type = $value['type'];
            $status = $value['status'];
            $long = $value['longitude'];
            $lat = $value['latitude'];
            $map = 1;

            $verb = "";
            if ($gender == "Male") {
                $verb = "his";
            } else {
                $verb = "her";
            }

            $postStatus = "";
            if ($status == "edited") {
                $postStatus = "Edited";
            }

            $postCounter = "p" . $c;

            $idSave = $postCounter . "saveID";
            $ownerSave = $postCounter . "saveownerID";
            $fromSave = $postCounter . "saveFrom";
            $postIDSave = $postCounter . "savePostID";
            $ownerpostIDSave = $postCounter . "saveOwnerPostID";
            $contentSave = $postCounter . "saveContent";
            $imgSave = $postCounter . "saveImg";
            $dateSave = $postCounter . "saveDate";
            $timeSave = $postCounter . "saveTime";
            $postUserIDSave = $postCounter . "savePostUserID";
            
            $_SESSION[$idSave] = $id;
            $_SESSION[$ownerSave] = $owner;
            $_SESSION[$fromSave] = $page;
            $_SESSION[$ownerpostIDSave] = $ownerPostID;
            $_SESSION[$postIDSave] = $postID;
            $_SESSION[$contentSave] = $content;
            $_SESSION[$imgSave] = $img;
            $_SESSION[$dateSave] = $date;
            $_SESSION[$timeSave] = $time;
            $_SESSION[$postUserIDSave] = $userID;

            $numberOfLikes = $p1->countLC("likes", $postID);
            $numberOfComments = $p1->countLC("comments", $postID);

            $userInfo = $u1->read($userID);
            $ownerInfo = $u1->read($owner);

            if (is_array($userInfo) || is_object($userInfo)) {
                foreach ($userInfo as $value) {
                    $userName = $value['fname'] . " " . $value['lname'];
                    $userPhoto = $value['profile'];
                    $postGender = $value['gender'];
                }
            }
            if (is_array($ownerInfo) || is_object($ownerInfo)) {
                foreach ($ownerInfo as $value) {
                    $ownerName = $value['fname'] . " " . $value['lname'];
                    $ownerPhoto = $value['profile'];
                }
            }
            echo "<div class='post'>
                          <form class='share-form' method='post' action='../controller/post-controller.php'>
                          <div>
                          <input type='hidden' name='postCounter' value='$postCounter'>";
            if ($page == "save") {
                echo "<img class='post-img-owner' src='$ownerPhoto'>";
            } else {
                echo "<img class='post-img-owner' src='$userPhoto'>";
            }
            echo "<img src='../../images/arrow-down-sign-to-navigate.png' class='post-down-arrow' id='$postCounter'>
                          <div class='dropdown-edit-post' id='dropdown-toggle-$postCounter'>
                          <button name='btn-save' class='btn-save'>";
            if ($p1->checkSavePost($id, $ownerPostID) == TRUE) {
                echo "unsave</button>";
            } else {
                echo "Save</button>";
            }
            if ($userID == $owner && $userID == $id) {
                echo "<div class='edit-btn' id='$postCounter'>Edit</div>
                              <button name='btn-delete' class='btn-delete'>Delete</button>";
            } else {
                if ($userID == $id) {
                    echo "<button name='btn-delete' class='btn-delete'>Delete</button>";
                }
            }
            echo "</div>";
            if ($type == "profile") {
                echo "<div class='post-name'><a href='Profile.php?profileOwnerID=$userID'>$userName</a> Changed $verb profile picture</div>";
            } else if ($type == "cover") {
                echo "<div class='post-name'><a href='Profile.php?profileOwnerID=$userID'>$userName</a> Changed $verb cover photo</div>";
            } else if ($userID == $owner) {
                if ($ownerPostID != $postID) {
                    echo "<div class='post-name'><a href='Profile.php?profileOwnerID=$userID'>$userName</a> shared $verb own post</div>";
                } else {
                    echo "<div class='post-name'><a href='Profile.php?profileOwnerID=$userID'>$userName</a></div>";
                }
            } else {
                if ($page == "save") {
                    echo "<div class='post-name'><a href='Profile.php?profileOwnerID=$owner'>$ownerName</a></div>";
                } else if ($owner == $id) {
                    echo "<div class='post-name'><a href='Profile.php?profileOwnerID=$userID'>$userName</a> shared your post</div>";
                } else {
                    echo "<div class='post-name'><a href='Profile.php?profileOwnerID=$userID'>$userName</a> shared the Post of <a href='Profile.php?profileOwnerID=$owner'>$ownerName</a></div>";
                }
            }
            echo "<div class='post-time'>$date $postStatus</div>
                            <hr></div>
                            <div class='post-content-$postCounter'>$content</div>
                            <div style='display:none;' class='form-content-$postCounter'>
                            <form>
                            <textarea name='editedContent' style='width:99%;height:40px;'></textarea>
                            <br>
                            <div class='cancel-btn' id='$postCounter'>Cancel</div>
                            <button name='btn-update' class='btn-update'>Update</button>
                            <form></div>
                            <br>";
            if ($img != "no") {
                echo "<div class='post-img'><center><img src='$img'></center></div>";
            } else if ($long != "-") {
                echo "<center><div class='map' id='map$postCounter'></div></center>";
                $ii++;
            }
            echo "<input type='hidden' value='$postID' class='like-postID-$postCounter'><div class='reactions'>$numberOfLikes <span id='$postCounter' class='lbl-like'>Likes</span> - $numberOfComments <span id='$postCounter' class='lbl-comment'>Comments<span></div>
                          <hr class='hr-post'>";
            if ($p1->checkLike($postID, $id) == TRUE) {
                echo "<button name='btn-like' class='btn-like like-selected' id='$postCounter'>
                          <img class='like-img-selected' id='like-2-$postCounter' src='../../images/like-selected.png'>";
            } else {
                echo "<button name='btn-like' class='btn-like' id='$postCounter'>
                              <img class='like-img-selected' id='like-1-$postCounter' src='../../images/like.png'>";
            }
            echo "<span class='like-txt'>Like</span>
                          </button>
                          <div name='btn-comment' class='btn-comment' id='$postCounter'><img src='../../images/comments.png'><span class='comment-txt'>Comment</span></div>
                          <button name='btn-share' class='btn-share'><img src='../../images/share1.png'><span class='share-txt'>Share</span></button>
                          </form>
                          <div class='comment' id='comment-toggle-$postCounter'>
                          <hr>
                          <form method='post' action='../controller/post-controller.php'>
                          <input type='hidden' name='postCounter' value='$postCounter'>
                          <textarea class='comment-input' name='comment-content' required></textarea>
                          <button class='btn-comment-2' name='btn-comment'>Comment</button>
                          </form>
                          <br>
                          <div class='all-comments'>";
            $comments = $p1->readComments($postID);
            $hrCounter = 1;
            $counterComments=0;
            if (is_array($comments) || is_object($comments)) {
                foreach ($comments as $value) {
                    $commentOwnerInfo = $u1->read($value['userID']);
                    if (is_array($commentOwnerInfo) || is_object($commentOwnerInfo)) {
                        foreach ($commentOwnerInfo as $valuee) {
                            $ownerCommentName = $valuee['fname'] . " " . $valuee['lname'];
                            $ownerCommentPhoto = $valuee['profile'];
                            $ownerCommentID = $valuee['id'];
                        }
                    }
                    $commentdate = $value['date'];
                    $commentContent = $value['content'];
                  $commentID=$value['comment_id'];
                    
                    $comment_formID=$postCounter . $counterComments;
                    echo "<div class='post-comment' id='hide-$comment_formID'>
                                  <img class='post-comment-img' src='$ownerCommentPhoto'>
                                  <b class='post-comment-name'><a href='Profile.php?profileOwnerID=$ownerCommentID'>$ownerCommentName</a></b>
                                  <h6 class='post-comment-date'>$commentdate</h6>
                                  <i class='post-comment-content'>$commentContent</i>";
                                  if($id==$ownerCommentID){
                                 echo "<div>
                                      <p class='edit-comment-lbl' id='$comment_formID'>Edit<p/>
                                  </div>
                                ";
                                  }  
                    $counterComments++;
                    if (is_array($comments) || is_object($comments)) {
                    foreach ($comments as $value) {
                    $commentOwnerInfo = $u1->read($value['userID']);
                    if (is_array($commentOwnerInfo) || is_object($commentOwnerInfo)) {
                        foreach ($commentOwnerInfo as $valuee) {
                            
                            if($ownerCommentID==$userID){
                            $ownerCommentID = $valuee['id'];
                             
                        }
                    }
                }
                    }
                        echo"</div><form class='comment-form' id='div-$comment_formID' method='post' action='../controller/post-controller'>
                            <textarea name='editedCommentContent' style='width:99%;height:40px;'>$commentContent</textarea>
                            <input type='hidden' name='commentID' value='$commentID'>
                            <input type='hidden' name='postCounter' value='$postCounter'>
                            <br>
                            <div class='cancel-btn-comment' id='$comment_formID'>Cancel</div>
                            <button name='btn-update-comment' class='btn-update-comment'>Save</button>
                            </form>";
            
        }
                    if ($hrCounter != $numberOfComments) {
                        echo "<hr>";
                    }
                    $hrCounter++;
                }
            }
            echo "</div></div></div>";
            $c = $c + 1;
        }
    }
    ?>
</div>

<div class="like-list">
    <div class="close-list">Close</div>
    <div id="likers-list">

    </div>
</div>

<script>
    var late = <?php echo json_encode($latgarr); ?>;
    var long = <?php echo json_encode($longarr); ?>;
    var postcounter =<?php echo json_encode($postCounterr); ?>;
    var i =<?php echo json_encode($numOfPosts); ?>;

    function initMap() {
<?php
for ($k = 0; $k < $numOfPosts; $k++) {
    echo "var uluru =  {lat: parseFloat(late[$k]), lng:parseFloat(long[$k])};
                                  var myOptions = {
                                      zoom: 14,
                                      center: new google.maps.LatLng(uluru),
                                      mapTypeId: google.maps.MapTypeId.ROADMAP
                                  }
                                  var map$k = new google.maps.Map(document.getElementById('map$postCounterr[$k]'), myOptions);;
                                  var marker = new google.maps.Marker({
                                      position: uluru,
                                      map: map$k
                                  });";
}
?>
    }
</script>

<?php
if ($writepostResult == 0) {
    $_SESSION['actionpostresult'] = 3;
    ?>
    <script>swal('Oops...', 'Failed to upload your post!', 'error');</script>
    <?php
} else if ($writepostResult == 1) {
    $_SESSION['actionpostresult'] = 3;
    ?>
    <script>swal('Done', 'Your post Successfully Uploaded!', 'success');</script>
    <?php
} else if ($writepostResult == 4) {
    $_SESSION['actionpostresult'] = 3;
    ?>
    <script>swal('Oops...', 'Failed to submit the like', 'error');</script>
    <?php
} else if ($writepostResult == 5) {
    $_SESSION['actionpostresult'] = 3;
    ?>
    <script>swal('Done', 'Your Like Successfully Submitted!', 'success');</script>
    <?php
} else if ($writepostResult == 7) {
    $_SESSION['actionpostresult'] = 3;
    ?>
    <script>swal('Oops...', 'Failed to dislike', 'error');</script>
    <?php
} else if ($writepostResult == 8) {
    $_SESSION['actionpostresult'] = 3;
    ?>
    <script>swal('Done', 'Your comment Successfully Submitted!', 'success');</script>
    <?php
} else if ($writepostResult == 9) {
    $_SESSION['actionpostresult'] = 3;
    ?>
    <script>swal('Oops...', 'Failed to submit your comment', 'error');</script>
    <?php
} else if ($writepostResult == 10) {
    $_SESSION['actionpostresult'] = 3;
    ?>
    <script>swal('Done', 'Post Successfully shared!', 'success');</script>
    <?php
} else if ($writepostResult == 11) {
    $_SESSION['actionpostresult'] = 3;
    ?>
    <script>swal('Oops...', 'Failed to Share Post', 'error');</script>
    <?php
} else if ($writepostResult == 12) {
    $_SESSION['actionpostresult'] = 3;
    ?>
    <script>swal('Done', 'Post Successfully Saved!', 'success');</script>
    <?php
} else if ($writepostResult == 13) {
    $_SESSION['actionpostresult'] = 3;
    ?>
    <script>swal('Oops...', 'Failed to Save Post', 'error');</script>
    <?php
} else if ($writepostResult == 14) {
    $_SESSION['actionpostresult'] = 3;
    ?>
    <script>swal('Done', 'Post Successfully Unsaved!', 'success');</script>
    <?php
} else if ($writepostResult == 15) {
    $_SESSION['actionpostresult'] = 3;
    ?>
    <script>swal('Oops...', 'Failed to Unsave Post', 'error');</script>
    <?php
} else if ($writepostResult == 16) {
    $_SESSION['actionpostresult'] = 3;
    ?>
    <script>swal('Done', 'Post Successfully Deleted!', 'success');</script>
    <?php
} else if ($writepostResult == 17) {
    $_SESSION['actionpostresult'] = 3;
    ?>
    <script>swal('Oops...', 'Failed to Delete Post', 'error');</script>
    <?php
} else if ($writepostResult == 18) {
    $_SESSION['actionpostresult'] = 3;
    ?>
    <script>swal('Oops...', 'The post should contain any content!', 'error');</script>
    <?php
} else if ($writepostResult == 19) {
    $_SESSION['actionpostresult'] = 3;
    ?>
    <script>swal('Done', 'Post Successfully Updated!', 'success');</script>
    <?php
} else if ($writepostResult == 20) {
    $_SESSION['actionpostresult'] = 3;
    ?>
    <script>swal('Oops...', 'Failed to Update Post', 'error');</script>
    <?php
}
?>