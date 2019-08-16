var cargo = [];

$(document).ready(function () {
    update();

    $("select").change(function () {
        update();
    });

	$("input").change(function () {
        update();
    });

    $("#cargo").hide();
});

function update() {
	$('.hidden').hide();

	var vehicleType = $("#vehicle_type").val();

	var isFueled = vehicleType && vehicleType != "Push Bike";

	if (isFueled) {
		$(".vehicle_max_fuel").show();

		if (vehicleType === "Tow Truck") {
			$(".vehicle_tow_capacity").show();
		}
	}

	var dataStr = '<input type="hidden" name="cargo_length" value="' + cargo.length + '" />';

	for (var cargoID = 0; cargoID < cargo.length; cargoID++) {
		dataStr += '<input type="hidden" name="cargo_children_' + cargoID + '" value="' + cargo[cargoID] + '" />';
		var type = $("#cargo_type_" + cargoID).val();
		if (type === "Passenger") {
			$(".passenger_cargo_" + cargoID).show();
		} else if (type === "Luggage") {
			$(".luggage_cargo_" + cargoID).show();
		}
	}


	$("#data").html(dataStr);

	$('.required').prop('required', function() {
	   return  $(this).is(':visible');
	});
}

function addCargo() {
	$("#cargo").show();

	var index = cargo.length;
	var newCargo = 	'<fieldset>' +
						'<legend>Cargo</legend>' +
						'<label>Type</label><br />' +
						'<select name="cargo_type_' + index + '" id="cargo_type_' + index + '" class="required" >' +
							'<option value="" selected disabled>Choose</option>' +
							'<option value="Passenger" id="Passenger">Passenger</option>' +
							'<option value="Luggage" id="Luggage">Luggage</option>' +
						'</select><br /><br />' +
						'<label>Name</label><br />' +
						'<input type="text" name="cargo_name_' + index + '" class="required" ><br /><br />' +
						'<label>Weight</label><br />' +
						'<input type="text" min="0" step="0.01" name="cargo_weight_' + index + '" class="required" ><br /><br />' +
						'<div class="hidden passenger_cargo_' + index + '">' +
							'<label>Age</label><br />' +
							'<input type="number" min="0" name="cargo_age_' + index + '" class="required" ><br /><br />' +
							'<label>Strength</label><br />' +
							'<input type="number" min="0" step="0.01" name="cargo_strength_' + index + '" class="required" ><br /><br />' +
							'<label>Height</label><br />' +
							'<input type="text" min="0" step="0.01" name="cargo_height_' + index + '" class="required" ><br /><br />' +
						'<button type="button" onclick="addLuggage(' + index +')">Add Luggage</button><br />' +
						'<div id="passenger_cargo_luggage_' + index + '"></div></div><div class="hidden luggage_cargo_' + index + '">' +
							'<label>Color</label><br />' +
							'<input type="color" value="#00ff00" name="cargo_color_' + index + '" class="required" ><br /><br />' +
						'</div>' +
					'</fieldset>';
	$("#cargo").append(newCargo);

    $("select").change(function () {
        update();
    });

	cargo.push(0);
	update();

}

function addLuggage(cargoID) {
	$("#passenger_cargo_luggage_" + cargoID).show();

	var index = cargo[cargoID];
	var luggage = 	'<fieldset>' +
						'<legend>Luggage</legend>' +
						'<label>Name</label><br />' +
						'<input type="text" name="cargo_' + cargoID + '_luggage_name_' + index + '" class="required" ><br /><br />' +
						'<label>Weight</label><br />' +
						'<input type="text" min="0" step="0.01" name="cargo_' + cargoID + '_luggage_weight_' + index + '" class="required" ><br /><br />' +
						'<label>Color</label><br />' +
						'<input type="color" value="#00ff00" name="cargo_' + cargoID + '_luggage_color_' + index + '" class="required" ><br /><br />' +
					'</fieldset>';
	$("#passenger_cargo_luggage_" + cargoID).append(luggage);
	cargo[cargoID] = index + 1;
}