<?php
// file: model/Tournament.php

require_once(__DIR__."/../core/ValidationException.php");

/**
* Class Tournament
*
* Represents a Tournament in the academy
*
* @author lipido <lipido@gmail.com>
*/
class Tournament {

	/**
	* The id of this tournament
	* @var string
	*/
	private $id_tournament;

	/**
	* The name of the tournament
	* @var string
	*/
	private $name;

	/**
	* The description of the tournament
	*/
	private $description;

	/**
	* The start date of the tournament
	*/
	private $start_date;

  /**
	* The end date of the tournament
	*/
	private $end_date;

	/**
	* The constructor
	*
	* @param $id_event The name of the event
	* @param $name The name of the event
  * @param $description The description of the event
  * @param $start_date The start date of the event
  * @param $start_date The start date of the event
  */
	public function __construct($id_tournament=NULL, $name=NULL, $description=NULL,
															$start_date=NULL, $end_date=NULL) {
		$this->id_tournament = $id_tournament;
		$this->name = $name;
		$this->description = $description;
		$this->start_date = $start_date;
		$this->end_date = $end_date;
	}

	/**
	* Gets the id of this event
	*
	* @return string The id of this event
	*/
	public function getId_tournament() {
		return $this->id_tournament;
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
  public function getStart_date() {
  	return $this->start_date;
  }

  /**
  * Sets the price of this event
  *
  * @param string $price The price of this event
  * @return void
  */
  public function setStart_date($start_date) {
  	$this->start_date = $start_date;
  }

	/**
	* Gets the capacity of this event
	*
	* @return string The capacity of this event
	*/
	public function getEnd_date() {
		return $this->end_date;
	}

	public function validateTournament(){
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
