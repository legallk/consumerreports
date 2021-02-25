<?php

	// SQL QUERY TO GENERATE 
	// CREATE TABLE data ( id varchar(50) primary key, date_created datetime, user_string varchar(50), results varchar(50))

	// Set Parameters to Establish Connection
	$host = "localhost";
	$username = "kevin";
	$password = "abc123";
	$database = "consumersreports";
	$table = "data";

	// Create Connection
	$conn = new mysqli($host, $username, $password, $database) or die("Connect failed: %s\n". $conn -> error);
	// Input User Data from React Application
	$user_input_string = file_get_contents('php://input');
	// Generate SQL Query to Find Previous Inputs
	$sql = "SELECT * FROM " . $table . " WHERE user_string = '". $user_input_string ."'";
	// Store SQL Response to Variable
	$payload = $conn->query($sql);
	// If !empty, Iterate Through Payload, Output Results
	if($payload->num_rows > 0) {
		while ($row = $payload->fetch_assoc()) {
			//echo $row['results']; // CONVERT TO JSON
			//echo json_encode($row['results']);
			/*
			echo '['. $row['date_created']
			 . ', String:' . $row['user_string']
			 . ', Result: ' . $row['results'] . ']';
			*/
			$data = array('date_created' => $row['date_created'],
							'user_string' => $row['user_string'],
							'results' => $row['results']);
			echo json_encode($data);
			
		}

	// If No Results Found, Find Patterns
	} else {

		$results = array();

		if(!empty($user_input_string) && strlen($user_input_string) >= 3) {
			$char_array = str_split($user_input_string);
			// Iterate through string by character
			for($i = 0; $i < count($char_array); $i++) {
				
				if(count($char_array) - $i < 3) {
					break; // less than 3 items in string
				}

				if($char_array[$i] === 'a') {
					// if 'aaa', add result to array, skip two iterations in loop
					if($char_array[$i+1] === 'a' && $char_array[$i+2] === 'a') {
						array_push($results, 1);
						$i += 2;
					// if 'aba', add result to array, skip two iterations in loop	
					} else if($char_array[$i+1] === 'b' && $char_array[$i+2] === 'a') {
						array_push($results, 2);
						$i += 2;
					}
				}
			}
		}
		// Convert Results from Array to String
		$result = join('', $results);
		if( $result ){
			// Display Results for Front End Application
			//echo $result; // CONVERT TO JSON
			$data = array('results' => $result);
			echo json_encode($data);

			// Generate Date for SQL Reference
			$date = date("Y-m-d H:i:s");

			$sql = "INSERT INTO " . $table . " (id, date_created, user_string, results) VALUES ('" . uniqid() . "', '" . $date . "', '" . $user_input_string . "', '" . $result . "')";
			$conn->query($sql);
		}
	}
	$conn->close();

?>