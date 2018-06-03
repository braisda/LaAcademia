<?php
// file: model/Match.php

require_once(__DIR__."/../core/ValidationException.php");

/**
* Class Match
*
* Represents a Match in the academy
*
* @author braisda <braisda@gmail.com>
*/
class Match {

	/**
	* The id of this match
	* @var string
	*/
	private $id_match;

	/**
	* The rival1a of the match
	* @var string
	*/
	private $rival1a;

	/**
	* The rival1b of the match
	*/
	private $rival1b;

  /**
	* The rival2a of the match
	* @var string
	*/
	private $rival2a;

	/**
	* The rival2b of the match
	*/
	private $rival2b;

	/**
	* The date of the match
	*/
	private $date;

	/**
	* The time of the match
	*/
	private $time;

	/**
	* The space of the match
	*/
	private $id_space;

  /**
	* The round of the match
	*/
	private $round;

  /**
	* The cell of the match
	*/
	private $cell;

	/**
	* The set1a of the match
	*/
	private $set1a;

  /**
	* The set1b of the match
	*/
	private $set1b;

  /**
	* The set2a of the match
	*/
	private $set2a;

  /**
	* The set2b of the match
	*/
	private $set2b;

  /**
	* The set3a of the match
	*/
	private $set3a;

  /**
	* The set3b of the match
	*/
	private $set3b;

  /**
	* The set4a of the match
	*/
	private $set4a;

  /**
	* The set4b of the match
	*/
	private $set4b;

  /**
	* The set5a of the match
	*/
	private $set5a;

  /**
	* The set5b of the match
	*/
	private $set5b;

  /**
	* The draw id of the match
	*/
	private $id_draw;

	/**
	* The name and surname of the rival1a
	*/
	private $rival1a_name;

	/**
	* The name and surname of the rival1b
	*/
	private $rival1b_name;

	/**
	* The name and surname of the rival2a
	*/
	private $rival2a_name;

	/**
	* The name and surname of the rival2b
	*/
	private $rival2b_name;

	/**
	* The name of the space where the match is played
	*/
	private $space_name;

	/**
	* The constructor
	*
	* @param string $id_match The id of the match
	* @param string $rival1a The rival1a of the match
  * @param string $rival1b The rival1b of the match
  * @param string $rival2a The rival2a of the match
  * @param string $rival2b The rival2b of the match
  * @param string $date The date of the match
	* @param string $time The time of the match
	* @param string $id_space The space of the match
  * @param string $round The round of the match
  * @param string $cell The cell of the match
  * @param string $set1a The set1a of the match
  * @param string $set1b The set1b of the match
  * @param string $set2a The set2a of the match
  * @param string $set2b The set2b of the match
  * @param string $set3a The set3a of the match
  * @param string $set3b The set3b of the match
  * @param string $set4a The set4a of the match
  * @param string $set4b The set4b of the match
  * @param string $set5a The set5a of the match
  * @param string $set5b The set5b of the match
  * @param string $id_draw The id of the draw
	* @param string $rival1a_name The name and surname of the rival1a
	* @param string $rival1b_name The name and surname of the rival1b
	* @param string $rival2a_name The name and surname of the rival2a
	* @param string $rival2b_name The name and surname of the rival2b
	* @param string $space_name The name of the space where the match is played
  */
	public function __construct($id_match=NULL, $rival1a=NULL, $rival1b=NULL,
															$rival2a=NULL, $rival2b=NULL, $date=NULL, $time=NULL, $id_space=NULL,
                              $round=NULL, $cell=NULL, $set1a=NULL, $set1b=NULL,
                            	$set2a=NULL, $set2b=NULL, $set3a=NULL,
                              $set3b=NULL, $set4a=NULL, $set4b=NULL,
                              $set5a=NULL, $set5b=NULL, $id_draw=NULL,
															$rival1a_name=NULL, $rival1b_name=NULL, $rival2a_name=NULL,
															$rival2b_name=NULL, $space_name=NULL) {
		$this->id_match = $id_match;
		$this->rival1a = $rival1a;
		$this->rival1b = $rival1b;
		$this->rival2a = $rival2a;
		$this->rival2b = $rival2b;
		$this->date = $date;
		$this->time = $time;
		$this->id_space = $id_space;
    $this->round = $round;
    $this->cell = $cell;
		$this->set1a = $set1a;
		$this->set1b = $set1b;
		$this->set2a = $set2a;
		$this->set2b = $set2b;
		$this->set3a = $set3a;
    $this->set3b = $set3b;
		$this->set4a = $set4a;
		$this->set4b = $set4b;
		$this->set5a = $set5a;
		$this->set5b = $set5b;
		$this->id_draw = $id_draw;
		$this->rival1a_name = $rival1a_name;
		$this->rival1b_name = $rival1b_name;
		$this->rival2a_name = $rival2a_name;
		$this->rival2b_name = $rival2b_name;
		$this->space_name = $space_name;
	}

	/**
	* Gets the id of this match
	*
	* @return string The id of this match
	*/
	public function getId_match() {
		return $this->id_match;
	}

	/**
	* Gets the rival1a of this match
	*
	* @return string The rival1a of this match
	*/
	public function getRival1a() {
		return $this->rival1a;
	}

	/**
	* Sets the rival1a of this match
	*
	* @param string $rival1a The rival1a of this match
	* @return void
	*/
	public function setRival1a($rival1a) {
		$this->rival1a = $rival1a;
	}

  /**
	* Gets the rival1b of this match
	*
	* @return string The rival1b of this match
	*/
	public function getRival1b() {
		return $this->rival1b;
	}

	/**
	* Sets the rival1b of this match
	*
	* @param string $rival1b The rival1a of this match
	* @return void
	*/
	public function setRival1b($rival1b) {
		$this->rival1b = $rival1b;
	}

  /**
	* Gets the rival2a of this match
	*
	* @return string The rival2a of this match
	*/
	public function getRival2a() {
		return $this->rival2a;
	}

	/**
	* Sets the rival2a of this match
	*
	* @param string $rival2a The rival2a of this match
	* @return void
	*/
	public function setRival2a($rival2a) {
		$this->rival2a = $rival2a;
	}

  /**
	* Gets the rival2b of this match
	*
	* @return string The rival2b of this match
	*/
	public function getRival2b() {
		return $this->rival2b;
	}

	/**
	* Sets the rival2b of this match
	*
	* @param string $rival2b The rival2a of this match
	* @return void
	*/
	public function setRival2b($rival2b) {
		$this->rival2b = $rival2b;
	}

  /**
	* Gets the date of this match
	*
	* @return string The date of this match
	*/
	public function getDate() {
		return $this->date;
	}

	/**
	* Sets the date of this match
	*
	* @param string $date The date of this match
	* @return void
	*/
	public function setDate($date) {
		$this->date = $date;
	}

	/**
	* Gets the time of this match
	*
	* @return string The time of this match
	*/
	public function getTime() {
		return $this->time;
	}

	/**
	* Sets the time of this match
	*
	* @param string $time The time of this match
	* @return void
	*/
	public function setTime($time) {
		$this->time = $time;
	}

	/**
	* Gets the space id of this match
	*
	* @return string The space id of this match
	*/
	public function getId_space() {
		return $this->id_space;
	}

	/**
	* Sets the space id of this match
	*
	* @param string $id_space The space id of this match
	* @return void
	*/
	public function setId_space($id_space) {
		$this->id_space = $id_space;
	}

  /**
	* Gets the round of this match
	*
	* @return string The round of this match
	*/
	public function getRound() {
		return $this->round;
	}

	/**
	* Sets the round of this match
	*
	* @param string $round The round of this match
	* @return void
	*/
	public function setRound($round) {
		$this->round = $round;
	}

  /**
	* Gets the cell of this match
	*
	* @return string The cell of this match
	*/
	public function getCell() {
		return $this->cell;
	}

	/**
	* Sets the cell of this match
	*
	* @param string $cell The cell of this match
	* @return void
	*/
	public function setCell($cell) {
		$this->cell = $cell;
	}

  /**
	* Gets the set1a of this match
	*
	* @return string The set1a of this match
	*/
	public function getSet1a() {
		return $this->set1a;
	}

	/**
	* Sets the set1a of this match
	*
	* @param string $set1a The set1a of this match
	* @return void
	*/
	public function setSet1a($set1a) {
		$this->set1a = $set1a;
	}

  /**
	* Gets the set1b of this match
	*
	* @return string The set1b of this match
	*/
	public function getSet1b() {
		return $this->set1b;
	}

	/**
	* Sets the set1b of this match
	*
	* @param string $set1b The set1b of this match
	* @return void
	*/
	public function setSet1b($set1b) {
		$this->set1b = $set1b;
	}

  /**
	* Gets the set2a of this match
	*
	* @return string The set2a of this match
	*/
	public function getSet2a() {
		return $this->set2a;
	}

	/**
	* Sets the set2a of this match
	*
	* @param string $set2a The set2a of this match
	* @return void
	*/
	public function setSet2a($set2a) {
		$this->set2a = $set2a;
	}

  /**
	* Gets the set2b of this match
	*
	* @return string The set2b of this match
	*/
	public function getSet2b() {
		return $this->set2b;
	}

	/**
	* Sets the set2b of this match
	*
	* @param string $set2b The set2b of this match
	* @return void
	*/
	public function setSet2b($set2b) {
		$this->set2b = $set2b;
	}

  /**
	* Gets the set3a of this match
	*
	* @return string The set3a of this match
	*/
	public function getSet3a() {
		return $this->set3a;
	}

	/**
	* Sets the set3a of this match
	*
	* @param string $set3a The set3a of this match
	* @return void
	*/
	public function setSet3a($set3a) {
		$this->set3a = $set3a;
	}

  /**
	* Gets the set3b of this match
	*
	* @return string The set3b of this match
	*/
	public function getSet3b() {
		return $this->set3b;
	}

	/**
	* Sets the set3b of this match
	*
	* @param string $set3b The set3b of this match
	* @return void
	*/
	public function setSet3b($set3b) {
		$this->set3b = $set3b;
	}

  /**
	* Gets the set4a of this match
	*
	* @return string The set4a of this match
	*/
	public function getSet4a() {
		return $this->set4a;
	}

	/**
	* Sets the set4a of this match
	*
	* @param string $set4a The set4a of this match
	* @return void
	*/
	public function setSet4a($set4a) {
		$this->set4a = $set4a;
	}

  /**
	* Gets the set4b of this match
	*
	* @return string The set4b of this match
	*/
	public function getSet4b() {
		return $this->set4b;
	}

	/**
	* Sets the set4b of this match
	*
	* @param string $set4b The set4b of this match
	* @return void
	*/
	public function setSet4b($set4b) {
		$this->set4b = $set4b;
	}

  /**
	* Gets the set5a of this match
	*
	* @return string The set5a of this match
	*/
	public function getSet5a() {
		return $this->set5a;
	}

	/**
	* Sets the set5a of this match
	*
	* @param string $set5a The set5a of this match
	* @return void
	*/
	public function setSet5a($set5a) {
		$this->set5a = $set5a;
	}

  /**
	* Gets the set5b of this match
	*
	* @return string The set5b of this match
	*/
	public function getSet5b() {
		return $this->set5b;
	}

	/**
	* Sets the set5b of this match
	*
	* @param string $set5b The set5b of this match
	* @return void
	*/
	public function setSet5b($set5b) {
		$this->set5b = $set5b;
	}

  /**
	* Gets the draw id of this match
	*
	* @return string The draw id of this match
	*/
	public function getId_draw() {
		return $this->id_draw;
	}

	/**
	* Sets the draw id of this match
	*
	* @param string $id_draw The draw id of this match
	* @return void
	*/
	public function setId_draw($id_draw) {
		$this->id_draw = $id_draw;
	}

	/**
	* Gets the name and surname of the rival1a
	*
	* @return string The name and surname of the rival1a
	*/
	public function getName_rival1a() {
		return $this->rival1a_name;
	}

	/**
	* Gets the name and surname of the rival1b
	*
	* @return string The name and surname of the rival1b
	*/
	public function getName_rival1b() {
		return $this->rival1b_name;
	}

	/**
	* Gets the name and surname of the rival2a
	*
	* @return string The name and surname of the rival2a
	*/
	public function getName_rival2a() {
		return $this->rival2a_name;
	}

	/**
	* Gets the name and surname of the rival2b
	*
	* @return string The name and surname of the rival2b
	*/
	public function getName_rival2b() {
		return $this->rival2b_name;
	}

	/**
	* Gets the name of the space where the matchis played
	*
	* @return string The of the space where the matchis played
	*/
	public function getName_space() {
		return $this->space_name;
	}

	/**
	* Checks if the current instance is valid
	* for being inserted in the database.
	*
	* @param string $name The name of this match
	* @param string $description The description password of this match
	*
	* @throws ValidationException if the instance is not valid
	*
	* @return void
	*/
	public function validateMatch(){
		$errors = array();

		if($this->getRival1a() == ""){
			$errors["rival1a"] = "The rival can not be empty";
		}

		if($this->getDate() == ""){
			$errors["date"] = "The date can not be empty";
		}

		if($this->getTime() == NULL){
			$errors["time"] = "The time can not be empty";
		}

		if($this->getId_space() == NULL){
			$errors["space"] = "The space can not be empty";
		}

		if($this->getSet1a() < 0){
			$errors["set1a"] = "The set can not be negative";
		}

		if (sizeof($errors) > 0){
			throw new ValidationException($errors, "User is not valid");
		}
	}
}
