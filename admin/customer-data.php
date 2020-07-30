<html>
	<head>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
		<link rel="stylesheet" href="../style.css" type="text/css">
		
		<title>Customer Data</title>
	</head>
	<script type="text/javascript">
		var e = jQuery.noConflict();
		e( function() {
			e( ".datepicker" ).datepicker({
				dateFormat: 'yy-mm-dd'
			});
		} );
	</script>
<body>
	<div id="title" class="contain">
			<span class="textcenter" id=\"titleText\">
				<h1><strong style="color: white;">Customer Data</strong></h1>
			</span>
		</div>
	<div class="contain">
<?php
	if($_POST['date']){
		$conn = mysqli_connect("localhost", "root", "101scripting", "student-counter");
		if(!$conn){
			//error messages
			echo "Unable to connect to database! <br>";
			echo "errno - " . mysqli_connect_errno()."<br>";
			echo "error - " . mysqli_connect_error()."<br>";
			die();
		}
		
		$query = "SELECT * FROM students WHERE DATE_FORMAT('time', '%Y-%M-%d') = '".$_POST["date"]."';";
		
		die($query);
		
		$result = $conn->query($query)->fetch_all();
		
		die(print_r($result));
		
	}else{
		//echo datepicker form
		echo '<form action="index.php" method="post"><p style="text-align:center;">Select Date:</p><input style="margin-left: 225px;" type="text" class="datepicker" name="date"><br><br><input style="margin-left: 290px;" type="submit" value="Go"></form>';
	}
?>
</div>
</body>
</html>