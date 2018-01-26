<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Connect</title>
        <link rel="stylesheet" href="../css/sweetalert2.min.css">
        <link rel="stylesheet" href="../css/index.css">
        <script src="../js/jquery-3.2.1.min.js"></script>
        <script src="../js/sweetalert2.min.js"></script>
    </head>
    
    <body>
        <?php 
            $counter=0;
        ?>
        
        <div class="nav-bar">
            <div class="logo"><span>C</span>onnect</div>
            <form class="login" method="post">
                <img class="username-logo" src="../images/avatar2.png">
                <img class="password-logo" src="../images/padlock.png">
                <input  name ="username"class="login-input , password-login" type="text" placeholder="Username.." required>
                <input name="password" class="login-input , password-login" type="password" placeholder="Password.." required>
                <button name ="btn-login"class="btn-login">Login</button>
                <?php 
                    if(isset($_POST["btn-login"]))
                    {
                        $email=$_POST["username"];
                        $password=$_POST["password"];
                        
                        $user="root";
                            $pass="";
                            
                            $db="socialmedia";
                            $server="localhost";
                            $sql="SELECT `password` FROM `user` WHERE `email` = '$email'";
                            
                             $conn = new mysqli($server, $user, $pass, $db);  //open conection
                            if ($conn->connect_error) // make sure that connection is opened
                                die($conn->connect_error);
                             $result = $conn->query($sql); // make mysql execute the command $sql
                             $data = []; //create array
                             while ($row = $result->fetch_assoc()) // btloop 3la 2lresult
                                 $data[] = $row;
                             $conn->close();
                             $checkmail=false;
                             foreach ($data as $value) {
                                  $checkpass=$value['password'];
                                  $checkmail=true;
                              }
                              if ($checkmail==false){
                                  ?>
                            <script>swal(
                              'Oops...',
                              'Invalid email!',
                              'error'
                            );</script>
                    <?php
                              }else{
                              if($checkpass==$password){
                                  header("Location: home.html");
                              }
                              else{
                                  ?>
                            <script>swal(
                              'Oops...',
                              'Wrong Password!',
                              'error'
                            );</script>
                    <?php
                              }
                              }
                    }
                ?>
            </form>
        </div>
        
        <img class="img-world" src="../images/330816e4bcb768d2eb0e4aba56674f18.png" width="750px" height="450px">
        
        <div class="header">
            <center>
                <form class="signup" method="post">
                    <input name="fname" type="text" class="name fname" placeholder="First Name" required>
                    <input name="lname" type="text" class="name lname" placeholder="Last Name" required><br>
                    <input name="email" type="email" class="signup-input , signup-email" placeholder="Email" required><br>
                    <input name="mobile" type="number" class="signup-input , signup-mobile" placeholder="Mobile" required><br>
                    <input name="password" type="password" class="signup-input , signup-password" placeholder="Password" required><br>
                    <label class="label-gender">Gender</label>
                    <label class="label-birthdate">Birthdate</label>
                    <div class="gender-container">
                        <input type="radio" class="gender" name="gender" value="Male" checked><label class="gender-male">Male</label>
                        <input type="radio" class="gender" name="gender" value="Female" ><label class="gender-female">Female</label>
                    </div>

                    <div class="birthdate-container">
                        <input name="birthdate" type="date" class="signup-date">
                    </div>
                    <br>
                    <button name="btn-submit" class="btn-signup">Create an account</button>
                    <?php 
                        if(isset($_POST['btn-submit']))
                        {
                            $fname=$_POST['fname'];
                            $lname=$_POST['lname'];
                            $mobile=$_POST['mobile'];
                            $email=$_POST['email'];
                            $password=$_POST['password'];
                            $gender=$_POST['gender'];
                            $birthdate=$_POST['birthdate'];
                            $id="";
                            
                            if($fname == "" || $lname == "" || $email == "" || $mobile == "" || $password == ""){
                                ?>
                            <script>swal(
                              'Oops...',
                              'Please fill all fields!',
                              'error'
                            );</script>
                    <?php
                            }else{
                            
                            $user="root";
                            $pass="";
                            $db="socialmedia";
                            $server="localhost";
                            
                            $sql="SELECT `email` FROM `user` WHERE `email` LIKE '$email'";
                            $conn = new mysqli($server, $user, $pass, $db);  //open conection
                            if ($conn->connect_error) // make sure that connection is opened
                                die($conn->connect_error);
                             $result = $conn->query($sql); // make mysql execute the command $sql
                             $data = []; //create array
                             while ($row = $result->fetch_assoc()) // btloop 3la 2lresult
                                 $data[] = $row;
                             $conn->close();
                             $validation_mail="";
                            foreach ($data as $value) {
                                  $validation_mail=$value['email'];
                              }
                            if($validation_mail!=""){
                                ?>
                                <script>swal(
                              'Oops...',
                              'Email enterd is already valid!',
                              'error'
                            );</script>
                                <?php
                            }else{
                             
                            $sql="SELECT `counter` FROM `user` WHERE `counter`=(SELECT max(`counter`) FROM `user`)";
                            
                            $conn = new mysqli($server, $user, $pass, $db);  //open conection
                            if ($conn->connect_error) // make sure that connection is opened
                                die($conn->connect_error);
                             $result = $conn->query($sql); // make mysql execute the command $sql
                             $data = []; //create array
                             while ($row = $result->fetch_assoc()) // btloop 3la 2lresult
                                 $data[] = $row;
                             $conn->close();
                             $count=0;
                             $counter=0;
                              foreach ($data as $value) {
                                  $counter=$value['counter'];
                                  $count++;
                              }
                              if($count==0){
                                  $counter=1;
                              }
                              else{
                                  $counter++;
                              }
                              $id=$fname.$counter;
                              
                              $sql="INSERT INTO `user`(`id`, `counter`, `fname`, `lname`, `email`, `mobile`, `password`,`gender`, `birthdate` , `work`) VALUES ('$id','$counter','$fname','$lname','$email','$mobile','$password','$gender','$birthdate','')";
                              $conn = new mysqli($server, $user, $pass, $db);  //open conection
                              if ($conn->connect_error) // make sure that connection is opened
                                  die($conn->connect_error);
                              $result = $conn->query($sql); // make mysql execute the command $sql
                              
                              if($result==1){ //if true inserted
                                   ?>
                            <script>
                                swal("You can login now", "Successfully Signed Up!", "success").then(function(){
                                    location.href = 'index.php';
                                });
                            </script>
                            <?php
                              }
                              else{
                                  ?>
                            <script>swal(
                              'Oops...',
                              'Please fill all fields!',
                              'error'
                            );</script>
                            <?php
                              }
                        }
                        }
                        }
                    ?>
                </form>
            </center>
        </div>
        
        
        <script src="../js/index.js"></script>
    </body>
</html>