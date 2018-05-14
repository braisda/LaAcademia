<?php
// file: model/CourseReservation.php

require_once(__DIR__."/../core/ValidationException.php");

/**
* Class CourseReservation
*
* Represents a CourseReservation in the academy
*
* @author braisda <braisda@gmail.com>
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
	* @var string
	*/
	private $time;

	/**
	* The state of the reservation
	* @var string
	*/
	private $is_confirmed;

	/**
	* The pupil who send the reservation
	* @var string
	*/
	private $id_pupil;

	/**
	* The course which will be reserved
	* @var string
	*/
	private $id_course;

	/**
	* The name of the course
	* @var string
	*/
	private $name;

	/**
	* The type of the course
	* @var string
	*/
	private $type;

	/**
	* The description of the course
	* @var string
	*/
	private $description;

	/**
	* The capacity of the course
	* @var string
	*/
	private $capacity;

	/**
	* The days when the course is taught
	* @var string
	*/
	private $days;

	/**
	* The start time of the course
	* @var string
	*/
	private $start_time;

	/**
	* The end time of the course
	* @var string
	*/
	private $end_time;

	/**
	* The space of the course
	* @var string
	*/
	private $id_space;

	/**
  * The space name of the course
	* @var string
  */
  private $name_space;

	/**
	* The trainer of the course
	* @var string
	*/
	private $id_trainer;

	/**
  * The trainer name of the course
	* @var string
  */
  private $name_trainer;

	/**
  * The price of the course
	* @var string
  */
  private $price;

	/**
	* The constructor
	*
	* @param string $id_reservation The id of this reservation
	* @param string $date The time of the reservation
  * @param string $time The type of the course
  * @param string $is_confirmed The state of the reservation
  * @param string $id_pupil The pupil who send the reservation
  * @param string $id_course The course which will be reserved
	* @param string $name The name of the course
  * @param string $type The type of the course
  * @param string $description The description of the course
  * @param string $capacity The capacity of the course
  * @param string $days The days when the course is taught
  * @param string $start_time The start time of the course
  * @param string $end_time The end time of the course
	* @param string $id_space The space of the course
  * @param string $id_trainer The trainer of the course
	* @param string $name_space The name of the course's space
	* @param string $name_trainer The name of the course's trainer
	* @param string $price The price of the course
	*/
	public function __construct($id_reservation=NULL, $date=NULL, $time=NULL,
															$is_confirmed=NULL, $id_pupil=NULL, $id_course=NULL, $name=NULL, $type=NULL,
															$description=NULL, $capacity=NULL, $days=NULL,
														  $start_time=NULL, $end_time=NULL, $id_space=NULL,
															$id_trainer=NULL, $name_space=NULL, $name_trainer=NULL, $price=NULL) {
		$this->id_reservation = $id_reservation;
		$this->date = $date;
		$this->time = $time;
		$this->is_confirmed = $is_confirmed;
		$this->id_pupil = $id_pupil;
    $this->id_course = $id_course;
		$this->name = $name;
		$this->type = $type;
		$this->description = $description;
		$this->capacity = $capacity;
		$this->days = $days;
		$this->start_time = $start_time;
		$this->end_time = $end_time;
		$this->id_space = $id_space;
		$this->id_trainer = $id_trainer;
		$this->name_space = $name_space;
		$this->name_trainer = $name_trainer;
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

	/**
	* Gets the name of this course
	*
	* @return string The name of this course
	*/
	public function getName() {
		return $this->name;
	}

	/**
	* Sets the name of this course
	*
	* @param string $name The name of this course
	* @return void
	*/
	public function setName($name) {
		$this->name = $name;
	}

	/**
	* Gets the type of this course
	*
	* @return string The type of this course
	*/
	public function getType() {
		return $this->type;
	}

	/**
	* Sets the type of this user
	*
	* @param string $type The type of this user
	* @return void
	*/
	public function setType($type) {
		$this->type = $type;
	}

	/**
	* Gets the description of this course
	*
	* @return string The description of this course
	*/
	public function getDescription() {
		return $this->description;
	}

	/**
	* Sets the description of this course
	*
	* @param string $description The description of this course
	* @return void
	*/
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	* Gets the capacity of this course
	*
	* @return string The capacity of this course
	*/
	public function getCapacity() {
		return $this->capacity;
	}

	/**
	* Sets the capacity of this space
	*
	* @param string $capacity The capacity of this course
	* @return void
	*/
	public function setCapacity($capacity) {
		$this->capacity = $capacity;
	}

	/**
	* Gets the days of this user
	*
	* @return string The days when the course is taught
	*/
	public function getDays() {
		return $this->days;
	}

	/**
	* Sets the days when the course is taught
	*
	* @param string $days The days when the course is taught
	* @return void
	*/
	public function setDays($days) {
		$this->days = $days;
	}

	/**
	* Gets the start time of this course
	*
	* @return string The start time of this user
	*/
	public function getStart_time() {
		return $this->start_time;
	}

	/**
	* Sets the start time of this user
	*
	* @param string $start_time The birthdate of this user
	* @return void
	*/
	public function setStart_time($start_time) {
		$this->start_time = $start_time;
	}

	/**
	* Gets the end time of this course
	*
	* @return string The end time of this course
	*/
	public function getEnd_time() {
		return $this->end_time;
	}

	/**
	* Sets the end time of this course
	*
	* @param string $end_time The end time of this course
	* @return void
	*/
	public function setEnd_time($end_time) {
		$this->end_time = $end_time;
	}

	/**
	* Gets the space of this course
	*
	* @return string The space of this course
	*/
	public function getId_space() {
		return $this->id_space;
	}

	/**
	* Sets the id_space of this space
	*
	* @param string $id_space The space of this course
	* @return void
	*/
	public function setId_space($id_space) {
		$this->id_space = $id_space;
	}

	/**
	* Gets the trainer of this course
	*
	* @return string The trainer of this course
	*/
	public function getId_trainer() {
		return $this->id_trainer;
	}

	/**
	* Sets the trainer of this course
	*
	* @param string $id_trainer The trainer of this course
	* @return void
	*/
	public function setId_trainer($id_trainer) {
		$this->id_trainer = $id_trainer;
	}

	/**
	* Gets the name of the event's space
	*
	* @return string The name of the event's space
	*/
	public function getName_space() {
		return $this->name_space;
	}

	/**
	* Gets the name of the course's trainer
	*
	* @return string The name of the course's trainer
	*/
	public function getName_trainer() {
		return $this->name_trainer;
	}

	/**
	* Gets the price of this course
	*
	* @return string The price of this course
	*/
	public function getPrice() {
		return $this->price;
	}

	/**
	* Sets the price of this course
	*
	* @param string $price The price of this course
	* @return void
	*/
	public function setPrice($price) {
		$this->price = $price;
	}
}
