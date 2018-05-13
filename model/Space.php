<?php
// file: model/Space.php

require_once(__DIR__."/../core/ValidationException.php");

/**
* Class Space
*
* Represents a Space in the academy
*
* @author lipido <lipido@gmail.com>
*/
class Space {

	/**
	* The id of this space
	* @var string
	*/
	private $id_space;

	/**
	* The name of the space
	* @var string
	*/
	private $name;

  /**
	* The capacity of the space
	*/
	private $capacity;

	/**
	* The image of the space
	*/
	private $image;

	/**
	* The constructor
	*
	* @param $id_space The name of the space
	* @param $name The name of the space
  * @param $capacity The capacity of the space
  * @param $image The image of the space
	*/
	public function __construct($id_space=NULL, $name=NULL, $capacity=NULL, $image=NULL) {
		$this->id_space = $id_space;
		$this->name = $name;
    $this->capacity = $capacity;
    $this->image = $image;
	}

	/**
	* Gets the id of this space
	*
	* @return string The id of this space
	*/
	public function getId_space() {
		return $this->id_space;
	}

	/**
	* Gets the name of this space
	*
	* @return string The name of this course
	*/
	public function getName() {
		return $this->name;
	}

	/**
	* Sets the name of this space
	*
	* @param string $name The name of this space
	* @return void
	*/
	public function setName($name) {
		$this->name = $name;
	}

  /**
	* Gets the capacity of this space
	*
	* @return string The capacity of this space
	*/
	public function getCapacity() {
		return $this->capacity;
	}

	/**
	* Sets the capacity of this space
	*
	* @param string $capacity The capacity of this space
	* @return void
	*/
	public function setCapacity($capacity) {
		$this->capacity = $capacity;
	}

  /**
	* Gets the image of this space
	*
	* @return string The image of this space
	*/
	public function getImage() {
		return $this->image;
	}

	/**
	* Sets the image of this space
	*
	* @param string $image The image of this space
	* @return void
	*/
	public function setImage($image) {
		$this->image = $image;
	}

	public function validateSpace($imageName, $imageType, $checkImage){
		$errors = array();

		$expName = '/^[A-Za-z0-9\s]+$/';
		$expCapacity = '/^\d+$/';

		if($this->getName() == NULL){
			$errors["name"] = "The name is wrong";
		}

		if(!$this->getName() == NULL &&!preg_match($expName, $this->getName())){
			$errors["name"] = "Name must have only letters and numbers";
		}

		if($this->getCapacity() == NULL){
			$errors["capacity"] = "The capacity is wrong";
		}

		if(!$this->getCapacity() == NULL &&!preg_match($expCapacity, $this->getCapacity())){
			$errors["name"] = "Capacity must have only numbers";
		}

		if($checkImage){
			if ($imageType != "image/gif" and $imageType != "image/jpeg" and $imageType != "image/jpg" and $imageType != "image/png"){
				$errors["imagetype"] = "The image is not valid";
			}
		}

		if($checkImage){
			if ($imageName == NULL){
				$errors["imagetype"] = "Not image selected";
			}
		}

		if (sizeof($errors) > 0){
			throw new ValidationException($errors, "Space is not valid");
		}
	}
}
