<?php

$ALL_CARGO = array();
array_push($ALL_CARGO, "Passenger", "Luggage");

abstract class Cargo {
	protected $name;
	protected $weight;

	public function __construct($name, $weight) {
		$this->name = $name;
		$this->weight = $weight;
	}

	public function getWeight() {
		return $this->weight;
	}

	public abstract function serialize();
}

class Passenger extends Cargo {
	protected $age;
	protected $strength;
	protected $height;

	protected $luggage = array();

	public function __construct($name, $age, $strength, $weight, $height) {
		parent::__construct($name, $weight);
		$this->age = $age;
		$this->strength = $strength;
		$this->height = $height;
	}

	public function getWeight() {
		$totalWeight = $this->weight;
		for ($x = 0; $x < count($this->luggage); $x++) {
			$totalWeight += $this->luggage[$x]->getWeight();
		}
		return $totalWeight;
	}

	public function addLuggage(Luggage $luggage) {
		if ($this->getWeight() - $this->weight + $luggage->getWeight() <= $this->strength) {
			array_push($this->luggage, $luggage);
			return true;
		}
		return false;
	}

	public function serialize() {
		$luggageStr = '';
		for ($x = 0; $x < count($this->luggage); $x++) {
			$luggageStr = $luggageStr . $this->luggage[$x]->serialize();
		}
		$json = '{ "name": "' . $this->name . '", "age": ' . $this->age . ', "strength": ' . $this->strength . ', "weight": ' . $this->weight . ', "height": ' . $this->height;
		if ($luggageStr != '') {
			$json = $json . ', "luggage": [ ' . $luggageStr . ' ] ';
		}
		return $json . ' }';
	}
}

class Luggage extends Cargo {
	protected $color;

	public function __construct($name, $weight, $color) {
		parent::__construct($name, $weight);
		$this->color = $color;
	}

	public function serialize() {
		return '{ "name": "' . $this->name . '", "weight": ' . $this->weight . ', "color": ' . $this->color . ' }';
	}
}
?>