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
	* The prize of the event
	*/
	private $prize;

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
	* The constructor
	*
	* @param $id_event The name of the event
	* @param $name The name of the event
  * @param $description The description of the event
  * @param $prize The prize of the event
  * @param $capacity The capacity of the event
  * @param $date The date of the event
  * @param $time The time of the event
  * @param $id_space The space of the event
	*/
	public function __construct($id_event=NULL, $name=NULL, $description=NULL,
															$prize=NULL, $capacity=NULL, $date=NULL,
                              $time=NULL, $id_space=NULL) {
		$this->id_event = $id_event;
		$this->name = $name;
		$this->description = $description;
		$this->prize = $prize;
		$this->capacity = $capacity;
		$this->date = $date;
		$this->time = $time;
		$this->id_space = $id_space;
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
  * Gets the prize of this event
  *
  * @return string The prize of this event
  */
  public function getPrize() {
  	return $this->prize;
  }

  /**
  * Sets the prize of this event
  *
  * @param string $prize The prize of this event
  * @return void
  */
  public function setPrize($prize) {
  	$this->prize = $prize;
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
	* Gets the time of this event
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
	public function setEnd_time($id_space) {
		$this->id_space = $id_space;
	}
}
