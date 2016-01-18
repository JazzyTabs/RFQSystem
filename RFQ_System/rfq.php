<!DOCTYPE html>
<html ng-app="myApp">
<?php
session_start();
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" http-equiv="content-type" content="width=divice-width, initial-scale=1.0, maximum-scale=1.0">
    <title>RFQ</title>
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
        <dd class="active"><a href="rfq.php">RFQ's</a></dd>
        <dd ><a href="resource.php">Resources</a></dd>
        <dd ><a href="profile.php">Profile</a></dd>
        <dd ><a href="logout.php">Logout</a></dd>
    </dl>
    <?php
    @$del = $_GET['del'];
    if($del=='yes'){
        $tableName="rfq";

        $id=$_GET['id'];
        if($db->deleteSelected($tableName, $id)){

        }else{
            echo "could not delete";
        }

    }
    ?>
    <!--    ---------------------------------------------------------------------------------------------------------------------------------->
    <div class="column">

        <h1>Add Project</h1>

        <div class="row">
            <div class="column">

                <!--------<span class="spanLabel" ng-show="isNumberOfCharactersWithinRange()">Remaining Characters : {{ howManyCharactersRemaining() }}</span>-->
                <?php

                //echo "-.$doc_upload."<---";
                @$viewD = $_GET['details'];
                if($viewD){
                    $_SESSION['RFQID']= $_GET['id'];
                    $_SESSION['PROJECTNAME']=$_GET['name'];
                    $_SESSION['BRIEF']=$_GET['discr'];

                    header("Location: team.php");
                }

                if(isset($_POST['add'])){

                    $clientName = $_POST['c_name'];
                    $projectName = $_POST['p_name'];
                    $brief = $_POST['p_brief'];
                    if($clientName == "" || $projectName == "")  {
                        echo "<span class='spanLabel warning' > Please enter data</span>";
                    }else{

                        if(isset($_FILES['uploaded_file'])) {
                            $dbLink = new mysqli('127.0.0.1', 'admin', '123', 'empire');
                            if ($_FILES['uploaded_file']['error'] == 0) {

                                // Connect to the database

                                if (mysqli_connect_errno()) {
                                    die("MySQL connection failed: " . mysqli_connect_error());
                                }


                                // Gather all required data
                                $name = $dbLink->real_escape_string($_FILES['uploaded_file']['name']);
                                $mime = $dbLink->real_escape_string($_FILES['uploaded_file']['type']);
                                $data = $dbLink->real_escape_string(file_get_contents($_FILES  ['uploaded_file']['tmp_name']));
                                $size = intval($_FILES['uploaded_file']['size']);

                                // Create the SQL query
                                $query = "INSERT INTO `rfq` (`projectName`,`clientName`,`brief`,`name`, `mime`, `size`, `data`, `created`)VALUES ('{$projectName}','{$clientName}','{$brief}','{$name}', '{$mime}', {$size}, '{$data}', NOW())";

                                // Execute the query
                                $result = $dbLink->query($query);

                                // Check if it was successfull
                                if ($result) {
                                    echo 'Success! Your file was successfully added!';
                                } else {
                                    echo 'Error! Failed to insert the file'
                                        . "<pre>{$dbLink->error}</pre>";
                                }


                            } else {
                                echo 'An error accured while the file was being uploaded. '. 'Error code: ' . intval($_FILES['uploaded_file']['error']);
                            }
                            // Close the mysql connection
                            $dbLink->close();
                            //header("Location: rfq.php");
                        }
                    }

                }
//                    //Validating if form has been added
//
//
//                    @$clientName = $_POST['c_name'];
//                    @$projectName = $_POST['p_name'];
//                    @$brief = $_POST['p_brief'];
//                    @$data = $_POST['doc_upload'];
//
//                    //unknown
//                    @$totalAmount;
//                    @$fileName;
//                    @$size;
//                    @$dateMade;
//
//                    if($clientName == "" || $projectName == "")  {
//
//                            echo "<span class='spanLabel warning' > Please enter data</span>";}
//
//                        else
//                            //insert into a database
//                        {
//                            $rfq = $db->insertProjects($projectName, $clientName, $brief, $data);
//                            if ($rfq){
//                                echo "################Inserted################";
//                            }else {
//                                echo "Nothing is working";
//                            }
//                        }
//
//
//                }

                //  Inserting code



                ?>

            </div>
        </div>
        <form action="?" method="post" enctype="multipart/form-data">
        <div class="row">
            <!----------------Clients Name--------------------------->
            <div class="large-6 columns">
                 <input
                    type="text"
                    name="c_name"
                    placeholder="Clients Name" >
            </div>
            <!----------------Project Name--------------------------->
            <div class="large-6 columns">
                <input
                    type="text"
                    name="p_name"
                    placeholder="Project Name">
            </div>
            <!----------------Brief Description---------------------->
            <div class="large-12 columns">
                <div class="show-for-medium-up"></div><textarea placeholder="Description" rows="4" padding cols="50" name="p_brief" value="p_brief"></textarea>
            </div>
            <div class="large-12 columns">
                <!----------------Upload File--------------------------->
                <input type="file" name="uploaded_file" >

            </div>
        </div>
        <div class="row">
            <div class="column">
                <div class="show-for-medium-up">


                    <!-----------------------Add Button------------->
                    <button
                        type="submit"
                        class="small button"
                        name="add"
                        value="add_project">
                        <i class="fa fa-plus"> Add</i></button>

                    <button
                        type="submit"
                        class="small button secondary"
                        name="btn_clear_entry">
                        <i class="fa fa-ban"> Clear Entry</i></button>

                </div>

                <div class="show-for-small-only">
                    <ul class="button-group even-2">
                        <li>
                            <button
                                type="submit"
                                name="add"
                                class="small button">
                                <i class="fa fa-plus"> Add</i></button>
                        </li>
                        <li>
                            <button
                                type="submit"
                                class="small button secondary">
                                <i class="fa fa-ban"> Clear</i></button>
                        </li>

                    </ul>
                </div>

            </div>

        </div>

        </form>


            <?php
            //$db = new DB_Functions();
//            if($db->list_Rfqs()){

//            $json_array = json_decode($db->list_Rfqs(), true);
//            foreach($json_array as $json){


            //--------------------------------------------------------------------------------------------------
            // Connect to the database
            $dbLink = new mysqli('127.0.0.1', 'admin', '123', 'empire');
            if(mysqli_connect_errno()) {
                die("MySQL connection failed: ". mysqli_connect_error());
            }

            // Query for a list of all existing files
            $sql = 'SELECT `rfqID`,`brief`, `projectName`,`clientName`,`name`, `mime`, `size`, `created` FROM `rfq`';
            $result = $dbLink->query($sql);

            // Check if it was successfull
            if($result) {
                // Make sure there are some files in there
                if($result->num_rows == 0) {
                    echo '<p>There are no files in the database</p>';
                }
                else {
                    // Print the top of a table


                    // Print each file
                    while($row = $result->fetch_assoc()) {
                        ?>

<!--            //--------------------------------------------------------------------------------------------------->


            <span class='calc'>
                <div class="row">
                    <div class="small-3 columns">



                        <?php echo "<a href='?details=yes&id=".$row['rfqID']."&name=". $row['projectName'] ."&discr=".$row['brief']."'>". $row['projectName'] ."</a>";?>

                    </div>

                    <div class="small-3 columns ">

                        <?php
                        echo $row['clientName'];
                        ?>
                    </div>
                    <div class="small-3 columns ">
                        <?php echo "<a href='?id={$row['rfqID']}&del=yes'>Delete</a>" ?>
                    </div>
                    <div class="small-3 columns ">
                        <?php echo "<a href='get_file.php?id={$row['rfqID']}'>Download</a>"?>
                    </div>
                </div>
            </span>
<?php
}

// Close table
echo '</table>';
}

// Free the result
$result->free();
}
else
{
    echo 'Error! SQL query failed:';
    echo "<pre>{$dbLink->error}</pre>";
}

// Close the mysql connection
$dbLink->close();
?>


        <br />

    </div>

</div>
<div class="row">
    <!---------------------------------------------------Navigation---------------------------------------------------------------------------------->
    <dl class="sub-nav">
        <dt><i class="fa fa-arrow-right"></i></dt>
        <dd class="active"><a href="rfq.php">RFQ's</a></dd>
        <dd ><a href="resource.php">Resources</a></dd>
        <dd ><a href="profile.php">Profile</a></dd>
        <dd ><a href="logout.php">Logout</a></dd>
    </dl>
    <!--    ---------------------------------------------------------------------------------------------------------------------------------->
</div>

</body>
</html>