<?php
// file: model/User.php

require_once(__DIR__."/../core/ValidationException.php");

/**
* Class Course
*
* Represents a Course in the academy
*
* @author lipido <lipido@gmail.com>
*/
class Course {

	/**
	* The id of this course
	* @var string
	*/
	private $id_course;

	/**
	* The user name of the course
	* @var string
	*/
	private $name;

	/**
	* The type of the course
	*/
	private $type;

	/**
	* The description of the course
	*/
	private $description;

	/**
	* The capacity of the course
	*/
	private $capacity;

	/**
	* The days when the course is taught
	*/
	private $days;

	/**
	* The start time of the course
	*/
	private $start_time;

	/**
	* The end time of the course
	*/
	private $end_time;

	/**
	* The constructor
	*
	* @param $id_course The name of the user
	* @param $name The name of the course
  * @param $type The type of the course
  * @param $description The description of the course
  * @param $capacity The capacity of the course
  * @param $days The days when the course is taught
  * @param $start_time The start time of the course
  * @param $end_time The end time of the course
	*/
	public function __construct($id_course=NULL, $name=NULL, $type=NULL,
															$description=NULL, $capacity=NULL, $days=NULL,
                              $start_time=NULL, $end_time=NULL) {
		$this->id_course = $id_course;
		$this->name = $name;
		$this->type = $type;
		$this->description = $description;
		$this->capacity = $capacity;
		$this->days = $days;
		$this->start_time = $start_time;
		$this->end_time = $end_time;
	}

	/**
	* Gets the id of this course
	*
	* @return string The id of this course
	*/
	public function getId_course() {
		return $this->id_course;
	}

	/**
	* Gets the name of this user
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
	* Sets the surname of this user
	*
	* @param string $type The surname of this user
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
	* Sets the capacity of this user
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
}
