<?php
// file: model/Draw.php

require_once(__DIR__."/../core/ValidationException.php");

/**
* Class Draw
*
* Represents a Draw in the academy
*
* @author braisda <braisda@gmail.com>
*/
class Draw {

	/**
	* The id of this draw
	* @var string
	*/
	private $id_draw;

	/**
	* The modality of the draw
	* @var string
	*/
	private $modality;

	/**
	* The gender of the draw
	*/
	private $gender;

	/**
	* The start date of the draw
	*/
	private $id_tournament;

	/**
	* The constructor
	*
	* @param $id_draw The id of the draw
	* @param $modality The modality of the draw
  * @param $gender The gender of the draw
  * @param $id_tournament The start date of the draw
  */
	public function __construct($id_draw=NULL, $modality=NULL, $gender=NULL,
															$id_tournament=NULL) {
		$this->id_draw = $id_draw;
		$this->modality = $modality;
		$this->gender = $gender;
		$this->id_tournament = $id_tournament;
	}

	/**
	* Gets the id of this draw
	*
	* @return string The id of this draw
	*/
	public function getId_draw() {
		return $this->id_draw;
	}

	/**
	* Gets the modality of this draw
	*
	* @return string The modality of this draw
	*/
	public function getModality() {
		return $this->modality;
	}

	/**
	* Sets the modality of this draw
	*
	* @param string $modality The modality of this draw
	* @return void
	*/
	public function setModality($modality) {
		$this->modality = $modality;
	}

	/**
	* Gets the gender of this draw
	*
	* @return string The gender of this draw
	*/
	public function getGender() {
		return $this->gender;
	}

	/**
	* Sets the gender of this draw
	*
	* @param string $gender The gender of this draw
	* @return void
	*/
	public function setGender($gender) {
		$this->gender = $gender;
	}

  /**
  * Gets the start date of this draw
  *
  * @return string The start date of this draw
  */
  public function getId_tournament() {
  	return $this->id_tournament;
  }

  /**
  * Sets the start date of this draw
  *
  * @param string $start date The start date of this draw
  * @return void
  */
  public function setId_tournament($id_tournament) {
  	$this->id_tournament = $id_tournament;
  }

	/**
	* Checks if the current instance is valid
	* for being inserted in the database.
	*
	* @param string $modality The modality of this draw
	* @param string $gender The gender password of this draw
	*
	* @throws ValidationException if the instance is not valid
	*
	* @return void
	*/
	public function validateDraw(){
		$errors = array();

		if($this->getModality() == NULL){
			$errors["modality"] = "The modality is wrong";
		}

		if($this->getGender() == NULL){
			$errors["gender"] = "The gender is wrong";
		}

		if (sizeof($errors) > 0){
			throw new ValidationException($errors, "Draw is not valid");
		}
	}
}
