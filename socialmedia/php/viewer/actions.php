<div class="actions">
    <?php
    $a1 = new actions();
    $result1 = $a1->read($id);

    if (is_array($result1) || is_object($result1)) {
        foreach ($result1 as $value) {
            $userID = $value['userID'];
            $ownerID = $value['ownerID'];
            $postID = $value['postID'];
            $type = $value['type'];

            $userInfo = $u1->read($userID);
            if (is_array($userInfo) || is_object($userInfo)) {
                foreach ($userInfo as $valuee) {
                    $firstName = $valuee['fname'];
                    $lastName = $valuee['lname'];
                    $userName = $firstName . " " . $lastName;
                    $userPhoto = $valuee['profile'];
                }
            }

            $ownerInfo = $u1->read($ownerID);
            if (is_array($ownerInfo) || is_object($ownerInfo)) {
                foreach ($ownerInfo as $valuee) {
                    $firstName = $valuee['fname'];
                    $lastName = $valuee['lname'];
                    $ownerName = $firstName . " " . $lastName;
                }
            }

            $action = "";

            if ($type == "share") {
                $action = "shared";
            } else if ($type == "like") {
                $action = "liked";
            } else if ($type == "comment") {
                $action = "commented on";
            }

            echo"<div class='action-container'>
                    <img class='action-img' src='$userPhoto'>
                    <span class='action-content '>
                    <b class='action-by'><a href='Profile.php?profileOwnerID=$userID'>$userName</a> </b><i class='action-type'> $action </i><b class='action-on'><a href='Profile.php?profileOwnerID=$ownerID'>$ownerName's </a></b><i>post</i>
                    </span>
                    </div>
                    <hr>";
        }
    }
    ?>
</div>