<?php
// file: model/Event.php

require_once(__DIR__."/../core/ValidationException.php");

/**
* Class Event
*
* Represents a Event in the academy
*
* @author lipido <lipido@gmail.com>
*/
class Event {

	/**
	* The id of this event
	* @var string
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
	* @param $id_event The name of the event
	* @param $name The name of the event
  * @param $description The description of the event
  * @param $price The price of the event
  * @param $capacity The capacity of the event
  * @param $date The date of the event
  * @param $time The time of the event
  * @param $id_space The space of the event
  * @param $name_space The name of the event's space
	*/
	public function __construct($id_event=NULL, $name=NULL, $description=NULL,
															$price=NULL, $capacity=NULL, $date=NULL,
                              $time=NULL, $id_space=NULL, $name_space=NULL) {
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
	* Gets the id of this event
	*
	* @return string The id of this event
	*/
	public function getId_event() {
		return $this->id_event;
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

	public function validateEvent(){
		$errors = array();

		if($this->getName() == NULL){
			$errors["name"] = "The name is wrong";
		}

		if($this->getDescription() == NULL){
			$errors["description"] = "The description is wrong";
		}

		if($this->getPrice() == NULL){
			$errors["price"] = "The price is wrong";
		}

		if($this->getCapacity() == NULL){
			$errors["capacity"] = "The capacity is wrong";
		}

		if($this->getDate() == NULL){
			$errors["date"] = "The date is wrong";
		}

		if($this->getTime() == NULL){
			$errors["time"] = "The time is wrong";
		}

		if($this->getId_space() == NULL){
			$errors["space"] = "The space is wrong";
		}

		if (sizeof($errors) > 0){
			throw new ValidationException($errors, "User is not valid");
		}
	}
}
