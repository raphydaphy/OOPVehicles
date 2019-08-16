<?php
include "cargo.php";

$ALL_VEHICLES = array();

array_push($ALL_VEHICLES, "Push Bike", "Motorbike", "Car", "Truck", "Tow Truck");

class Vehicle {
	protected $name;
	protected $color;
	protected $cost;
	protected $wheels;
	protected $seats;
	protected $maxSpeed;
	protected $maxCargoWeight;
	protected $weight;
	protected $speed;
	protected $distance;
	protected $passengers;
	protected $cargo = array();

	public function __construct($name, $color, $cost, $wheels, $seats, $maxSpeed, $maxCargoWeight, $weight) {
		$this->name = $name;
		$this->color = $color;
		$this->cost = $cost;
		$this->wheels = $wheels;
		$this->seats = $seats;
		$this->maxSpeed = $maxSpeed;
		$this->maxCargoWeight = $maxCargoWeight;
		$this->weight = $weight;
	}

	public function serialize() {
		return '{ ' . $this->addProps() . $this->addArrays() . ' }';
	}

	protected function addProps() {
		return '"name": "' . $this->name .  
		'", "color": ' . $this->color . 
		', "cost": ' . $this->cost . 
		', "wheels": ' . $this->wheels . 
		', "seats": ' . $this->seats . 
		', "maxSpeed": ' . $this->maxSpeed . 
		', "maxCargoWeight": ' . $this->maxCargoWeight . 
		', "weight": ' . $this->weight . 
		', "passengers": ' . $this->passengers;
	}

	protected function addArrays() {
		if (count($this->cargo) == 0) return '';
		$cargoStr = '';
		for ($x = 0; $x < count($this->cargo); $x++) {
			$cargoStr = $cargoStr . $this->cargo[$x]->serialize();
			if ($x < count($this->cargo) - 1) $cargoStr = $cargoStr . ", ";
		}
		return ', "cargo": [ ' . $cargoStr . ' ]';
	}

	public function update() {
		$this->distance += $this->$speed;
	}

	public function getWeight() {
		$totalWeight = $this->weight;
		for ($x = 0; $x < count($this->cargo); $x++) {
			$totalWeight += $this->cargo[$x]->getWeight();
		}
		return $totalWeight;
	}

	public function addCargo(Cargo $cargo) {
		if ($this->getWeight() - $this->weight + $cargo->getWeight() <= $this->maxCargoWeight) {
			if ($cargo instanceof Passenger) {
				if ($this->passengers >= $this->seats) {
					return false;
				}
				$this->passengers++;
			}
			array_push($this->cargo, $cargo);
			return true;
		}
		return false;
	}

	public function setSpeed($speed) {
		if ($speed >= 0) {
			$this->speed = $speed;
			return true;
		}
		return false;
	}
}

class FueledVehicle extends Vehicle {
	protected $maxFuel;
	protected $fuel;

	public function __construct($name, $color, $cost, $wheels, $seats, $maxSpeed, $maxCargoWeight, $weight, $maxFuel) {
		parent::__construct($name, $color, $cost, $wheels, $seats, $maxSpeed, $maxCargoWeight, $weight);
		$this->maxFuel = $maxFuel;
	}

	protected function addProps() {
		return parent::addProps() .
		', "maxFuel": ' . $this->maxFuel;
	}
}

class TowTruck extends FueledVehicle {
	protected $towCapacity;
	protected $vehicles = array();

	public function __construct($name, $color, $cost, $wheels, $seats, $maxSpeed, $maxCargoWeight, $weight, $maxFuel, $towCapacity) {
		parent::__construct($name, $color, $cost, $wheels, $seats, $maxSpeed, $maxCargoWeight, $weight, $maxFuel);
		$this->towCapacity = $towCapacity;
	}

	protected function addProps() {
		return parent::addProps() .
		', "towCapacity": ' . $this->towCapacity;
	}

	protected function addArrays() {
		if (count($this->vehicles) == 0) return parent::addArrays();
		$vehiclesStr = '';
		for ($x = 0; $x < count($this->vehicles); $x++) {
			$vehiclesStr = $vehiclesStr . $this->vehicles[$x]->serialize();
		}
		return parent::addArrays() . ', "vehicles": [ ' . $vehiclesStr . ' ]';
	}

	public function tow(Vehicle $vehicle) {
		if ($this->getWeight() - $this->weight + $vehicle->getWeight() <= $this->maxCargoWeight && count($this->vehicles) < $this->towCapacity) {
			array_push($this->vehicles, $vehicle);
			return true;
		}
		return false;
	}

	public function getWeight() {
		$totalWeight = parent::getWeight();
		for ($x = 0; $x < count($this->vehicles); $x++) {
			$totalWeight += $this->vehicles[$x]->getWeight();
		}
		return $totalWeight;
	}
}
?>