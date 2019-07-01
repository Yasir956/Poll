<!DOCTYPE HTML>
<html>
<head> 
	<link rel="stylesheet" href="/Poll1/style.css">
	<title>Poll Results</title>
	<?php
	include 'testmysql.php';
	$poll = new ViewData();

	$pollResult = $poll->getResult($_GET['pollID']);
	?>
	<?php

	if(!empty($pollResult['options'])){
		$labels = array();
		$y = array();
		$i=0;
		foreach($pollResult['options'] as $opt=>$vote){
			$items[] = $opt;
			$y[] = $vote;
		}     
	}
	?>
	<?php
	$dataPoints = array(
                   array("label"=>$items[0], "y"=> $y[0]),   // Poll data
                   array("label"=>$items[1], "y"=> $y[1]),
                   array("label"=>$items[2], "y"=> $y[2]),
                   array("label"=>$items[3], "y"=> $y[3]),
                   ); 
                   ?>

                   <script>
                   window.onload = function () {

                   	var chart = new CanvasJS.Chart("chartContainer", {
                   		animationEnabled: true,
                   		exportEnabled: true,
                   		title:{
                   			text: "Pie Chart For: <?php echo $pollResult['poll']; ?>"
                   		},
                   		subtitles: [{
                   			text: "Total Votes : <?php echo $pollResult['total_votes']; ?>"
                   		}],
                   		data: [{
                   			type: "pie",
                   			showInLegend: "true",
                   			legendText: "{label}",
                   			indexLabelFontSize: 16,
                   			indexLabel: "{label} - #percent%",
                   			yValueFormatString: "#,##0 Votes",
                   			dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                   		}]
                   	});
                   	chart.render();

                   }
                   </script>
               </head>
               <body>
               	<div id="chartContainer" style="height: 370px; width: 100%;"></div>

               	<center><a href="poll.php">Back To Poll</a></center>
               	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
               </body>
               </html>