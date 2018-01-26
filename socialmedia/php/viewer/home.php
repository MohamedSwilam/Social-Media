<?php
session_start();

if ($_SESSION['login'] == FALSE) {
    $_SESSION['result'] = 9;
    header("Location: ../viewer/index.php");
}
require_once '../model/user.php';
require_once '../model/post.php';
require_once '../model/userLinks.php';
require_once '../model/actions.php';

$id = $_SESSION['userID'];

if (isset($_SESSION['actionpostresult']) && !empty($_SESSION['actionpostresult'])) {
    $writepostResult = $_SESSION['actionpostresult'];
} else {
    $writepostResult = 3;
}

$u1 = new user();
$themeResult = $u1->getTheme($id);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Home</title>
        <script src="../../js/jquery-3.2.1.min.js"></script>
        <script src="../../js/sweetalert2.min.js"></script>
        <script src="../../js/getlocation.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCzdpGWJV2ahuUCfJnQo5VGYtJAB90Zea4&callback=initMap" async defer></script>
        <link rel="stylesheet" href="../../css/sweetalert2.min.css">
        <?php
        if ($themeResult == 0) {
            echo "<link rel='stylesheet' href='../../css/home-light.css'>";
            echo "<link rel='stylesheet' href='../../css/post-light.css'>";
            echo "<link rel='stylesheet' href='../../css/light-navbar.css'>";
            echo "<link rel='stylesheet' href='../../css/myinfo-light.css'>";
        } else if ($themeResult == 1) {
            echo "<link rel='stylesheet' href='../../css/home.css' >";
            echo "<link rel='stylesheet' href='../../css/navbar.css' >";
            echo "<link rel='stylesheet' href='../../css/myinfo.css' >";
            echo "<link rel='stylesheet' href='../../css/post.css' >";
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

        <!-- ------------------ Start Write Post ----------------- -->

        <div class="write-post">
            <button onclick="document.getElementById('fileUpload').click()" class="uploadImage">Upload Image</button>
            <form method="post" action="../controller/post-controller.php" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="hidden" name="from" value="home">
                <input type="hidden" id="lat"  name="lat" >
                <input type="hidden" id="long"  name="long">
                <textarea required name="content" class="txt-post" placeholder="Enter your post here.."></textarea>
                <input type="file" id="fileUpload" name="img" accept="image/*" style="display:none">
                <button name="btn-post" class="btn-post">Post</button>
                <button name="btn-location" class="btn-post">Post my Location</button>
            </form>
            <div id="img-upload" style="position: absolute;width:30px;top: 231px;left: 426px;height:30px;">
            </div>
        </div>
        <!-- ------------------ End Write Post ----------------- -->

        <!-- ------------------ Start actions ------------------ -->
        <?php
        include 'actions.php';
        ?>
        <!-- ------------------ End actions ------------------ -->
        <!-- ------------------ Start owner ------------------ -->
        <div class="owner">
            <h1>CONNECT</h1>
            <p>All rights reserved 2017 &copy;</p>
        </div>
        <!-- ------------------ End owner ------------------ -->

        <!-- ------------------ Start Post ------------------ -->

        <?php
        $page = "home";
        $top = "0px";
        $p1 = new post();
        $postsResult = $p1->getAllPosts($id);
        require 'post-viewer.php';
        ?>

        <!-- ------------------ End Post ------------------ -->
        <div class="go-top"><span>UP</span></div>

        <script src="../../js/jquery.nicescroll.js"></script>
        <script src="../../js/jquery.smooth-scroll.min.js"></script>
        <script src="../../js/home.js"></script>
        <script src="../../js/post.js"></script>
        <script src="../../js/navbar.js"></script>
        <script src="../../js/myinfo.js"></script>
        <script src="../../js/scroll-light.js"></script>
    </body>
</html>