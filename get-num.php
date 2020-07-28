<?php
$conn = mysqli_connect("localhost", "root", "101scripting", "student-counter");
	if(!$conn){
		//error messages
		echo "Unable to connect to database! <br>";
		echo "errno - " . mysqli_connect_errno()."<br>";
		echo "error - " . mysqli_connect_error()."<br>";
		die();
	}
	
	$query = "SELECT * FROM students WHERE location = '".$_POST['location']."';";
	$result = $conn->query($query)->fetch_all();
	
	$total = 0;

	foreach($result as $item){
		$total = $total + (int)$item[1];
	}
	
	echo $total;
?>
