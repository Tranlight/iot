<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Biểu đồ IOT</title>
	<link rel="shortcut icon" type="image/jpg" href="<?php echo base_url('images/favicon.png');?>"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style type="text/css">
	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	canvas {
	  border: 1px dotted red;
	}

	@media only screen and (min-width: 576px) {
	  .chart-container {
		  position: relative;
		  float: left;
		  margin: auto;
		  height: 50vh !important;
		  width: 45vw !important;
		}
	}

	</style>
	<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
</head>
<body>
<h1 style="text-align: center;">Biểu đồ nhiệt độ, Độ ẩm, Chất lượng không khí</h1>
<div id="container">
	<?php foreach ($keys as $key => $value) { ?>
		<div class="chart-container">
			<canvas id="<?php echo $key?>"></canvas>
		</div>
	<?php } ?>
</div>
<footer>
	<script type="text/javascript">
		var options = {
		    responsive: true,
		    maintainAspectRatio: false,
		    scales: {
		        xAxes: [{
		            ticks: {
		                fontSize: 9,

		            }
		        }]
		    },
		}
		function renderChart(chart, labels, label, data) {
			return new Chart(chart, {
			    type: 'line',
			    data: {
			        labels: labels,
			        datasets: [{
			        	label: label,
			            borderColor: 'rgb(124, 135, 205)',
			            data: data
			        }]
			    },
			    options: options
			});
		}
		<?php
		foreach ($keys as $key => $value) {
			$varian = $key.'_var'; 
			$label = "'$key'";
			$column = json_encode(array_keys($keys[$key]));
			$data = json_encode(array_values($keys[$key]));
		?>
		var <?php echo "column_".$key?> = <?php echo $column?>;<?php echo "\n"?>
		var <?php echo "data_".$key?> = <?php echo $data?>;<?php echo "\n"?>
		var <?php echo $key?>  = document.getElementById('<?php echo $key?>').getContext('2d');<?php echo "\n"?>
		var <?php echo $varian. " = renderChart($key, column_".$key." , $label, data_".$key.");" ?><?php echo "\n"?>
		<?php echo $varian ?>.ctx.canvas.addEventListener('wheel', <?php echo $varian?>._wheelHandler);<?php echo "\n"?>

		<?php } ?>
	</script>
</footer>
</body>
</html>