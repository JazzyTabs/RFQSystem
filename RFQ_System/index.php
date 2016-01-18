<!DOCTYPE html>
<html ng-app="myApp">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=divice-width, initial-scale=1.0, maximum-scale=1.0">

    <title>LogIn</title>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link href="css/normalize.css" rel="stylesheet" media="screen">
    <link href="css/foundation.min.css" rel="stylesheet" media="screen">
    <link href="css/app-screen.css" rel="stylesheet" media="screen">
    <link href="css/app-print.css" rel="stylesheet" media="print">
    <script src="js/angular.min.js"></script>
    <script src="js/angular-mocks.js"></script>
    <script src="js/shopping-list.js"></script>
</head>


<?php
session_start();
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
?>


<body class="loginS">


<div class="row">

    <div class="column">
        <h1>Login</h1><br>

        <?php
            if(isset($_POST['login'])){
                $username = $_POST['username'];
                $password = $_POST['password'];
                if($username=="" || $password==""){
                    echo "<h6 class='subheader warning'>Insert all fields</h6>";
                }else{
                    $user = $db->getResourceByEmail($username);
                    if($user){
                        if($password == $user['password']){

                            $_SESSION["USER"] = $user;
                           header("Location: rfq.php");


                        }else{
                            echo "<h6 class='subheader warning'>wrong password</h6>";
                        }
                    }else{
                        echo "<h6 class='subheader warning'>User doesn't exist</h6>";
                    }
                }
            }
            if(isset($_POST['forgotpassword'])){
                echo "bad";
            }
        ?>

        <form  action="?" method="post">

<!--                user name row-->
            <div class="row">
                <div class="large-6 columns">
                    <input
                        type="text"
                        name="username"
                        placeholder="username">
                </div>
                <div class="large-4 columns">
                </div>
                <div class="large-2 columns">
                </div>
            </div>
<!--             password row-->
            <div class="row">
                    <div class="large-6 columns">
                        <input
                            type="password"
                            name="password"
                            placeholder="password">
                    </div>
                    <div class="large-4 columns">
                    </div>
                    <div class="large-2 columns">
                    </div>
            </div>
            <div class="row">
                <div class="medium-6 large-3 column">
                    <button
                        type="submit"
                        name="login"
                        class="small expand button primary">
                        <i class="fa fa-print"> Login</i></button>
                </div>
                <div class="medium-6 large-3 column">
                    <button
                        type="submit"
                        name="forgotpassword"
                        class="small expand button alert">
                        <i class="fa fa-times"> Forgot Password</i></button>

                </div>
                <div class="medium-0 large-6 column">
                </div>


            </div>
        </form>



    </div>

</div>



</body>
</html>