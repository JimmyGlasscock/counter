<?php
	if($_POST["verify"] != 'w3g00d'){
		header('Location: index.html');
	}

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
	
	//default is 50
	$capacity = 50;
	
	$file = fopen('capacity.txt', 'r');
	$data = fread($file, filesize('capacity.txt'));
	fclose($file);
	
	$data = $parts = preg_split('/\s+/', $data);
	$string = $data[((int)$_SESSION['location'])-1];
	
	$capacity = (int)substr($string, strpos($string, '-')+1);
?>
<html>
	<link rel="stylesheet" href="style.css" type="text/css">
	<title>Student Counter</title>
	<style>
		.contain{
			width: 95%;
		}
		.number{
			font-size: 160px !important;
			position: absolute;
			left: 50%;
			top: 20%;
			transform: translate(-50%, -50%)
		}
		.capacityCounter{
			position: absolute;
			bottom: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			font-size: 24px !important;
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
		
		@media only screen and (min-device-width: 600px) {
			.capacityCounter{
				bottom: 38%;
			}
			.buttonLeft{
				width: 40%;
				margin-left: 3%;
			}
			.buttonRight{
				width: 40%;
				margin-right: 3%;
			}
			.buttonLeft p{
				top: 57%;
			}
			.buttonRight p{
				top: 57%;
			}
		}
	</style>
	<head>
		<link rel=\"stylesheet\" href=\"//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css\">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<link rel="icon" href="favicon.ico" type="image/x-icon" />
	</head>
	<body>
		<div class="contain" id="title">
			<span class="textcenter" id="titleText">
				<h1>Student Counter</h1><h2 style="color: #fff; font-size: 18pt; font-weight: lighter;">
				<?php 
					echo '<strong>';
				
					if($_SESSION['location'] == '1'){
						echo 'Campus Store';
					}else if($_SESSION['location'] == '2'){
						echo 'Health Sciences';
					}else if($_SESSION['location'] == '3'){
						echo 'Sandy';
					}else if($_SESSION['location'] == '4'){
						echo 'Textbooks';
					}
					
					echo '</strong> - Capacity '.$capacity;
				?>
				</h2>
			</span>
		</div>
		<div class="contain numberDisplay" style="height: 35%;">
			<div>
				<p class="number">0</p>
				<p class="capacityCounter">0% Capacity</p>
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
		<input type="hidden" id="capacity" <?php echo 'value="'.$capacity.'"'?>>
	</body>
	<footer>
		<script>
			//refreshes student # once per second
			$(window).load(function(){
				update()
				setInterval(function(){
					update()
				}, 500);

				$('.buttonLeft').on('click', addOne);
				$('.buttonRight').on('click', deleteOne);
			});

			function update(){
				var l = $('#location').val();
				var capacity = $('#capacity').val();
				var location = { location: l}
				$.ajax({
					url: 'get-num.php',
					type: 'POST',
					data: location,
					dataType: 'text',
					success:function(data){
						$('.number').html(data);
						//update capacity
						$('.capacityCounter').html(parseInt(data/capacity*100)+"% Capacity");
						//copy color from number
						$('.capacityCounter').css('color', $('.number').css('color'));
						console.log('updated')
						updateColor(data);
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
			
			function updateColor(data){
				data = parseInt(data);
				var capacity = parseInt($('#capacity').val());
				if(capacity <= data){
					//set color #ce4a4a
					//set text #fff
					$('.numberDisplay').css('background', '#ce4a4a');
					$('.number').css('color', '#fff');
					console.log("capa: "+capacity)
					console.log("data: "+data)
				}else if(capacity*0.8 < data){
					//set color #ffbc9c
					$('.numberDisplay').css('background', '#ffbc9c');
					$('.number').css('color', '#000');
				}else if(capacity*0.6 < data){
					//set color #ffe19c
					$('.numberDisplay').css('background', '#ffe19c');
					$('.number').css('color', '#000');
				}else{
					//set white & set text #000
					$('.numberDisplay').css('background', '#fff');
					$('.number').css('color', '#000');
				}	
				
			}
		</script>
	</footer>
</html>