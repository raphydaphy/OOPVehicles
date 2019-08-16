<?php

class FormBuilder {
	function dropdown($name, $options, $required) {
		echo '<select name="' . $name . '" id="' . $name . '"';
		if ($required) echo ' class="required" ';
		echo '> <option value="" selected disabled>Choose</option>';
		for ($x = 0; $x < count($options); $x++) {
			echo '<option value="' . $options[$x] . '" id="' . $options[$x] . '">' . $options[$x] . '</option>';
		}
		echo '</select>';
	}
}

?>