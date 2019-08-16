<html>
<head>
	<meta charset="UTF-8">
	<title>Vehicle Builder</title>
	<link href="https://fonts.googleapis.com/css?family=Patrick+Hand" rel="stylesheet"> 
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/main.js"></script>
</head>
<body>
	<?php
		include "formbuilder.php";
		include "vehicles.php";

		$builder = new FormBuilder();
	?>
	<div class="container">
		<h1>Vehicle Builder</h3>
		<p>Simple Vehicle Assembly & Serialization</p>
		<form name="builder" method="post" action="result.php">
			<label>Type</label><br />
			<?php $builder->dropdown("vehicle_type", $ALL_VEHICLES, true); ?><br /><br />

			<label>Name</label><br />
			<input type="text" name="vehicle_name" /><br /><br />
			
			<label>Color</label><br />
			<input type="color" value="#ff0000" name="vehicle_color" /><br /><br />

			<label>Cost</label><br />
			<input type="number" name="vehicle_cost" /><br /><br />

			<label>Wheels</label><br />
			<input type="number" name="vehicle_wheels" /><br /><br />

			<label>Seats</label><br />
			<input type="number" name="vehicle_seats" /><br /><br />

			<label>Maximum Speed</label><br />
			<input type="number" name="vehicle_max_speed" /><br /><br />

			<label>Maximum Cargo Weight</label><br />
			<input type="number" name="vehicle_max_cargo_weight" /><br /><br />

			<label>Weight</label><br />
			<input type="number" name="vehicle_weight" /><br /><br />

			<div class="vehicle_max_fuel hidden">
				<label>Maximum Fuel</label><br />
				<input type="number" name="vehicle_max_fuel" /><br /><br />
			</div>

			<div class="vehicle_tow_capacity hidden">
				<label>Towing Capacity</label><br />
				<input type="number" name="vehicle_tow_capacity" /><br /><br />
			</div>

			<button type="button" onclick="addCargo()">Add Cargo</button><br /><br />

			<div id="cargo"></div>
			<div id="data"></div>
			<input type="submit" value="Generate">
		</form>
	</div>
</body>
</html>