<?php
$conn = mysqli_connect("localhost", "root", "101scripting", "student-counter");
	if(!$conn){
		//error messages
		echo "Unable to connect to database! <br>";
		echo "errno - " . mysqli_connect_errno()."<br>";
		echo "error - " . mysqli_connect_error()."<br>";
		die();
	}
	
	$query = "INSERT INTO students (num, location) VALUES ('1', '".$_POST['location']."');";
	
	$result = $conn->query($query);
	
	echo 'increase success.';
?>
