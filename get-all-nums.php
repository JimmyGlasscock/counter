<?php
$conn = mysqli_connect("localhost", "username", "password", "counter");
	if(!$conn){
		//error messages
		echo "Unable to connect to database! <br>";
		echo "errno - " . mysqli_connect_errno()."<br>";
		echo "error - " . mysqli_connect_error()."<br>";
		die();
	}
	
	$array = array();
	
	for($i=0; $i < 4; $i++){
		$query = "SELECT * FROM counter WHERE location = '".($i+1)."' AND DATE(time) = CURDATE();;";
		$result = $conn->query($query)->fetch_all();
		
		$total = 0;

		foreach($result as $item){
			$total = $total + (int)$item[1];
		}
		
		array_push($array, $total);
	}
	
	echo json_encode($array);
?>
