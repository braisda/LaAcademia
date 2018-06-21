<?php
// file: model/EventReservation.php

require_once(__DIR__."/../core/ValidationException.php");

/**
* Class EventReservation
*
* Represents a EventReservation in the academy
*
* @author braisda <braisda@gmail.com>
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
	private $dateReservation;

	/**
	* The time of the reservation
	*/
	private $timeReservation;

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
	* The name of the event
	* @var string
	*/
	private $name;

	/**
	* The description of the event
	*/
	private $description;

  /**
	* The price of the event
	*/
	private $price;

	/**
	* The capacity of the event
	*/
	private $capacity;

	/**
	* The date of the event
	*/
	private $date;

  /**
	* The time of the event
	*/
	private $time;

	/**
	* The space of the event
	*/
	private $id_space;

  /**
  * The space of the event
  */
  private $name_space;

	/**
	* The constructor
	*
	* @param $id_reservation The id of this reservation
	* @param $dateReservation The time of the reservation
  * @param $timeReservation The type of the event
  * @param $is_confirmed The state of the reservation
  * @param $id_assistant The assistant who send the reservation
  * @param $id_event The event which will be reserved
	* @param $name The name of the event
  * @param $description The description of the event
  * @param $price The price of the event
  * @param $capacity The capacity of the event
  * @param $date The date of the event
  * @param $time The time of the event
  * @param $id_space The space of the event
  * @param $name_space The name of the event's space
	*/
	public function __construct($id_reservation=NULL, $dateReservation=NULL, $timeReservation=NULL,
															$is_confirmed=NULL, $id_assistant=NULL, $id_event=NULL,
															$name=NULL, $description=NULL,
															$price=NULL, $capacity=NULL, $date=NULL,
														  $time=NULL, $id_space=NULL, $name_space=NULL) {
		$this->id_reservation = $id_reservation;
		$this->dateReservation = $dateReservation;
		$this->timeReservation = $timeReservation;
		$this->is_confirmed = $is_confirmed;
		$this->id_assistant = $id_assistant;
    $this->id_event = $id_event;
		$this->name = $name;
		$this->description = $description;
		$this->price = $price;
		$this->capacity = $capacity;
		$this->date = $date;
		$this->time = $time;
		$this->id_space = $id_space;
    $this->name_space = $name_space;
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
	public function getDateReservation() {
		return $this->dateReservation;
	}

	/**
	* Sets the time of this reservation
	*
	* @param string $time The time of this reservation
	* @return void
	*/
	public function setDateReservation($date) {
		$this->dateReservation = $dateReservation;
	}

	/**
	* Gets the time of this reservation
	*
	* @return string The time of this reservation
	*/
	public function getTimeReservation() {
		return $this->timeReservation;
	}

  /**
	* Sets the time of this reservation
	*
	* @param string $time The time of this reservation
	* @return void
	*/
	public function setTimeReservatino($timeReservation) {
		$this->timeReservation = $timeReservation;
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

	/**
	* Gets the name of this event
	*
	* @return string The name of this event
	*/
	public function getName() {
		return $this->name;
	}

	/**
	* Sets the name of this event
	*
	* @param string $name The name of this event
	* @return void
	*/
	public function setName($name) {
		$this->name = $name;
	}

	/**
	* Gets the description of this event
	*
	* @return string The description of this event
	*/
	public function getDescription() {
		return $this->description;
	}

	/**
	* Sets the description of this event
	*
	* @param string $description The description of this event
	* @return void
	*/
	public function setDescription($description) {
		$this->description = $description;
	}

  /**
  * Gets the price of this event
  *
  * @return string The price of this event
  */
  public function getprice() {
  	return $this->price;
  }

  /**
  * Sets the price of this event
  *
  * @param string $price The price of this event
  * @return void
  */
  public function setprice($price) {
  	$this->price = $price;
  }

	/**
	* Gets the capacity of this event
	*
	* @return string The capacity of this event
	*/
	public function getCapacity() {
		return $this->capacity;
	}

	/**
	* Sets the capacity of this space
	*
	* @param string $capacity The capacity of this event
	* @return void
	*/
	public function setCapacity($capacity) {
		$this->capacity = $capacity;
	}

	/**
	* Gets the date of this event
	*
	* @return string The date of this event
	*/
	public function getDate() {
		return $this->date;
	}

	/**
	* Sets the date of this event
	*
	* @param string $date The date of this event
	* @return void
	*/
	public function setDate($date) {
		$this->date = $date;
	}

	/**
	* Gets the time of this event
	*
	* @return string The start time of this user
	*/
	public function getTime() {
		return $this->time;
	}

	/**
	* Sets the time of this event
	*
	* @param string $time The time of this event
	* @return void
	*/
	public function setTime($time) {
		$this->time = $time;
	}

	/**
	* Gets the id of the event's space
	*
	* @return string The id of the event's space
	*/
	public function getId_space() {
		return $this->id_space;
	}

	/**
	* Sets the id of the event's space
	*
	* @param string $id_space The id of the event's space
	* @return void
	*/
	public function setId_space($id_space) {
		$this->id_space = $id_space;
	}

	/**
	* Gets the name of the event's space
	*
	* @return string The name of the event's space
	*/
	public function getName_space() {
		return $this->name_space;
	}
}
