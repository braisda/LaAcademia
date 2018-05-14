<?php
// file: model/Course.php

require_once(__DIR__."/../core/ValidationException.php");

/**
* Class Course
*
* Represents a Course in the academy
*
* @author braisda <braisda@gmail.com>
*/
class Course {

	/**
	* The id of this course
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
	* @param string $id_course The name of the course
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
	public function __construct($id_course=NULL, $name=NULL, $type=NULL,
															$description=NULL, $capacity=NULL, $days=NULL,
                              $start_time=NULL, $end_time=NULL, $id_space=NULL,
															$id_trainer=NULL, $name_space=NULL, $name_trainer=NULL, $price=NULL) {
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
	* Gets the id of this course
	*
	* @return string The id of this course
	*/
	public function getId_course() {
		return $this->id_course;
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

	/**
	* Checks if the current instance is valid
	* for being inserted in the database.
	*
	* @param string $password The password of this user
	* @param string $repitedpassword The repeated password of this user
	* @param string $imageName The name of the image of this user
	* @param string $imageType The type the image of this user
	* @param string $imageSize The image size of the image of this user
	* @param string $checkPassword A indicator to check the password
	*								(don't check if is an update that doesn't changes the password)
	* @param string $checkImage A indicator to check the image
	*								(don't check if is a update that doesn't changes the image)
	*
	* @throws ValidationException if the instance is not valid
	*
	* @return void
	*/
	public function validateCourse(){
		$errors = array();

		$expName = '/^[A-Za-z0-9\sáéíóúÁÉÍÓÚ]+$/';

		if($this->getName() == NULL){
			$errors["name"] = "The name is wrong";
		}

		if(!$this->getName() == NULL &&!preg_match($expName, $this->getName())){
			$errors["name"] = "Name must have only letters and numbers";
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

		if(!$this->getDescription() == NULL &&!preg_match($expName, $this->getDescription())){
			$errors["description"] = "Description must have only letters and numbers";
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
		}
	}
}
