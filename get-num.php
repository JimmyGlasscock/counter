<?php
$conn = mysqli_connect("localhost", "username", "password", "counter");
	if(!$conn){
		//error messages
		echo "Unable to connect to database! <br>";
		echo "errno - " . mysqli_connect_errno()."<br>";
		echo "error - " . mysqli_connect_error()."<br>";
		die();
	}
	
	$query = "SELECT * FROM customers WHERE location = '".$_POST['location']."' AND DATE(time) = CURDATE();";
	$result = $conn->query($query)->fetch_all();
	
	$total = 0;

	foreach($result as $item){
		$total = $total + (int)$item[1];
	}
	
	echo $total;
?>
