<?php
function getDBConn() {	
	require "variables.php";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	return $conn;
}

function getDataFromTable($table, $field_to_retrieve_array, $condition_field="", $condition_value="", $where="") {	
	// $field_to_retrieve_array - Can be an array, can be '*' or can be one field name.
	$conn = getDBConn();
	$resultData = array();
	/*$conn=mysqli_connect($servername,$username,$password,$dbname);
	// Check connection
	if (mysqli_connect_errno())  {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}*/
	if(is_array($field_to_retrieve_array)) {
		if(isset($field_to_retrieve_array) && count($field_to_retrieve_array) > 0) {
			$field_to_retrieve = implode(",",$field_to_retrieve_array);
		}
	} else {
		$field_to_retrieve = $field_to_retrieve_array;	
	}
	if(trim($condition_field) != '' && trim($condition_value) != '') {
		$sql="SELECT $field_to_retrieve FROM $table WHERE $condition_field = '$condition_value' $where";
	} else {
		$sql="SELECT $field_to_retrieve FROM $table $where";
	}
	if ($result=mysqli_query($conn,$sql))  {	  	  

		if( is_array($field_to_retrieve_array) || trim($field_to_retrieve_array) == '*') {
			while ($row = $result->fetch_assoc()) {				
				if( @trim($field_to_retrieve_array) == '*') {
					$resultData[] = $row;
				} else {
					$id_key = $field_to_retrieve_array[0];			
					foreach($field_to_retrieve_array as $field_to_retrieve) {			
						$resultData[$row[$id_key]][$field_to_retrieve] = $row[$field_to_retrieve];
					}
				}
			}
		} else {
			while ($row = $result->fetch_assoc()) {
				$resultData[] = $row[$field_to_retrieve];
			}
		}	
	}	  
	// Free result set
	mysqli_free_result($result);
	mysqli_close($conn);	
	return count($resultData)? $resultData : NULL;
}

function encryptPassword($string) {
	$key = 'password to (en/de)crypt';		
	$iv = mcrypt_create_iv(
		mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC),
		MCRYPT_DEV_URANDOM
	);
	$encrypted = base64_encode(
		$iv .
		mcrypt_encrypt(
			MCRYPT_RIJNDAEL_128,
			hash('sha256', $key, true),
			$string,
			MCRYPT_MODE_CBC,
			$iv
		)
	);
	return $encrypted;	
}

function decryptPassword($encrypted) {
	$key = 'password to (en/de)crypt';	
	$data = base64_decode($encrypted);
	$iv = substr($data, 0, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC));
	$decrypted = rtrim(
		mcrypt_decrypt(
			MCRYPT_RIJNDAEL_128,
			hash('sha256', $key, true),
			substr($data, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC)),
			MCRYPT_MODE_CBC,
			$iv
		),
		"\0"
	);
	return $decrypted;	
}

function processUserFund($user_id, $fund_deposit) {
		$conn = getDBConn();
	
		$fields_to_get 			= "balance";
		$balanceData 			= getDataFromTable('users_fund', $fields_to_get, 'users_id', $user_id);
		
		if (isset($balanceData) && count($balanceData) > 0) {	//Update balance
			
			$stmt = $conn->prepare("UPDATE users_fund SET balance=? WHERE users_id = ?");
			
			//set parameters
			$user_id 				= $user_id;
			$balance 				= $fund_deposit + $balanceData[0];	
			
			//bind
			$stmt->bind_param("di", $balance, $user_id);							

			//execute
			$status = $stmt->execute();	
			
			return $status;
	
		} else { //Insert a new entry
			$stmt = $conn->prepare("INSERT INTO users_fund (users_id, balance, monthly_deduction) VALUES (?, ?, ?)");
			//bind
			$stmt->bind_param("idi", $user_id, $fund_deposit, $monthly_deduction);

			//set parameters
			$user_id 				= $user_id;
			$balance 				= $fund_deposit;
			$monthly_deduction 		= 100;
			
			//execute
			$status = $stmt->execute();	
			
			return $status;
		}
		
		$conn->close();	
}


?>