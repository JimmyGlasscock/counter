<html>
	<head>

		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		
		<!--
		<link rel=\"stylesheet\" href=\"//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css\">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		-->
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
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
	<!-- Graph Code -->
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<style>
		.contain{
			width: 95%;
		}
		#line_chart_one, #line_chart_three{
			position: absolute;
			left: 12%;
		}
		#line_chart_two, #line_chart_four{
			position: absolute;
			right: 12%;
		}
		#line_chart_one, #line_chart_two{
			top: 10%;
		}
		#line_chart_three, #line_chart_four{
			top: 45%;
		}
		.largeBG{
			height: 600px;
		}
		@media only screen and (max-device-width: 599px) {
			.largeBG{
				height: 750px;
			}
			
			.largeBG p, .largeBG input{
				font-size: 36px !important;
			}
			
			#line_chart_one, #line_chart_three{
				position: absolute;
				left: 5%;
			}
			#line_chart_two, #line_chart_four{
				position: absolute;
				right: 5%;
			}
			#line_chart_one, #line_chart_two{
				top: 10%;
			}
			#line_chart_three, #line_chart_four{
				top: 32%;
			}
		}
	</style>
<body>
	<div id="title" class="contain">
			<span class="textcenter" id=\"titleText\">
				<h1><strong style="color: white;">Customer Data</strong></h1>
			</span>
		</div>
	<div class="contain largeBG" style="text-align: center;">
<?php
	if($_POST['date']){
		$conn = mysqli_connect("localhost", "username", "password", "counter");
		if(!$conn){
			//error messages
			echo "Unable to connect to database! <br>";
			echo "errno - " . mysqli_connect_errno()."<br>";
			echo "error - " . mysqli_connect_error()."<br>";
			die();
		}
		
		$query = "SELECT * FROM customers WHERE DATE(time) = '".$_POST["date"]."';";
		$result = $conn->query($query)->fetch_all();
		
		//format results into a form we can use
		$timeArray = array();
		$avgArray = array();
		
		//go through all times, log the # of people once per hour
		for($x = 0; $x < 4; $x++){
			$currentNumOfPeopleInStore = 0;
			for($i = 7; $i < 19; $i++){
				$hourMax = 0;
				foreach($result as $row){
					$hour = (int)substr($row[3], 11, 2);
					if($row[2] == $x+1 && $hour == $i){
						$currentNumOfPeopleInStore += (int)$row[1];
						if($currentNumOfPeopleInStore > $hourMax){
							$hourMax = $currentNumOfPeopleInStore;
						}
					}
				}
				//add hourmax to array
				$timeArray[$x][$i-7] = $hourMax;
			}
			
			//grab avg # of people in store per hour
			for($hour = 7; $hour < 19; $hour++){
				$sum = 0;
				for($min = 0; $min < 60; $min++){
					$currentNumOfPeopleInStore = 0;
					foreach($result as $row){
						$currentHour = (int)substr($row[3], 11, 2);
						$currentMin = (int)substr($row[3], 14, 2);
						if($row[2] == $x+1 && $currentHour == $hour && $currentMin == $min){
							$currentNumOfPeopleInStore += (int)$row[1];
						}
					}
					$sum += $currentNumOfPeopleInStore;
				}
				$avg = $sum/60;
				$avgArray[$x][$hour-7] = $avg;
			}
		}
		
		
		$array = '[';
		for($i = 0; $i < count($timeArray); $i++){
			$array .= '[';
			for($j = 0; $j < count($timeArray[$i]); $j++){
				$array .= $timeArray[$i][$j];
				if($j < count($timeArray[$i])-1){
					$array .= ',';
				}
			}
			$array .= ']';
			if($i < count($timeArray)-1){
					$array .= ',';
				}
		}
		$array .= ']';
		
		$array2 = '[';
		for($i = 0; $i < count($avgArray); $i++){
			$array2 .= '[';
			for($j = 0; $j < count($avgArray[$i]); $j++){
				$array2 .= $avgArray[$i][$j];
				if($j < count($avgArray[$i])-1){
					$array2 .= ',';
				}
			}
			$array2 .= ']';
			if($i < count($avgArray)-1){
					$array2 .= ',';
				}
		}
		$array2 .= ']';
		
		echo '<div id="line_chart_one" style="width: 450px; height: 250px"></div>';
		echo '<div id="line_chart_two" style="width: 450px; height: 250px"></div>';
		echo '<div id="line_chart_three" style="width: 450px; height: 250px"></div>';
		echo '<div id="line_chart_four" style="width: 450px; height: 250px"></div>';
		echo '<span style="display: none;" id="results">'.$array.'</span>';
		echo '<span style="display: none;" id="avgResults">'.$array2.'</span>';
		echo '<span style="display: none;" id="date">'.$_POST['date'].'</span>';
		
	}else{
		//echo datepicker form
		echo '<form action="customer-data.php" method="post"><p style="text-align:center;">Select Date:</p><input type="text" class="datepicker" name="date" readonly><br><br><input type="submit" value="Go"></form>';
	}
?>
</div>
</body>
<footer>
	<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
		var e = jQuery.noConflict();
		var array = JSON.parse(e('#results').html());
		var avgArray = JSON.parse(e('#avgResults').html());
		
		var storeData = [[['Time', '# of People', 'avg # of People']],[['Time', '# of People', 'avg # of People']], [['Time', '# of People', 'avg # of People']], [['Time', '# of People', 'avg # of People']]];
		
		for(var i = 0; i < array.length; i++){
			for(var j = 0; j < array[i].length; j++){
				var q = j+7;
				storeData[i][storeData[i].length] = [q+':00', array[i][j], avgArray[i][j]];
			}
		}
		
		console.log(storeData);
		  
        var dataOne = google.visualization.arrayToDataTable(storeData[0]);
		var dataTwo = google.visualization.arrayToDataTable(storeData[1]);
		var dataThree = google.visualization.arrayToDataTable(storeData[2]);
		var dataFour = google.visualization.arrayToDataTable(storeData[3]);
		

		var date = e('#date').html();
		
        var optionsOne = {
          title: 'Students in the Campus Store on '+date,
          curveType: 'line',
          legend: { position: 'bottom' }
        };
		var optionsTwo = {
          title: 'Students in the Health Science Store on '+date,
          curveType: 'line',
          legend: { position: 'bottom' }
        };

		var optionsThree = {
          title: 'Students in Sandy Store on '+date,
          curveType: 'line',
          legend: { position: 'bottom' }
        };

		var optionsFour = {
          title: 'Students in Textbooks on '+date,
          curveType: 'line',
          legend: { position: 'bottom' }
        };


        var chartOne = new google.visualization.LineChart(document.getElementById('line_chart_one'));
		var chartTwo = new google.visualization.LineChart(document.getElementById('line_chart_two'));
		var chartThree = new google.visualization.LineChart(document.getElementById('line_chart_three'));
		var chartFour = new google.visualization.LineChart(document.getElementById('line_chart_four'));

        chartOne.draw(dataOne, optionsOne);
		chartTwo.draw(dataTwo, optionsTwo);
		chartThree.draw(dataThree, optionsThree);
		chartFour.draw(dataFour, optionsFour);
      }
    </script>
</footer>
</html>
		