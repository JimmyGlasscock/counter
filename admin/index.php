<html>
	<link rel="stylesheet" href="../style.css" type="text/css">
	<title>Admin Portal</title>
	<style>
		.form{
			text-align: center;
		}
		
		.form p{
			font-size: 48px;
		}
		
		.form select, .form input{
			font-size: 36px;
		}
		
		.niceButton{
			margin: 0 auto;
			font-family: 'Maven Pro', sans-serif;
			font-size: 24pt;
			border: none;
			border-radius: 5px;
			height: 60px;
			width: 350px;
			background-color: #cc0000;
			color: white;
			transition: width 0.2s, height 0.2s, background-color 0.1s, font-size 0.2s, color 0.2s, margin 0.2s;
			text-align: center;
			position: absolute;
			left: 0;
			right: 0;
		}
		
		.contain a{
			color: white;
		}
		
		.verticalCenter{
			position: absolute;
			top: 20%;
			left: 0;
			right: 0;
		}
		
		.contain{
			width: 95%;
		}
		
		.spacer{
			margin-bottom: 75px;
		}
		
		@media only screen and (min-device-width: 600px) {
			.verticalCenter{
				top: 28%;
			}
			.niceButton{
				width: 160px;
				font-size: 12pt;
				height: 30px;
			}
			
			.spacer{
				margin-bottom: 50px;
			}
		}
	</style>
	<head>
		<link rel=\"stylesheet\" href=\"//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css\">
		<link rel=\"stylesheet\" href=\"//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css\">
		<script src=\"https://code.jquery.com/jquery-1.12.4.js\"></script>
		<script src=\"https://code.jquery.com/ui/1.12.1/jquery-ui.js\"></script>
		<script src=\"//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js\"></script>
		<link rel="icon" href="favicon.ico" type="image/x-icon" />
	</head>
	<body>
		<div class="contain" id="title">
			<span class="textcenter" id="titleText">
				<h1>Admin Portal</h1>
			</span>
		</div>
		<div class="contain big" style="height: 35%;">
			<div class="verticalCenter">
				<a href="all-stores.php"><input class="niceButton" value="View Store Capacity" tabindex="10" readonly=""></a>
				<br><div class="spacer"></div>
				<a href="customer-data.php"><input class="niceButton" value="View Store Traffic" tabindex="13" readonly=""></a>
			</div>
		</div>
	</body>
</html>