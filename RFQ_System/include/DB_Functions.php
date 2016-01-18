<?php

class DB_Functions {
	private $db;
	//put your code here
	// constructor
	function __construct() {
		require_once 'DB_Connect.php';
		// connecting to database
		$this->db = new DB_Connect();
		$this->db->connect();
		}
		// destructor
	function __destruct() {
		
	}
	/**
	* Storing new user
	* returns user details
	*/
	public function storeUser($name, $email, $password) {
		$uuid = uniqid('', true);
		$hash = $this->hashSSHA($password);
		$encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"];// salt
        $result = mysql_query("INSERT INTO users(unique_id, name, email, encrypted_password, salt, created_at) VALUES('$uuid', '$name', '$email', '$encrypted_password', '$salt', NOW())");
		// check for successful store
		if ($result) {
			// get user details
			$uid = mysql_insert_id(); // last inserted id
			$result = mysql_query("SELECT * FROM users WHERE uid = $uid");
			// return user details
			return mysql_fetch_array($result);
			} else {
				return false;
		}
	}

	//-------------------------------List all status's-------------------------------------------------
	public function listAllStatuses($rfqID) {

			$result = mysql_query("SELECT * FROM collaboratorrfqstatus WHERE rfqID = $rfqID");
			// return user details
			$no_of_rows = mysql_num_rows($result);
			if ($no_of_rows > 0) {
				// user existed
				// temp user array
				$response["statusList"] = array();

				while ($row = mysql_fetch_array($result)) {
					// temp user array
					$status = array();
					$status["collaboratorRfqStatusID"] = $row["collaboratorRfqStatusID"];
					$status["resourceID"] = $row["resourceID"];
					$status["rfqID"] = $row["rfqID"];
					$status["status"] = $row["status"];
					$status["comment"] = $row["comment"];
					$status["dateTime"] = $row["dateTime"];

					// push single clinic into final response array
					array_push($response["statusList"], $status);
				}
				return json_encode($response["statusList"]);
			} else {
				// user not existed
				return false;
			}
	}
	//-------------------------------Add Status-------------------------------------------------------
	/**
	 * Storing new status
	 * returns Status details
	 */
	public function storeStatus($resourceID,$rfqID,  $status, $comment) {
		$result = mysql_query("INSERT INTO collaboratorrfqstatus(resourceID, rfqID, status,comment,dateTime) VALUES('$resourceID', '$rfqID', '$status','$comment', NOW())");

		if ($result) {
			// get user details
//			$uid = mysql_insert_id(); // last inserted id
//			$result = mysql_query("SELECT * FROM collaboratorrfqstatus WHERE rfqID = $rfqID");
//			// return user details
//			$no_of_rows = mysql_num_rows($result);
//			if ($no_of_rows > 0) {
//				// user existed
//				// temp user array
//				$response["statusList"] = array();
//
//				while ($row = mysql_fetch_array($result)) {
//					// temp user array
//					$status = array();
//					$status["collaboratorRfqStatusID"] = $row["collaboratorRfqStatusID"];
//					$status["resourceID"] = $row["resourceID"];
//					$status["rfqID"] = $row["rfqID"];
//					$status["status"] = $row["status"];
//					$status["comment"] = $row["comment"];
//					$status["dateTime"] = $row["dateTime"];
//
//					// push single clinic into final response array
//					array_push($response["statusList"], $status);
//				}
//				return json_encode($response["statusList"]);
//			} else {
//				// user not existed
//				return false;
//			}
		} else {
			return false;
		}



	}
	//-------------------------------------------------------------------------------------------

//-----------------------------------get Resource by ID--------------------------------------------------------

	public function getResourceById($resourceID) {
		$result = mysql_query("SELECT * FROM resource WHERE resourceID = '$resourceID'") or die(mysql_error());
		// check for result
		$no_of_rows = mysql_num_rows($result);
		if ($no_of_rows > 0) {
			$result = mysql_fetch_array($result);
				return $result;
		} else {
			// user not found
			return false;
		}
	}
	//-------------------------------Add Team Member-------------------------------------------------------
	/**
	 * Storing new Team Member
	 * returns Team Member details
	 */
	public function storeTeamMember($rfqID, $resourceID, $hours) {
		$result = mysql_query("INSERT INTO team(rfqID, resourceID, hours) VALUES('$rfqID', '$resourceID', '$hours')");
		// check for successful store
		if ($result) {
			// get user details
			$uid = mysql_insert_id(); // last inserted id
			$result = mysql_query("SELECT * FROM team WHERE teamID = $uid");
			// return user details
			return mysql_fetch_array($result);
		} else {
			return false;
		}
	}
	//-------------------------------------------------------------------------------------------
	/**
	* Get user by email and password
	*/
	public function getResourceByEmail($email) {
		$result = mysql_query("SELECT * FROM resource WHERE email = '$email'") or die(mysql_error());
		// check for result
		$no_of_rows = mysql_num_rows($result);
		if ($no_of_rows > 0) {
			$result = mysql_fetch_array($result);
			return $result;
		} else {
			// user not found
			return false;
		}
	}
	/**
	* Check user is existed or not
	*/
	public function isUserExisted($email) {
		$result = mysql_query("SELECT email from users WHERE email = '$email'");
		$no_of_rows = mysql_num_rows($result);
		if ($no_of_rows > 0) {
			// user existed
			return true;
		} else {
			// user not existed
			return false;
		}
	}
	/**
	 * -----------------------list all where rfqid is ?-----------------------------------
	 */
	public function listRfqs($rfqID) {
		// array for JSON response
		$response = array();

		$result = mysql_query("SELECT * from team WHERE rfqID = '$rfqID'");
		$no_of_rows = mysql_num_rows($result);
		if ($no_of_rows > 0) {
			// user existed
			// temp user array
			$response["teamList"] = array();

			while ($row = mysql_fetch_array($result)) {
				// temp user array
				$teamMember = array();
				$teamMember["teamID"] = $row["teamID"];
				$teamMember["rfqID"] = $row["rfqID"];
				$teamMember["resourceID"] = $row["resourceID"];
				$teamMember["hours"] = $row["hours"];

				// push single clinic into final response array
				array_push($response["teamList"], $teamMember);
			}
			return json_encode($response["teamList"]);
		} else {
			// user not existed
			return false;
		}
	}
	//---------------------------------------------------------------------------------


	//Function to list raw data
	public function list_Rfqs() {
// array for JSON response
		$response = array();

		$result = mysql_query("SELECT * from rfq");
		$no_of_rows = mysql_num_rows($result);
		if ($no_of_rows > 0) {
// user existed
// temp user array
			$response["rfqlist"] = array();

			while ($row = mysql_fetch_array($result)) {
// temp user array
				$projects = array();
				$projects["rfqID"] = $row["rfqID"];
				$projects["projectName"] = $row["projectName"];
				$projects["clientName"] = $row["clientName"];
				$projects["brief"] = $row["brief"];
				$projects["name"] = $row["name"];
				$projects["mime"] = $row["mime"];
				$projects["size"] = $row["size"];
				$projects["data"] = $row["data"];
				$projects["created"] = $row["created"];

// push single clinic into final response array
				array_push($response["rfqlist"], $projects);
			}
			return json_encode($response["rfqlist"]);
		} else {
// user not existed
			return false;
		}
	}

	//Function to insert data about a project


	public function insertProjects($projectName, $clientName, $brief,$data) {

		$result = mysql_query("INSERT INTO rfq(projectName, clientName, brief, data) VALUES('$projectName', '$clientName', '$brief','$data')");
// check for successful store
		if ($result) {
// get user details
			$uid = mysql_insert_id(); // last inserted id
			$result = mysql_query("SELECT * FROM rfq WHERE rfqID = $uid");
// return user details
			return mysql_fetch_array($result);
		} else {
			return false;
		}
	}





	/**
	 ************************** Tshepo section Store resources*************************************************
	 *
	 */
	public function storeResource($firstName, $lastName, $email, $category, $charge,$password) {

		$result = mysql_query("INSERT INTO resource(firstName, lastName, email, category, charge, password) VALUES('$firstName', '$lastName', '$email', '$category', '$charge','$password')");
		// check for successful store
		if ($result) {
			// get user details
			$uid = mysql_insert_id(); // last inserted id
			$result = mysql_query("SELECT * FROM resource WHERE resourceID = $uid");
			// return user details
			return mysql_fetch_array($result);
		} else {
			return false;
		}
	}
	//**************************************************************************************************
	/**
	 * ------------------------------Check get resource------------------------------
	 */
	public function getResource($resourceID) {
		$result = mysql_query("SELECT * from resource WHERE resourceID = '$resourceID'");
		$no_of_rows = mysql_num_rows($result);
		if ($no_of_rows > 0) {
			// user existed
			return mysql_fetch_array($result);
		} else {
			// user not existed
			return false;
		}
	}

	/*********************TSHEPO LIST ALL THE RESOURCES *****************************************/
	public function listResource( ) {
// array for JSON response
		$response = array();

		$result = mysql_query("SELECT * from resource ");
		$no_of_rows = mysql_num_rows($result);
		if ($no_of_rows > 0) {
// user existed
// temp user array
			$response["resourceList"] = array();

			while ($row = mysql_fetch_array($result)) {
// temp user array
				$resourceItem = array();
				$resourceItem["resourceID"] = $row["resourceID"];
				$resourceItem["firstName"] = $row["firstName"];
				$resourceItem["lastName"] = $row["lastName"];
				$resourceItem["email"] = $row["email"];
				$resourceItem["charge"] = $row["charge"];
				$resourceItem["category"] = $row["category"];
				$resourceItem["password"] = $row["password"];


// push single clinic into final response array
				array_push($response["resourceList"], $resourceItem);
			}
			return json_encode($response["resourceList"]);
		} else {
// user not existed
			return false;
		}
	}
	//----------------------------------update Resource--------------------------------------------------

	public function updateResource($resourceID,$name, $surname, $email, $categoryType, $rate,$password) {
		$result = "UPDATE resource SET firstName='$name',lastName='$surname',email='$email',category='$categoryType',charge='$rate',password='$password' WHERE resourceID=$resourceID";
		if (mysql_query($result)) {
		echo "Record updated successfully";

			$result = mysql_query("SELECT * from resource WHERE resourceID = '$resourceID'");
			return mysql_fetch_array($result);
		} else {
			echo "Error updating record: " ;
			return false;
		}


}
//updateResource($resourceID,$name, $surname, $email, $categoryType, $rate,$password)
//$sql = "UPDATE MyGuests SET lastname='Doe' WHERE id=2";

//if (mysqli_query($conn, $sql)) {
//echo "Record updated successfully";
//} else {
//	echo "Error updating record: " . mysqli_error($conn);
//}
	//--------------------------------------delete selected--------------------------------------------
	public function deleteSelected($tableName, $ID){

		$primaryKey=$tableName."ID";
		$result = "DELETE FROM $tableName WHERE $primaryKey=$ID";
		if (mysql_query($result)) {
			return true;
		} else {
			return false;
		}

	}
// sql to delete a record
//$sql = "DELETE FROM MyGuests WHERE id=3";
//
//if (mysqli_query($conn, $sql)) {
//echo "Record deleted successfully";
//} else {
//	echo "Error deleting record: " . mysqli_error($conn);
//}
	//------------------------------------------------------------------------------------
	//--------------------------------------delete selected status--------------------------------------------
	public function deleteSelectedStatus($tableName, $idR,$idP){


		$result = "DELETE FROM $tableName WHERE rfqID=$idP AND resourceID=$idR";
		if (mysql_query($result)) {
			return true;
		} else {
			return false;
		}

	}
// sql to delete a record
//$sql = "DELETE FROM MyGuests WHERE id=3";
//
//if (mysqli_query($conn, $sql)) {
//echo "Record deleted successfully";
//} else {
//	echo "Error deleting record: " . mysqli_error($conn);
//}
	//------------------------------------------------------------------------------------
	/**
	* Encrypting password
	* @param password
	* returns salt and encrypted password
	*/
	public function hashSSHA($password) {
		$salt = sha1(rand());
		$salt = substr($salt, 0, 10);
		$encrypted = base64_encode(sha1($password . $salt, true) . $salt);
		$hash = array("salt" => $salt, "encrypted" => $encrypted);
		return $hash;
	}
	/**
	* Decrypting password
	* @param salt, password
	* returns hash string
	*/
	public function checkhashSSHA($salt, $password) {
		$hash = base64_encode(sha1($password . $salt, true) . $salt);
		return $hash;
	}
}

?>