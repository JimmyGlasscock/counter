<?php
	$conn = mysqli_connect("localhost", "username", "password", "counter");
	if(!$conn){
		//error messages
		echo "Unable to connect to database! <br>";
		echo "errno - " . mysqli_connect_errno()."<br>";
		echo "error - " . mysqli_connect_error()."<br>";
		die();
	}
	
	
	$file = fopen('../capacity.txt', 'r');
	$data = fread($file, filesize('../capacity.txt'));
	fclose($file);
	
	$data = $parts = preg_split('/\s+/', $data);
	
	$stringOne = $data[0];
	$stringTwo = $data[1];
	$stringThree = $data[2];
	$stringFour = $data[3];
	
	$capacityStoreOne = (int)substr($stringOne, strpos($stringOne, '-')+1);
	$capacityStoreTwo = (int)substr($stringTwo, strpos($stringTwo, '-')+1);
	$capacityStoreThree = (int)substr($stringThree, strpos($stringThree, '-')+1);
	$capacityStoreFour = (int)substr($stringFour, strpos($stringFour, '-')+1);
?>
<html>
	<link rel="stylesheet" href="../style.css" type="text/css">
	<title>Counter</title>
	<style>
		.contain{
			width: 95%;
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
		
		.storeOneNumberDisplay, .storeThreeNumberDisplay{
			width: 45%;
			margin-left: 1%;
			float: left;
			height: 20%;
		}
		.storeTwoNumberDisplay, .storeFourNumberDisplay{
			width: 45%;
			margin-right: 1%;
			float: right;
			height: 20%;
		}
		
		.storeOneNumber, .storeThreeNumber{
			font-size: 160px !important;
			position: absolute;
			left: 25%;
			transform: translate(-50%, -50%)
		}
		
		.storeTwoNumber, .storeFourNumber{
			font-size: 160px !important;
			position: absolute;
			left: 75.5%;
			transform: translate(-50%, -50%)
		}
		
		.storeOneCapacityCounter, .storeThreeCapacityCounter{
			position: absolute;
			left: 25%;
			transform: translate(-50%, -50%);
			font-size: 24px !important;
		}
		
		.storeTwoCapacityCounter, .storeFourCapacityCounter{
			position: absolute;
			left: 75%;
			transform: translate(-50%, -50%);
			font-size: 24px !important;
		}
		
		.storeOneCapacityCounter, .storeTwoCapacityCounter{
			top: 43%;
		}
		
		.storeThreeCapacityCounter, .storeFourCapacityCounter{
			top: 81%;
		}
		
		.storeOneLabel, .storeTwoLabel, .storeThreeLabel, .storeFourLabel{
			font-size: 30px !important;
			font-weight: bold;
		}
		
		@media only screen and (min-device-width: 600px) {
			.storeOneCapacityCounter, .storeTwoCapacityCounter{
				top: 50%;
			}
			
			.storeThreeCapacityCounter, .storeFourCapacityCounter{
				top: 90%;
			}
			
			.storeOneNumber, .storeTwoNumber{
				top: 20%;
			}
			.storeThreeNumber, .storeFourNumber{
				top: 60%;
			}
			
			.storeOneNumberDisplay, .storeThreeNumberDisplay{
				width: 42%;
			}
			.storeTwoNumberDisplay, .storeFourNumberDisplay{
				width: 42%;
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
				<h1>Capacity</h1><h2 style="color: #fff; font-size: 18pt; font-weight: lighter;">
			</span>
		</div>
		<div class="TwoByTwo">
			<div class="contain storeOneNumberDisplay" style="height: 35%;">
				<div>
					<p class="storeOneLabel" style="text-align: center;">Store One</p>
					<p class="storeOneNumber"></p>
					<p class="storeOneCapacityCounter"></p>
				</div>
			</div>
			<div class="contain storeTwoNumberDisplay" style="height: 35%;">
				<div>
					<p class="storeTwoLabel" style="text-align: center;">Store Two</p>
					<p class="storeTwoNumber"></p>
					<p class="storeTwoCapacityCounter"></p>
				</div>
			</div><br>
			<div class="contain storeThreeNumberDisplay" style="height: 35%;">
				<div>
					<p class="storeThreeLabel" style="text-align: center;">Store Three</p>
					<p class="storeThreeNumber"></p>
					<p class="storeThreeCapacityCounter"></p>
				</div>
			</div>
			<div class="contain storeFourNumberDisplay" style="height: 35%;">
				<div>
					<p class="storeFourLabel" style="text-align: center;">Store Four</p>
					<p class="storeFourNumber"></p>
					<p class="storeFourCapacityCounter"></p>
				</div>
			</div>
		</div>
		<input type="hidden" id="storeOneCapacity" <?php echo 'value="'.$capacityStoreOne.'"'?>>
		<input type="hidden" id="storeTwoCapacity" <?php echo 'value="'.$capacityStoreTwo.'"'?>>
		<input type="hidden" id="storeThreeCapacity" <?php echo 'value="'.$capacityStoreThree.'"'?>>
		<input type="hidden" id="storeFourCapacity" <?php echo 'value="'.$capacityStoreFour.'"'?>>
	</body>
	<footer>
		<script>
			//refreshes student # once per second
			$(window).load(function(){
				update()
				setInterval(function(){
					update()
				}, 500);
			});

			function update(){
				var storeOneCapacity = $('#storeOneCapacity').val();
				var storeTwoCapacity = $('#storeTwoCapacity').val();
				var storeThreeCapacity = $('#storeThreeCapacity').val();
				var storeFourCapacity = $('#storeFourCapacity').val();
				
				var capacity = [storeOneCapacity, storeTwoCapacity, storeThreeCapacity, storeFourCapacity];
				var nums = ['One', 'Two', 'Three', 'Four'];

					$.ajax({
						url: '../get-all-nums.php',
						success:function(data){
							//parse json and update counters
							var data = JSON.parse(data)
							console.log(data)

							for(var i = 0; i < data.length; i++){
								$('.store'+nums[i]+'Number').html(data[i]);
								//update capacity
								$('.store'+nums[i]+'CapacityCounter').html(parseInt(data[i]/capacity[i]*100)+"% Capacity");
								//copy color from number
								$('.store'+nums[i]+'CapacityCounter').css('color', $('.store'+nums[i]+'Number').css('color'));
								$('.store'+nums[i]+'Label').css('color', $('.store'+nums[i]+'Number').css('color'));
								updateColor(data[i], nums[i]);
							}
	
						}
					});
						
			}
		
			
			function updateColor(data, num){
				//UPDATE COLORS OF LABELS TOO!!!
				data = parseInt(data);
				var capacity = parseInt($('#store'+num+'Capacity').val());
				if(capacity <= data){
					//set color #ce4a4a
					//set text #fff
					$('.store'+num+'NumberDisplay').css('background', '#ce4a4a');
					$('.store'+num+'Number').css('color', '#fff');
					console.log("capa: "+capacity)
					console.log("data: "+data)
				}else if(capacity*0.8 < data){
					//set color #ffbc9c
					$('.store'+num+'NumberDisplay').css('background', '#ffbc9c');
					$('.store'+num+'Number').css('color', '#000');
				}else if(capacity*0.6 < data){
					//set color #ffe19c
					$('.store'+num+'NumberDisplay').css('background', '#ffe19c');
					$('.store'+num+'Number').css('color', '#000');
				}else{
					//set white & set text #000
					$('.store'+num+'NumberDisplay').css('background', '#fff');
					$('.store'+num+'Number').css('color', '#000');
				}	
				
			}
		</script>
	</footer>
</html>