
<?php
session_start();
$_SESSION['login'] = FALSE;

if (isset($_SESSION['result']) && !empty($_SESSION['result'])) {
    $result = $_SESSION['result'];
} else {
    $result = 1;
}
$fnameVal = "";
$lnameVal = "";
$emailVal = "";
$mobileVal = "";
$passwordVal = "";
$confirmPassVal = "";
$genderVal = "";
$birthdateVal = "";

if (isset($_SESSION['firstname']) && !empty($_SESSION['firstname'])) {
    $fnameVal = $_SESSION['firstname'];
}
if (isset($_SESSION['lastname']) && !empty($_SESSION['lastname'])) {
    $lnameVal = $_SESSION['lastname'];
}
if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
    $emailVal = $_SESSION['email'];
}
if (isset($_SESSION['mobile']) && !empty($_SESSION['mobile'])) {
    $mobileVal = $_SESSION['mobile'];
}
if (isset($_SESSION['password']) && !empty($_SESSION['password'])) {
    $passwordVal = $_SESSION['password'];
}
if (isset($_SESSION['confirmPass']) && !empty($_SESSION['confirmPass'])) {
    $confirmPassVal = $_SESSION['confirmPass'];
}
if (isset($_SESSION['gender']) && !empty($_SESSION['gender'])) {
    $genderVal = $_SESSION['gender'];
}
if (isset($_SESSION['birthdate']) && !empty($_SESSION['birthdate'])) {
    $birthdateVal = $_SESSION['birthdate'];
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Connect</title>
        <link rel="stylesheet" href="../../css/sweetalert2.min.css">
        <script src="../../js/jquery-3.2.1.min.js"></script>
        <script src="../../js/sweetalert2.min.js"></script>
        <link rel="stylesheet" href="../../css/index-light.css">
        <script>
            var latitude1 = 0;
            var longitude1 = 0;
            $(document).ready(function () {


                if (navigator.geolocation)
                {
                    browserSupportFlag = true;
                    navigator.geolocation.getCurrentPosition(function (position)
                    {
                        var latitude = position.coords.latitude;
                        var longitude = position.coords.longitude;
                        latitude1 = latitude;
                        longitude1 = longitude;

                        // alert(latitude+"   :   "+longitude);
                        $('#long').val(longitude1);
                        $('#lat').val(latitude1)
                        initMap()
                    }, function () {
                        //alert("Geolocation Failed");
                    });
                }

            });




        </script>
    </head>

    <body>

        <div class="nav-bar">
            <div class="logo"><span>C</span>onnect</div>
            <form class="login" method="post" action="../controller/login.php">
                <div>
                    <img class="username-logo" src="../../images/avatar2.png">
                </div>
                <input class="login-input , password-login" name="email" type="text" placeholder="Email.." required>
                <div>
                    <img class="password-logo" src="../../images/padlock.png">
                </div>
                <input class="login-input , password-login" name="password" type="password" placeholder="Password.." required>
                <input type="text" name="long" id="long"  hidden >
                <input type="text" name="lat" id="lat"  hidden >
                <button class="btn-login" name="btn-login">Login</button>
            </form>
        </div>

<!--<img class="img-world" src="../../images/24201286_10212923767882495_1294981550_o.png" width="750px" height="450px">-->
        
        <div class="header">
            <img src="../../images/123.png">
            <center>
                <form class="signup" method="post" action="../controller/signup.php">
                    <input type="text" value="<?php echo $fnameVal; ?>" class="name fname" name="firstname" placeholder="First Name" required>
                    <input type="text" value="<?php echo $lnameVal; ?>" class="name lname" name="lastname" placeholder="Last Name" required><br>
                    <input type="email" value="<?php echo $emailVal; ?>" class="signup-input , signup-email" name="email" placeholder="Email" required><br>
                    <input type="number" value="<?php echo $mobileVal; ?>" class="signup-input , signup-mobile" name="mobile" placeholder="Mobile" required><br>
                    <input type="password" value="<?php echo $passwordVal; ?>" class="signup-input , signup-password" name="password" placeholder="Password" required>
                    <input type="password" value="<?php echo $confirmPassVal; ?>" class="signup-input , signup-confirmpassword" name="confirm-password" placeholder="Confirm password" required><br>
                    <label class="label-gender">Gender</label>
                    <label class="label-birthdate">Birthdate</label>
                    <div class="gender-container">
                        <input type="radio" class="gender" name="gender" value="Male" checked><label class="gender-male">Male</label>
                        <input type="radio" class="gender" name="gender" value="Female" ><label class="gender-female">Female</label>
                    </div>

                    <div class="birthdate-container">
                        <input name="birthdate" value="<?php echo $birthdateVal; ?>" type="date" class="signup-date">
                    </div>
                    <br>
                    <button name="btn-signup" class="btn-signup">Create an account</button>
                </form>
            </center>
        </div>
        <?php
        if ($result == 7) {
            $_SESSION['result'] = 3;
            ?>
            <script>sweetAlert("Oops...", "Email Entered is already taken!", "error");</script>
            <?php
        } else if ($result == 2) {
            $_SESSION['result'] = 3;
            ?>
            <script>sweetAlert("Oops...", "First Name Should not contain spaces!", "error");</script>
            <?php
        } else if ($result == 4) {
            $_SESSION['result'] = 3;
            ?>
            <script>sweetAlert("Oops...", "Email Entered Not Vaild!", "error");</script>
            <?php
        } else if ($result == 6) {
            $_SESSION['result'] = 3;
            ?>
            <script>sweetAlert("Oops...", "Wrong Password!", "error");</script>
            <?php
        } else if ($result == 8) {
            $_SESSION['result'] = 3;
            ?>
            <script>sweetAlert("Oops...", "Passwords entered are not matched", "error");</script>
            <?php
        } else if ($result == 9) {
            $_SESSION['result'] = 3;
            ?>
            <script>sweetAlert("Oops...", "You should login first!", "error");</script>
            <?php
        }
        ?>   
    </body>
</html>