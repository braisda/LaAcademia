<?php
// file: model/EventReservation.php

require_once(__DIR__."/../core/ValidationException.php");

/**
* Class EventReservation
*
* Represents a EventReservation in the academy
*
* @author lipido <lipido@gmail.com>
*/
class EventReservation {

	/**
	* The id of this reservation
	* @var string
	*/
	private $id_reservation;

	/**
	* The date of the reservation
	* @var string
	*/
	private $date;

	/**
	* The time of the reservation
	*/
	private $time;

	/**
	* The state of the reservation
	*/
	private $is_confirmed;

	/**
	* The assistant who send the reservation
	*/
	private $id_assistant;

	/**
	* The event which will be reserved
	*/
	private $id_event;

	/**
	* The constructor
	*
	* @param $id_reservation The id of this reservation
	* @param $date The time of the reservation
  * @param $time The type of the event
  * @param $is_confirmed The state of the reservation
  * @param $id_assistant The assistant who send the reservation
  * @param $id_event The event which will be reserved
	*/
	public function __construct($id_reservation=NULL, $date=NULL, $time=NULL,
															$is_confirmed=NULL, $id_assistant=NULL, $id_event=NULL) {
		$this->id_reservation = $id_reservation;
		$this->date = $date;
		$this->time = $time;
		$this->is_confirmed = $is_confirmed;
		$this->id_assistant = $id_assistant;
    $this->id_event = $id_event;
	}

	/**
	* Gets the id of this reservation
	*
	* @return string The id of this reservation
	*/
	public function getId_reservation() {
		return $this->id_reservation;
	}

	/**
	* Gets the name of this reservation
	*
	* @return string The date of this reservation
	*/
	public function getDate() {
		return $this->date;
	}

	/**
	* Sets the time of this reservation
	*
	* @param string $time The time of this reservation
	* @return void
	*/
	public function setDate($date) {
		$this->date = $date;
	}

	/**
	* Gets the time of this reservation
	*
	* @return string The time of this reservation
	*/
	public function getTime() {
		return $this->time;
	}

  /**
	* Sets the time of this reservation
	*
	* @param string $time The time of this reservation
	* @return void
	*/
	public function setTime($time) {
		$this->time = $time;
	}

	/**
	* Gets the state of the reservation
	*
	* @return string The state of the reservation
	*/
	public function getIs_confirmed() {
		return $this->is_confirmed;
	}

	/**
	* Sets the state of the reservation
	*
	* @param string $is_confirmed The state of the reservation
	* @return void
	*/
	public function setIs_confirmed($is_confirmed) {
		$this->is_confirmed = $is_confirmed;
	}

	/**
	* Gets the assistant who send the reservation
	*
	* @return string The assistant who send the reservation
	*/
	public function getId_assistant() {
		return $this->id_assistant;
	}

	/**
	* Sets the capacity of this space
	*
	* @param string $id_assistant The capacity of this reservation
	* @return void
	*/
	public function setId_assistant($id_assistant) {
		$this->id_assistant = $id_assistant;
	}

  /**
	* Gets the event which will be reserved
	*
	* @return string The event which will be reserved
	*/
	public function getId_event() {
		return $this->id_event;
	}

	/**
	* Sets the event which will be reserved
	*
	* @param string $id_event The event which will be reserved
	* @return void
	*/
	public function setId_event($id_event) {
		$this->id_event = $id_event;
	}

	public function validateevent(){
		$errors = array();

		/*if($this->getName() == NULL){
			$errors["name"] = "The name is wrong";
		}

		if($this->getType() == NULL){
			$errors["type"] = "The type is wrong";
		}

		if($this->getStart_time() == NULL){
			$errors["start_time"] = "The start time is wrong";
		}

		if($this->getEnd_time() == NULL){
			$errors["end_time"] = "The end time is wrong";
		}

		if($this->getDescription() == NULL){
			$errors["description"] = "The description is wrong";
		}

		if($this->getDays() == NULL){
			$errors["days"] = "The days are wrong";
		}

		if($this->getCapacity() == NULL){
			$errors["capacity"] = "The capacity is wrong";
		}

		if($this->getId_space() == NULL){
			$errors["space"] = "The space is wrong";
		}

		if($this->getId_trainer() == NULL){
			$errors["trainer"] = "The trainer is wrong";
		}

		if($this->getPrice() == NULL){
			$errors["price"] = "The price is wrong";
		}

		if (sizeof($errors) > 0){
			throw new ValidationException($errors, "Event is not valid");
		}*/
	}
}
