<?php
// file: model/TournamentReservation.php

require_once(__DIR__."/../core/ValidationException.php");

/**
* Class TournamentReservation
*
* Represents a TournamentReservation in the academy
*
* @author braisda <braisda@gmail.com>
*/
class TournamentReservation {

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
	* @var string
	*/
	private $time;

	/**
	* The state of the reservation
	* @var string
	*/
	private $is_confirmed;

	/**
	* The competitor who send the reservation
	* @var string
	*/
	private $id_competitor;

	/**
	* The tournament which will be reserved
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
	* @var string
	*/
	private $description;

	/**
	* The start date of the tournament
	* @var string
	*/
	private $start_date;

	/**
	* The end date of the tournament
	* @var string
	*/
	private $end_date;

	/**
  * The price of the tournament
	* @var string
  */
  private $price;

	/**
	* The constructor
	*
	* @param string $id_reservation The id of this reservation
	* @param string $date The time of the reservation
  * @param string $time The type of the tournament
  * @param string $is_confirmed The state of the reservation
  * @param string $id_competitor The competitor who send the reservation
  * @param string $id_tournament The tournament which will be reserved
	* @param string $name The name of the tournament
  * @param string $description The description of the tournament
  * @param string $start_date The date time of the tournament
  * @param string $end_date The end date of the tournament
	* @param string $price The price of the tournament
	*/
	public function __construct($id_reservation=NULL, $date=NULL, $time=NULL,
															$is_confirmed=NULL, $id_competitor=NULL, $id_tournament=NULL, $name=NULL,
															$description=NULL, $start_date=NULL, $end_date=NULL, $price=NULL) {
		$this->id_reservation = $id_reservation;
		$this->date = $date;
		$this->time = $time;
		$this->is_confirmed = $is_confirmed;
		$this->id_competitor = $id_competitor;
    $this->id_tournament = $id_tournament;
		$this->name = $name;
		$this->description = $description;
		$this->start_date = $start_date;
		$this->end_date = $end_date;
		$this->price = $price;
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
	* Gets the competitor who send the reservation
	*
	* @return string The competitor who send the reservation
	*/
	public function getId_competitor() {
		return $this->id_competitor;
	}

	/**
	* Sets the capacity of this space
	*
	* @param string $id_competitor The capacity of this reservation
	* @return void
	*/
	public function setId_competitor($id_competitor) {
		$this->id_competitor = $id_competitor;
	}

  /**
	* Gets the tournament which will be reserved
	*
	* @return string The tournament which will be reserved
	*/
	public function getId_tournament() {
		return $this->id_tournament;
	}

	/**
	* Sets the tournament which will be reserved
	*
	* @param string $id_tournament The tournament which will be reserved
	* @return void
	*/
	public function setId_tournament($id_tournament) {
		$this->id_tournament = $id_tournament;
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
	* Sets the start time of this user
	*
	* @param string $start_date The start date of this tournament
	* @return void
	*/
	public function setStart_time($start_time) {
		$this->start_time = $start_time;
	}

	/**
	* Gets the end date of this tournament
	*
	* @return string The end date of this tournament
	*/
	public function getEnd_date() {
		return $this->end_date;
	}

	/**
	* Sets the end date of this tournament
	*
	* @param string $end_date The end date of this tournament
	* @return void
	*/
	public function setEnd_time($end_date) {
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
}
