<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=divice-width, initial-scale=1.0, maximum-scale=1.0">

	<title>Team</title>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link href="css/normalize.css" rel="stylesheet" media="screen">
	<link href="css/foundation.min.css" rel="stylesheet" media="screen">
	<link href="css/app-screen.css" rel="stylesheet" media="screen">
	<link href="css/app-print.css" rel="stylesheet" media="print">
	<script src="js/angular.min.js"></script>
	<script src="js/angular-mocks.js"></script>
	<script src="js/shopping-list.js"></script>
	</head>


<html ng-app="myApp">
<?php
session_start();
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
//echo $_SESSION['USER']['firstName'];
//echo $_SESSION['USER']['email'];
//echo $_SESSION['USER']['resourceID'];
//echo $_SESSION['RFQID'];
?>

<body ng-controller="ShoppingListController">


<div class="row" >

        <!---------------------------------------------------Navigation---------------------------------------------------------------------------------->
        <dl class="sub-nav">
            <dt><i class="fa fa-arrow-right"></i></dt>
            <dd ><a href="rfq.php">RFQ's</a></dd>
            <dd ><a href="resource.php">Resources</a></dd>
            <dd ><a href="profile.php">Profile</a></dd>
            <dd ><a href="logout.php">Logout</a></dd>

    <div class="column" >
        <h1>Add Team member</h1>
        <?php
        @$del = $_GET['del'];
        if($del=='yes'){
            $tableName="team";

            $idR=$_GET['id'];
            $idP=$_SESSION['RFQID'];

            if($db->deleteSelectedStatus($tableName, $idR,$idP)){

            }else{
                echo "could not delete";
            }

        }
        ?>

           <div class="row">
               <div class="column">

                   <?php

                           @$resource = $_POST['resource'];
                           @$hours = $_POST['hours'];

                            if(isset($_POST['add'])){


//                                Validating Form
                                if($resource =="Select Resource" || $hours =="Select Hours"){
                                    echo "<h6 class='subheader warning'> Insert all fields</h6>";
                                }else{
//                                  inserting into database--------------------------------------------------------------------------------------------
                                    $user = $db->storeTeamMember($_SESSION['RFQID'],$resource, $hours);

                                    if ($user) {
                                        echo "Team member added";
                                    }else{
                                        echo "<h6 class='subheader warning'> Error inserting into database</h6>";
                                    }

                                }

                            }
                   ?>
               </div>
           </div>
        <form  action="?" method="post">
           <div class="row">
               <div class="large-8 columns">
                   <select
                       name="resource">
                       <option value="Select Resource">Select Resource</option>
                   <?php
                   $json_arrayR = json_decode($db->listResource(), true);
                   foreach($json_arrayR as $jsonR) {
                        echo "---->".$jsonR['resourceID'];
                       echo "<option value=". $jsonR['resourceID'].">". $jsonR['firstName'] . "</option>";


                   }
                   ?>


                   </select>
               </div>
               <div class="large-2 columns">

                   <input type="text"
                           name="hours" >


               </div>
               <div class="large-2 columns">
                            <!------------------------ADD BUTTON-------------------------->
                           <button
                                   type="submit"
                                   value="submit"
                                   name="add"
                                   class="small button expand button">
                               <i class="fa fa-plus"> Add <div class="show-for-medium-down"> Member</div></i></button>


               </div>
           </div>




            <!--Project Data-->

        </form>

        <div class="row">
                <div class="columns">
                    <span class="secondary radius label"><h6 ><?php echo $_SESSION['PROJECTNAME']; ?></h6></span><br><?php echo"<span class='calc'>". $_SESSION['BRIEF']."</span>"; ?><br>
                </div>
            </div>

        <div class="row">
            <div class="columns">
<!--                //--------------------------------------row1-->
<!--                check is function returns anything-->
                <?php if(json_decode($db->listRfqs($_SESSION['RFQID']), true)){  ?>
                <div class="row">
                    <div class="column small-6">
                        <b>Team</b>
                    </div>
                    <div class="column small-3">
                        <b>Cost</b>
                    </div>
                    <div class="column small-3">
                        <b></b>
                    </div>
                </div>
<!--                //--------------------------------------row2------------------------------------>


                <?php
                $total = 0;

                    if($db->listRfqs($_SESSION['RFQID'])){
//                listRfqs($rfqID)-------------------------------------------------------------
                    @$json_array = json_decode($db->listRfqs($_SESSION['RFQID']), true);
                    foreach($json_array as $json) {

                    $resource = $db->getResource($json['resourceID']);
                ?>
<!--                //---------------------------------------looping while entering displaying data----------------------->
                <div class="row">
                    <div class="column small-6">
                        <?php
                        if($resource["category"]=="developer"){
                            echo "<span class=' [radius] label expand small-12'>". $resource['firstName']. " " . $resource["lastName"]." </span>";
                        }else if($resource["category"]=="designer"){
                            echo "<span class='success round label expand small-12'>". $resource['firstName']. " " . $resource["lastName"]." </span>";
                        }else{
                            echo "<span class='[success] [radius] label small-12'>". $resource['firstName']. " " . $resource["lastName"]." </span>";
                        }
                        ?>
                    </div>
                    <div class="column small-3">
<!--                        // calculating costs-->
                        <?php
                        $myCost=$resource['charge'] * $json['hours'];
                        $total = $total + $myCost;
                        echo"<span class='calc'>". $json['hours']."hr(s)<div class='show-for-small-only'><br></div></span> <h6 class='small label'>R ". $myCost ."</h6>"
                        ?>
                    </div>
                    <div class="column small-3">
                        <?php echo "<a href='?id=".  $resource['resourceID']."&del=yes'>Delete</a>"; ?>
                    </div>
                </div>

                <?php
                }
                ?>
<!--                row displaying the total-->
                <div class="row">
                    <div class="column small-6">
                        <?php echo "<br><span class='calc'><b>Total Project Cost</b></span>" ; ?>
                    </div>
                    <div class="column small-3">
                        <?php echo "<br><span class='calc'><u><b>R ".  $total ."</b></u></span>"; ?>
                    </div>
                    <div class="column small-3">
                    </div>
                </div>
                <?php } }?>
                <br>
<!--                row listing all the comments-->
                <div class="row">
                    <div class="column small-12">

                        <?php
                        @$status = $_POST['status'];
                        @$commentBOX = $_POST['commentBOX'];
                        $statusVal = "";

                        if(isset($_POST['comment'])){
//                                Validating Form
                            if($status =="Select status" ){

                                $statusVal="<div class='subheader warning'>insert status</div>";
                            }else{
                                //inserting into database
                                //---------------------------------------storeStatus($resourceID,$rfqID,  $status, $comment)-----------------------------------------------------------------------------------
                                $db->storeStatus($_SESSION['USER']['resourceID'],$_SESSION['RFQID'],  $status, $commentBOX);


                            }
                        }
                        //listing all statuses
                        //---------------------------------------listAllStatuses($rfqID)----------------------------------------------------------------------------------
                        if(json_decode($db->listAllStatuses($_SESSION['RFQID']), true)){
                            //---------------------------------------listAllStatuses($rfqID)----------------------------------------------------------------------------------
                        @$json_array_status = json_decode($db->listAllStatuses($_SESSION['RFQID']), true);
                        foreach($json_array_status as $jsonI) {
                            $person = $db->getResourceById($jsonI['resourceID']);
                            //echo $jsonI['comment']
                                echo"<span class='calc'><b>". $person['firstName']." " .$person['lastName']. "</b>[<i style='color:red'>".$jsonI['dateTime']."</i>]<b>".$jsonI['status']."</b> : ".$jsonI['comment']. "</span><br>";
                        }
                        }
                        ?>

                    </div>
                </div>
                <div class="row">
                    <div class="column small-12">
                        <?php echo @$statusVal; ?>
                    </div>
                </div>

                <div class="row">
                    <div class="column small-12">
                        <form action="?" method="post">
                            <select
                                name="status">
                                <option value="Select status">Select status</option>
                                <option value="agree">agree</option>
                                <option value="dontAgree">dont agree</option>
                            </select>
                            <textarea name="commentBOX" class="small-12" placeholder="comment"></textarea>



                            <button
                                type="submit"
                                value="submit"
                                name="comment"
                                class="small button expand button">
                                <i class="fa fa-plus"> Comment</i></button>
                        </form>
                    </div>
                </div>

            </div>
            <div class="row">
                <!---------------------------------------------------Navigation---------------------------------------------------------------------------------->
                <dl class="sub-nav">
                    <dt><i class="fa fa-arrow-right"></i></dt>
                    <dd ><a href="rfq.php">RFQ's</a></dd>
                    <dd ><a href="resource.php">Resources</a></dd>
                    <dd ><a href="profile.php">Profile</a></dd>
                    <dd ><a href="logout.php">Logout</a></dd>

            </div>
</body>
</html>