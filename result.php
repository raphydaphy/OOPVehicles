<?php
include "json.php";
include "vehicles.php";

if (isset($_POST["vehicle_type"])) {
	$vehicleType = $_POST["vehicle_type"];
	$vehicleName = $_POST["vehicle_name"];
	$vehicleColor = $_POST["vehicle_color"];
	$vehicleCost = $_POST["vehicle_cost"];
	$vehicleWheels = $_POST["vehicle_wheels"];
	$vehicleSeats = $_POST["vehicle_seats"];
	$vehicleMaxSpeed = $_POST["vehicle_max_speed"];
	$vehicleMaxCargoWeight = $_POST["vehicle_max_cargo_weight"];
	$vehicleWeight = $_POST["vehicle_weight"];

	$vehicle = null;

	if ($vehicleType == "Car" || $vehicleType == "Motorbike" || $vehicleType == "Truck" || $vehicleType == "Tow Truck") {
		$vehicleMaxFuel = $_POST["vehicle_max_fuel"];
		if ($vehicleType == "Tow Truck") {
			$vehicleTowCapacity = $_POST["vehicle_tow_capacity"];
			$vehicle = new TowTruck($vehicleName, $vehicleColor, $vehicleCost, $vehicleWheels, $vehicleSeats, $vehicleMaxSpeed, $vehicleMaxCargoWeight, $vehicleWeight, $vehicleMaxFuel, $vehicleTowCapacity);
		} else {
			$vehicle = new FueledVehicle($vehicleName, $vehicleColor, $vehicleCost, $vehicleWheels, $vehicleSeats, $vehicleMaxSpeed, $vehicleMaxCargoWeight, $vehicleWeight, $vehicleMaxFuel);
		}
	} else {
			$vehicle = new Vehicle($vehicleName, $vehicleColor, $vehicleCost, $vehicleWheels, $vehicleSeats, $vehicleMaxSpeed, $vehicleMaxCargoWeight, $vehicleWeight);
	}

	$cargoAmount = $_POST["cargo_length"];

	for ($cargoID = 0; $cargoID < $cargoAmount; $cargoID++) {
		$cargo = null;
		$cargoType = $_POST["cargo_type_" . $cargoID];
		$cargoName = $_POST["cargo_name_" . $cargoID];
		$cargoWeight = $_POST["cargo_weight_" . $cargoID];
		if ($cargoType === "Passenger") {
			$cargoAge = $_POST["cargo_age_" . $cargoID];
			$cargoStrength = $_POST["cargo_strength_" . $cargoID];
			$cargoHeight = $_POST["cargo_height_" . $cargoID];
			$cargoChildren = $_POST["cargo_children_" . $cargoID];

			$cargo = new Passenger($cargoName, $cargoAge, $cargoStrength, $cargoWeight, $cargoHeight);
		} else if ($cargoType === "Luggage") {
			$cargoColor = $_POST["cargo_color_" . $cargoID];
			$cargo = new Luggage($cargoName, $cargoWeight, $cargoColor);
		}

		if (!$vehicle->addCargo($cargo)) {
			echo('<script type="js">console.log("Failed to add cargo!"))</script>');
		}
	}

	header('Content-Type: application/json');
	echo prettyPrint($vehicle->serialize());
} else {
	header("Location: index.php");
}
?>