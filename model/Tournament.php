<?php
// file: model/Tournament.php

require_once(__DIR__."/../core/ValidationException.php");

/**
* Class Tournament
*
* Represents a Tournament in the academy
*
* @author braisda <braisda@gmail.com>
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
	* The price of the tournament
	*/
	private $price;

	/**
	* The constructor
	*
	* @param string $id_tournament The id of the tournament
	* @param string $name The name of the tournament
  * @param string $description The description of the tournament
  * @param string $start_date The start date of the tournament
  * @param string $start_date The start date of the tournament
	* @param string $price The price of the tournament
  */
	public function __construct($id_tournament=NULL, $name=NULL, $description=NULL,
															$start_date=NULL, $end_date=NULL, $price=NULL) {
		$this->id_tournament = $id_tournament;
		$this->name = $name;
		$this->description = $description;
		$this->start_date = $start_date;
		$this->end_date = $end_date;
		$this->price = $price;
	}

	/**
	* Gets the id of this tournament
	*
	* @return string The id of this tournament
	*/
	public function getId_tournament() {
		return $this->id_tournament;
	}

	/**
	* Gets the name of this tournament
	*
	* @return string The name of this tournament
	*/
	public function getName() {
		return $this->name;
	}

	/**
	* Sets the name of this tournament
	*
	* @param string $name The name of this tournament
	* @return void
	*/
	public function setName($name) {
		$this->name = $name;
	}

	/**
	* Gets the description of this tournament
	*
	* @return string The description of this tournament
	*/
	public function getDescription() {
		return $this->description;
	}

	/**
	* Sets the description of this tournament
	*
	* @param string $description The description of this tournament
	* @return void
	*/
	public function setDescription($description) {
		$this->description = $description;
	}

  /**
  * Gets the start date of this tournament
  *
  * @return string The start date of this tournament
  */
  public function getStart_date() {
  	return $this->start_date;
  }

  /**
  * Sets the start date of this tournament
  *
  * @param string $start date The start date of this tournament
  * @return void
  */
  public function setStart_date($start_date) {
  	$this->start_date = $start_date;
  }

	/**
	* Gets the end_date of this tournament
	*
	* @return string The end_date of this tournament
	*/
	public function getEnd_date() {
		return $this->end_date;
	}

	/**
  * Sets the end_date of this tournament
  *
  * @param string $end_date The end_date of this tournament
  * @return void
  */
  public function setEnd_date($end_date) {
  	$this->end_date = $end_date;
  }

	/**
	* Gets the price of this tournament
	*
	* @return string The price of this tournament
	*/
	public function getPrice() {
		return $this->price;
	}

	/**
	* Sets the price of this tournament
	*
	* @param string $price The price of this tournament
	* @return void
	*/
	public function setPrice($price) {
		$this->price = $price;
	}

	/**
	* Checks if the current instance is valid
	* for being inserted in the database.
	*
	* @param string $name The name of this tournament
	* @param string $description The description password of this tournament
	*
	* @throws ValidationException if the instance is not valid
	*
	* @return void
	*/
	public function validateTournament(){
		$errors = array();

		$expName = '/^[A-Za-z0-9\sáéíóúÁÉÍÓÚ]+$/';
		$expDescrip ="/^[A-Za-z0-9\sáéíóúÁÉÍÓÚñÑ()ºª.:,\"'¡!\-\+\/]+$/";

		if($this->getName() == NULL){
			$errors["name"] = "The name is wrong";
		}

		if(!$this->getName() == NULL && !preg_match($expName, $this->getName())){
			$errors["name"] = "Name must have only letters and numbers";
		}

		if($this->getDescription() == NULL){
			$errors["description"] = "The description is wrong";
		}

		if(!$this->getDescription() == NULL && !preg_match($expDescrip, $this->getDescription())){
			$errors["description"] = "Description must have only letters and numbers";
		}

		if (sizeof($errors) > 0){
			throw new ValidationException($errors, "Tournament is not valid");
		}
	}
}
