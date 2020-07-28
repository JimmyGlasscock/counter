<?php
	$conn = mysqli_connect("localhost", "root", "101scripting", "student-counter");
	if(!$conn){
		//error messages
		echo "Unable to connect to database! <br>";
		echo "errno - " . mysqli_connect_errno()."<br>";
		echo "error - " . mysqli_connect_error()."<br>";
		die();
	}

	if($_POST['location']){
		$_SESSION['location'] = $_POST['location'];
	}

?>
<html>
	<link rel="stylesheet" href="style.css" type="text/css">
	<title>Student Counter</title>
	<style>
		.contain{
			width: 95%;
		}
		.number{
			font-size: 64px !important;
			position: absolute;
			left: 50%;
			top: 23%;
			transform: translate(-50%, -50%)
		}
		.button {
			background-color: #fff;
			width: 45%;
			height: auto;
			border: 0px solid;
			border-radius: 7px;
			margin: 10px auto;
			padding: 1em;
			margin-bottom: 10px;
			box-shadow: 2px 2px 15px #888888;
		}
		.buttonLeft {
			background-color: #13e484;
			color: #fff;
			width: 45%;
			height: auto;
			border: 0px solid;
			border-radius: 7px;
			margin: 10px auto;
			padding: 1em;
			margin-bottom: 10px;
			box-shadow: 2px 2px 15px #888888;
			margin-left: 1%;
			float: left;
			height: 30%;
		}

		.buttonLeft p{
			position: absolute;
			font-size: 86pt;
			top: 52%;
			left: 22%;
		}

		.buttonRight {
			background-color: #e44848;
			color: #fff;
			width: 45%;
			height: auto;
			border: 0px solid;
			border-radius: 7px;
			margin: 10px auto;
			padding: 1em;
			margin-bottom: 10px;
			box-shadow: 2px 2px 15px #888888;
			margin-right: 1%;
			float: right;
			height: 30%;
		}

		.buttonRight p{
			position: absolute;
			font-size: 86pt;
			top: 52%;
			right: 22%;
		}
	</style>
	<head>
		<link rel=\"stylesheet\" href=\"//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css\">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	</head>
	<body>
		<div class="contain" id="title">
			<span class="textcenter" id="titleText">
				<h1>Student Counter</h1>
			</span>
		</div>
		<div class="contain" style="height: 35%;">
			<div class="numberDisplay">
				<!-- Display number of students -->
				<?php 
					$query = "SELECT * FROM students;";
					$result = $conn->query($query)->fetch_all();
					
					$total = 0;
					foreach($result as $item){
						$total = $total + (int)$item[1];
					}
					
					echo '<p class="number">'.$total.'</p>';
				?>
			</div>
		</div>
		<div>
			<div class="buttonLeft">
				<!-- + -->
				<p>+</p>
			</div>
		</div>
		<div>
			<div class="buttonRight">
				<!-- - -->
				<p>-</p>
			</div>
		</div>
		<input type="hidden" id="location" <?php echo 'value="'.$_SESSION['location'].'"'?>>
	</body>
	<footer>
		<script>
			//refreshes student # once per second
			$(window).load(function(){
				update()
				setInterval(function(){
					update()
				}, 1000);

				$('.buttonLeft').on('click', addOne);
				$('.buttonRight').on('click', deleteOne);
			});

			function update(){
				$.ajax({
					url: 'get-num.php',
					success:function(data){
						$('.number').html(data);
						console.log('updated.')
					}
				});
			}

			function addOne(){
				var l = $('#location').val();
				var location = { location: l}
				$.ajax({
					url: 'increase.php',
					type: 'POST',
					data: location,
					dataType: 'text',
					success:function(data){
						update();
						console.log(data)
					}
				});
			}

			function deleteOne(){
				var l = $('#location').val();
				var location = { location: l}
				$.ajax({
					url: 'decrease.php',
					type: 'POST',
					data: location,
					dataType: 'text',
					success:function(data){
						update();
						console.log(data)
					}
				});
			}
		</script>
	</footer>
</html>