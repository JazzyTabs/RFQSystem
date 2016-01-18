<!DOCTYPE html>
<html ng-app="myApp">
<?php
error_reporting(0);
    require_once 'include/DB_Functions.php';
    $db = new DB_Functions();
?>


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=divice-width, initial-scale=1.0, maximum-scale=1.0">
    <title>Making Resourse</title>
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
        <dd class="active"><a href="resource.php">Resources</a></dd>
        <dd ><a href="profile.php">Profile</a></dd>
        <dd ><a href="logout.php">Logout</a></dd>
    </dl>
    <!--    ---------------------------------------------------------------------------------------------------------------------------------->

    <div class="column">
        <h3>Add Resource</h3>

        <!------------------------------------------Inserting the php code ----------------------------------------------------->
        <?php

        if (isset($_POST['add'])) {

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
                $resource = $db->storeResource($name, $surname, $email, $categoryType, $rate,$password);
                header("Location: resource.php");

                if( $resource)
                {
                    echo $resource["firstName"]." Has been added to database";

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


                        placeholder="Name">
                </div>


                <div class="large-6 columns">
                    <input
                        type="text"
                        name="surname"
                        placeholder="Surname">
                </div>

            </div>

            <div class="row">

                <div class="large-6 columns">
                    <input
                        type="text"
                        name="email"
                        placeholder="Email">
                </div>
                <div class="large-6 column">
                    <input
                        type="password"
                        name="password"
                        placeholder="password">
                </div>
            </div>


            <div class="row">

                <div class="large-6 columns">
                    <input
                        type="text"
                        name="rate"
                        placeholder="Rate">
                </div>


                <div class="large-6 columns">
                    <select
                        name="categoryType">
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
                        <button type="submit" class="small button" value="submit" name="add">
                            <i class="fa fa-plus"> Add</i></button>


                    </div>

                    <!----------------------------------------When viewing on small screen----------------------------------------------->
                    <div class="show-for-small-only">

                                <button
                                    name="add"
                                    type="submit"
                                    class="small button expand">
                                    <i class="fa fa-plus">Add</i></button>



                    </div>
                    <!------------------------------Closing ------------------------------------------------------------------------------>
                </div>

            </div>

        </form>
        <!---------------------------------------------function to delete a record-------------------------------------------->
        <?php
            $del = $_GET['del'];
            if($del=='yes'){
                $tableName="resource";

                $id=$_GET['id'];
                if($db->deleteSelected($tableName, $id)){

                }else{
                    echo "could not delete";
                }

            }
        ?>

        <!---------------------------------------------closing the php code------------------------------------------->




            <?php
            $json_array = json_decode($db->listResource(), true);
            foreach($json_array as $json) {
                ?>

<!--                <div class="show-for-medium-up">-->
                <div class="row">
                    <div class="small-3 columns ">

                        <?php
                        echo "<span class='calc'>".$json['firstName']."</span>";
                        ?>


                    </div>
                    <div class="small-3 columns ">

                        <?php
                        echo "<span class='calc'>".$json['lastName']."</span>";
                        ?>
                    </div>
                    <div class="small-3 columns ">

                        <?php
                        echo "<span class='calc'>".$json['category']."</span>";
                        ?>
                    </div>


                    <div class="small-3 columns ">

                        <?php
                        echo "<span class='calc'><a href='?id=". $json['resourceID'] ."&del=yes'>Delete</a></span>";
                        ?>

                    </div>



                </div>
            <?php
                }

            ?>

        <br><br>
    </div>

    <!---------------------------------------------------Navigation---------------------------------------------------------------------------------->
    <dl class="sub-nav">
        <dt><i class="fa fa-arrow-right"></i></dt>
        <dd ><a href="rfq.php">RFQ's</a></dd>
        <dd class="active"><a href="resource.php">Resources</a></dd>
        <dd ><a href="profile.php">Profile</a></dd>
        <dd ><a href="logout.php">Logout</a></dd>
    </dl>
    <!--    ---------------------------------------------------------------------------------------------------------------------------------->

</div>


</body>
</html>