<?php
// file: model/Space.php

require_once(__DIR__."/../core/ValidationException.php");

/**
* Class Space
*
* Represents a Space in the academy
*
* @author braisda <braisda@gmail.com>
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
	* @var string
	*/
	private $capacity;

	/**
	* The image of the space
	* @var string
	*/
	private $image;

	/**
	* The constructor
	*
	* @param string $id_space The space id
	* @param string $name The name of the space
  * @param string $capacity The capacity of the space
  * @param string $image The image of the space
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
	* @return string The name of this space
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

	/**
	* Checks if the current instance is valid
	* for being inserted in the database.
	*
	* @param string $imageName The name of the image of this space
	* @param string $imageType The type the image of this space
	* @param string $imageSize The image size of the image of this space
	* @param string $checkImage A indicator to check the image
	*								(don't check if is a update that doesn't changes the image)
	*
	* @throws ValidationException if the instance is not valid
	*
	* @return void
	*/
	public function validateSpace($imageName, $imageType, $imageSize, $checkImage){
		$errors = array();

		$expName = '/^[A-Za-z0-9\sáéíóúÁÉÍÓÚ]+$/';
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
			if($imageSize < 5242880){
				if($checkImage){
					if ($imageName == NULL){
						$errors["imagetype"] = "Not image selected";
					}
				}

				if ($imageName != NULL and $imageType != "image/gif" and $imageType != "image/jpeg" and $imageType != "image/jpg" and $imageType != "image/png"){
					$errors["imagetype"] = "The image is not valid";
				}
			}else{
				$errors["imagetype"] = "The image is too big";
			}
		}


		if (sizeof($errors) > 0){
			throw new ValidationException($errors, "Space is not valid");
		}
	}
}
