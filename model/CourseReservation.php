<?php
// file: model/CourseReservation.php

require_once(__DIR__."/../core/ValidationException.php");

/**
* Class CourseReservation
*
* Represents a CourseReservation in the academy
*
* @author lipido <lipido@gmail.com>
*/
class CourseReservation {

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
	* The pupil who send the reservation
	*/
	private $id_pupil;

	/**
	* The course which will be reserved
	*/
	private $id_course;

	/**
	* The constructor
	*
	* @param $id_reservation The id of this reservation
	* @param $date The time of the reservation
  * @param $time The type of the course
  * @param $is_confirmed The state of the reservation
  * @param $id_pupil The pupil who send the reservation
  * @param $id_course The course which will be reserved
	*/
	public function __construct($id_reservation=NULL, $date=NULL, $time=NULL,
															$is_confirmed=NULL, $id_pupil=NULL, $id_course=NULL) {
		$this->id_reservation = $id_reservation;
		$this->date = $date;
		$this->time = $time;
		$this->is_confirmed = $is_confirmed;
		$this->id_pupil = $id_pupil;
    $this->id_course = $id_course;
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
	* Gets the pupil who send the reservation
	*
	* @return string The pupil who send the reservation
	*/
	public function getId_pupil() {
		return $this->id_pupil;
	}

	/**
	* Sets the capacity of this space
	*
	* @param string $id_pupil The capacity of this reservation
	* @return void
	*/
	public function setId_pupil($id_pupil) {
		$this->id_pupil = $id_pupil;
	}

  /**
	* Gets the course which will be reserved
	*
	* @return string The course which will be reserved
	*/
	public function getId_course() {
		return $this->id_course;
	}

	/**
	* Sets the course which will be reserved
	*
	* @param string $id_course The course which will be reserved
	* @return void
	*/
	public function setId_course($id_course) {
		$this->id_course = $id_course;
	}

	public function validateCourse(){
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
			throw new ValidationException($errors, "Course is not valid");
		}*/
	}
}
