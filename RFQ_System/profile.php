<!DOCTYPE html>
<html ng-app="myApp">
<?php
session_start();
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
?>


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=divice-width, initial-scale=1.0, maximum-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link href="css/normalize.css" rel="stylesheet" media="screen">
    <link href="css/foundation.min.css" rel="stylesheet" media="screen">
    <link href="css/app-screen.css" rel="stylesheet" media="screen">
    <link href="css/app-print.css" rel="stylesheet" media="print">
    <script src="js/angular.min.js"></script>
    <script src="js/angular-mocks.js"></script>
    <script src="js/shopping-list.js"></script>
</head>
<body >


<div class="row">
    <!---------------------------------------------------Navigation---------------------------------------------------------------------------------->
    <dl class="sub-nav">
        <dt><i class="fa fa-arrow-right"></i></dt>
        <dd ><a href="rfq.php">RFQ's</a></dd>
        <dd ><a href="resource.php">Resources</a></dd>
        <dd class="active"><a href="profile.php">Profile</a></dd>
        <dd ><a href="logout.php">Logout</a></dd>
    </dl>
    <!--    ---------------------------------------------------------------------------------------------------------------------------------->

    <div class="column">
        <h3>Update Profile</h3>

        <!------------------------------------------Inserting the php code ----------------------------------------------------->
        <?php

        if (isset($_POST['update'])) {

            $name = $_POST['name'];
            $surname = $_POST['surname'];
            $email = $_POST['email'];
            $rate = $_POST['rate'];
            $password = $_POST['password'];
            $categoryType = $_POST['categoryType'];

            // Validating fields
            if (($name == "" || $surname == "" || $email == "" || $rate == "" || $password=="" || $categoryType == "category")) {
                echo "<h6 class=' warning' >Enter required fields</h6>";
            } else {
                //Inserting into the database
                $resource = $db->updateResource($_SESSION['USER']['resourceID'],$name, $surname, $email, $categoryType, $rate,$password);
                $_SESSION['USER']= $resource;
                //header("Location: resource.php");

                if( $resource)
                {


                }else{
                    echo"<h6 class='warning'> Failed to insert </h6>";
                }
            }

        }

        ?>

        <!---------------------------------------end php code------------------------------------------------------------------->


        <form  method="post" action="?">
            <div class="row">

            </div>
            <!-----------------------------View using a large screen and medium screen--------------------------------------------->
            <div class="row">
                <div class="large-6 columns">
                    <input
                        type="text"
                        name="name"
                        value="<?php echo $_SESSION['USER']['firstName'] ?>"

                        placeholder="Name">
                </div>


                <div class="large-6 columns">
                    <input
                        type="text"
                        name="surname"
                        value="<?php echo $_SESSION['USER']['lastName']?>"
                        placeholder="Surname">
                </div>

            </div>

            <div class="row">

                <div class="large-6 columns">
                    <input
                        type="text"
                        name="email"
                        value="<?php echo $_SESSION['USER']['email']?>"
                        placeholder="Email">
                </div>
                <div class="large-6 column">
                    <input
                        type="password"
                        name="password"
                        value="<?php echo $_SESSION['USER']['password']?>"
                        placeholder="password">
                </div>
            </div>


            <div class="row">

                <div class="large-6 columns">
                    <input
                        type="text"
                        name="rate"
                        value="<?php echo $_SESSION['USER']['charge']?>"
                        placeholder="Rate">
                </div>


                <div class="large-6 columns">
                    <select
                        name="categoryType">
                        <option value="<?php echo $_SESSION['USER']['category']?>"><?php echo $_SESSION['USER']['category']?></option>
                        <option value="category">Category</option>
                        <option value="designer">designer</option>
                        <option value="developer">developer</option>
                        <option value="COO">COO</option>
                        <option value="CFO">CFO</option>
                        <option value="CEO">CEO</option>
                    </select>
                </div>


            </div>


            <div class="row">
                <div class="column">
                    <div class="show-for-medium-up">

                        <!--/-----------------------------------Submit button resources------------------------------------------------------>
                        <button type="submit" class="small button" value="submit" name="update">
                            <i class="fa fa-plus"> Update Profile</i></button>


                    </div>

                    <!----------------------------------------When viewing on small screen----------------------------------------------->
                    <div class="show-for-small-only">

                        <button
                            name="update"
                            type="submit"
                            class="small button expand">
                            <i class="fa fa-plus">Add</i></button>



                    </div>
                    <!------------------------------Closing ------------------------------------------------------------------------------>
                </div>

            </div>

        </form>
        <!---------------------------------------------opeining the php code-------------------------------------------->


        <!---------------------------------------------closing the php code------------------------------------------->

        <div class="row">

            <div class="small-12 column">Your Profile</div>
        </div><br>
        <span class='calc'>
        <div class="row">
            <div class="small-3 column">First Name</div>
            <div class="small-9 column"><?php echo $_SESSION['USER']['firstName']; ?></div>
        </div>
        <div class="row">
            <div class="small-3 column">Last Name</div>
            <div class="small-9 column"><?php echo $_SESSION['USER']['lastName']; ?></div>
        </div>
        <div class="row">
            <div class="small-3 column">email</div>
            <div class="small-9 column"><?php echo $_SESSION['USER']['email']; ?></div>
        </div>
        <div class="row">
            <div class="small-3 column">category</div>
            <div class="small-9 column"><?php echo $_SESSION['USER']['category']; ?></div>
        </div>
        <div class="row">
            <div class="small-3 column">charge</div>
            <div class="small-9 column"><?php echo $_SESSION['USER']['charge']; ?> per hour</div>

        </div>
        </span>


        <br > <br>
    </div>

        <!---------------------------------------------------Navigation---------------------------------------------------------------------------------->
        <dl class="sub-nav">
            <dt><i class="fa fa-arrow-right"></i></dt>
            <dd ><a href="rfq.php">RFQ's</a></dd>
            <dd ><a href="resource.php">Resources</a></dd>
            <dd class="active"><a href="profile.php">Profile</a></dd>
            <dd ><a href="logout.php">Logout</a></dd>
        </dl>
        <!--    ---------------------------------------------------------------------------------------------------------------------------------->



</div>


</body>
</html>