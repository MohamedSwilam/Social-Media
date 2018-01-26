
<?php
session_start();
if ($_SESSION['login'] == FALSE) {
    $_SESSION['result'] = 9;
    header("Location: ../viewer/index.php");
}

require '../model/user.php';
require '../model/userLinks.php';
require_once '../model/friend.php';
$ID = $_SESSION['userID'];


$user1 = new user();
$u1 = new user();
$f1 = new friend();
$i = 0;

$result = $f1->read($ID);
if (!empty($result)) {
    foreach ($result as $value) {
        $result2 = $user1->getlocation($value['friendID']);
        foreach ($result2 as $value) {
            $lat[$i] = $value['latitude'];
            $long[$i] = $value['longitude'];
            $fnames[$i] = $value['fname'];
            $lnames[$i] = $value['lname'];
            $approval[$i] = $value['map'];
            $i++;
        }
    }
}

$themeResult = $u1->getTheme($ID);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>maps</title>
        <?php
        if ($themeResult == 0) {
            echo "<link rel='stylesheet' href='../../css/light-navbar.css'>
        <link rel='stylesheet' href='../../css/myinfo-light.css'>";
        } else if ($themeResult == 1) {
            echo "<link rel='stylesheet' href='../../css/navbar.css'>
        <link rel='stylesheet' href='../../css/myinfo.css'>";
        }
        ?>
        <script  src="../../js/jquery-3.2.1.min.js"></script>

    </head>

    <body>
        <?php
        include 'navbar.php';
        include 'myinfo.php';
        ?>
        <style>
            .my-info{
                z-index: 1;
            }

        </style>
        <div id='map' class="map"></div>

        <script>
            var late = <?php echo json_encode($lat); ?>;
            var long = <?php echo json_encode($long); ?>;
            var fname = <?php echo json_encode($fnames); ?>;
            var lname = <?php echo json_encode($lnames); ?>;
            var approval = <?php echo json_encode($approval); ?>;

            var uluru = {lat: parseFloat(late[0]), lng: parseFloat(long[0])};
            function initMap() {


                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 17,
                    center: uluru
                });

                var icon = {
                    url: '../../images/default.jpg', // url
                    scaledSize: new google.maps.Size(70, 70), // scaled size

                };
                for (var i = 0; i < long.length; i++)
                {
                    if (approval[i] == 'yes')
                    {
                        // 29.885161699999998   :   31.3040113
                        uluru = {lat: parseFloat(late[0]), lng: parseFloat(long[0])};
                        var marker = new google.maps.Marker({
                            position: uluru,
                            map: map,
                            title: 'Hello World!'
                            , draggable: true, animation: google.maps.Animation.BOUNCE,
                            icon: icon,
                            label: fname[i] + " " + lname[i]
                        });
                    }
                }
            }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAb4kj4gBwQda3sBJUqz1t4BacShgp_OEA&callback=initMap"
        async defer></script>
    </body>
    <style>
        body{
            margin: 0px;
        }

        #map{
            height:100vh;
            width:100hh;
            border: maroon;
            border-radius:20px;
        }
    </style>
    <script src="../../js/navbar.js"></script>
    <script src="../../js/myinfo.js"></script>
</html>