<?php
    session_start(); 
    
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require '../model/user.php';

if(isset($_POST['btn-signup'])){
    $firstName=$_POST['firstname'];
    $lastName=$_POST['lastname'];
    $email=$_POST['email'];
    $mobile=$_POST['mobile'];
    $password=$_POST['password'];
    $confirmPass=$_POST['confirm-password'];
    $gender=$_POST['gender'];
    $birthdate=$_POST['birthdate'];
    $longitude=0;
    $latitude=0;
    $work="";
    
    $myArray = str_split($firstName);
    $space=1;

    foreach($myArray as $character){
        if($character==" "){
            $space=0;
            break;
        }
    }
    
    if($firstName=="" || $lastName=="" || $email=="" || $mobile=="" || $password=="" || $gender=="" || $birthdate==""){
        ?>
        <script>
            swal('Oops...','Please fill all fields!','error');
        </script>
        <?php
    }else if($space==0){
        $_SESSION['result'] = 2;
        $_SESSION['firstname'] = "";
        $_SESSION['lastname'] = $lastName;
        $_SESSION['email'] = $email;
        $_SESSION['mobile'] = $mobile;
        $_SESSION['password'] = $password;
        $_SESSION['confirmPass'] = $confirmPass;
        $_SESSION['gender'] = $gender;
        $_SESSION['birthdate'] = $birthdate;
        header("Location: ../viewer/index.php");
    }else if($password!=$confirmPass){
        $_SESSION['result'] = 8;
        $_SESSION['firstname'] = $firstName;
        $_SESSION['lastname'] = $lastName;
        $_SESSION['email'] = $email;
        $_SESSION['mobile'] = $mobile;
        $_SESSION['password'] = "";
        $_SESSION['confirmPass'] = "";
        $_SESSION['gender'] = $gender;
        $_SESSION['birthdate'] = $birthdate;
        header("Location: ../viewer/index.php");
    }else{
        $newuser = new user();
        $data = array($firstName, $lastName, $email, $mobile, $password, $gender, $birthdate, $work,$longitude,$latitude);
        $result=$newuser->create($data);
        if($result==1){
            $id= $newuser->getUserID($email);
            $_SESSION['userID'] = $id;
            $_SESSION['result'] = 3;
            $_SESSION['firstname'] = "";
            $_SESSION['lastname'] = "";
            $_SESSION['email'] = "";
            $_SESSION['mobile'] = "";
            $_SESSION['password'] = "";
            $_SESSION['confirmPass'] = "";
            $_SESSION['gender'] = "";
            $_SESSION['birthdate'] = "";
            $_SESSION['login']=TRUE;
            header("Location: ../viewer/settings.php");
        }
        else{
            $_SESSION['result'] = 7;
            $_SESSION['firstname'] = $firstName;
            $_SESSION['lastname'] = $lastName;
            $_SESSION['email'] = "";
            $_SESSION['mobile'] = $mobile;
            $_SESSION['password'] = $password;
            $_SESSION['confirmPass'] = $confirmPass;
            $_SESSION['gender'] = $gender;
            $_SESSION['birthdate'] = $birthdate;
            header("Location: ../viewer/index.php");
        }
    }
}
?>
