<?php
// file: model/User.php

require_once(__DIR__."/../core/ValidationException.php");

/**
* Class User
*
* Represents a User in the academy
*
* @author braisda <braisda@gmail.com>
*/
class User {

	/**
	* The id of this user
	* @var string
	*/
	private $id_user;

	/**
	* The user name of the user
	* @var string
	*/
	private $name;

	/**
	* The surname of the user
	* @var string
	*/
	private $surname;

	/**
	* The dni of the user
	* @var string
	*/
	private $dni;

	/**
	* The email of the user
	* @var string
	*/
	private $username;

	/**
	* The password of the user
	* @var string
	*/
	private $password;

	/**
	* The telephone of the user
	* @var string
	*/
	private $telephone;

	/**
	* The birthdate of the user
	* @var string
	*/
	private $birthdate;

	/**
	* The image of the user
	* @var string
	*/
	private $image;

	/**
	* The state of the user
	* @var string
	*/
	private $is_active;

	/**
	* The type of the user
	* @var string
	*/
	private $is_administrator;

	/**
	* The type of the user
	* @var string
	*/
	private $is_trainer;

	/**
	* The type of the user
	* @var string
	*/
	private $is_pupil;

	/**
	* The type of the user
	* @var string
	*/
	private $is_competitor;

	/**
	* The constructor
	*
	* @param string $username The email of the user
	* @param string $id_user The id of the user
	* @param string $name The name of the user
	* @param string $surname The surname of the user
	* @param string $dni The dni of the user
	* @param string $password The password of the user
	* @param string $telephone The telephone of the user
	* @param string $birthdate The birthdate of the user
	* @param string $image The birthdate of the user
	* @param string $is_active The state of the user
	* @param string $is_administrator The type of the user
	* @param string $is_trainer The type of the user
	* @param string $is_pupil The type of the user
	* @param string $is_competitor The type of the user
	*/
	public function __construct($username=NULL, $id_user=NULL, $name=NULL,
															$surname=NULL, $dni=NULL, $password=NULL,
															$telephone=NULL, $birthdate=NULL,	$image=NULL,
															$is_active=NULL, $is_administrator=NULL,
															$is_trainer=NULL,	$is_pupil=NULL, $is_competitor=NULL) {
		$this->username = $username;
		$this->id_user =$id_user;
		$this->name = $name;
		$this->surname = $surname;
		$this->dni = $dni;
		$this->password = $password;
		$this->telephone = $telephone;
		$this->birthdate = $birthdate;
		$this->image = $image;
		$this->is_active = $is_active;
		$this->is_administrator = $is_administrator;
		$this->is_trainer = $is_trainer;
		$this->is_pupil = $is_pupil;
		$this->is_competitor = $is_competitor;
	}

	/**
	* Gets the id of this user
	*
	* @return string The id of this user
	*/
	public function getId_user() {
		return $this->id_user;
	}

	/**
	* Gets the username of this user
	*
	* @return string The username of this user
	*/
	public function getUsername() {
		return $this->username;
	}

	/**
	* Sets the username of this user
	*
	* @param string $username The username of this user
	* @return void
	*/
	public function setUsername($username) {
		$this->username = $username;
	}

	/**
	* Gets the name of this user
	*
	* @return string The name of this user
	*/
	public function getName() {
		return $this->name;
	}

	/**
	* Sets the name of this user
	*
	* @param string $name The name of this user
	* @return void
	*/
	public function setName($name) {
		$this->name = $name;
	}

	/**
	* Gets the surname of this user
	*
	* @return string The surname of this user
	*/
	public function getSurname() {
		return $this->surname;
	}

	/**
	* Sets the surname of this user
	*
	* @param string $surname The surname of this user
	* @return void
	*/
	public function setSurname($surname) {
		$this->surname = $surname;
	}

	/**
	* Gets the dni of this user
	*
	* @return string The dni of this user
	*/
	public function getDni() {
		return $this->dni;
	}

	/**
	* Sets the dni of this user
	*
	* @param string $dni The dni of this user
	* @return void
	*/
	public function setDni($dni) {
		$this->dni = $dni;
	}

	/**
	* Gets the password of this user
	*
	* @return string The password of this user
	*/
	public function getPassword() {
		return $this->password;
	}

	/**
	* Sets the password of this user
	*
	* @param string $passwd The password of this user
	* @return void
	*/
	public function setPassword($password) {
		$this->password = $password;
	}

	/**
	* Gets the telephone of this user
	*
	* @return string The telephone of this user
	*/
	public function getTelephone() {
		return $this->telephone;
	}

	/**
	* Sets the telephone of this user
	*
	* @param string $telephone The telephone of this user
	* @return void
	*/
	public function setTelephone($telephone) {
		$this->telephone = $telephone;
	}

	/**
	* Gets the birthdate of this user
	*
	* @return string The birthdate of this user
	*/
	public function getBirthdate() {
		return $this->birthdate;
	}

	/**
	* Sets the birthdate of this user
	*
	* @param string $birthdate The birthdate of this user
	* @return void
	*/
	public function setBirthdate($birthdate) {
		$this->birthdate = $birthdate;
	}

	/**
	* Gets the image of this user
	*
	* @return string The image of this user
	*/
	public function getImage() {
		return $this->image;
	}

	/**
	* Sets the image of this user
	*
	* @param string $image The image of this user
	* @return void
	*/
	public function setImage($image) {
		$this->image = $image;
	}

	/**
	* Gets the state of this user
	*
	* @return string The state of this user
	*/
	public function getIs_active() {
		return $this->is_active;
	}

	/**
	* Sets the state of this user
	*
	* @param string $is_active The state of this user
	* @return void
	*/
	public function setIs_active($is_active) {
		$this->is_active = $is_active;
	}

	/**
	* Gets the type of this user
	*
	* @return string The type of this user
	*/
	public function getIs_administrator() {
		return $this->is_administrator;
	}

	/**
	* Sets the state of this user
	*
	* @param string $is_administrator The type of this user
	* @return void
	*/
	public function setIs_administrator($is_administrator) {
		$this->is_administrator = $is_administrator;
	}

	/**
	* Gets the type of this user
	*
	* @return string The type of this user
	*/
	public function getIs_trainer() {
		return $this->is_trainer;
	}

	/**
	* Sets the state of this user
	*
	* @param string $is_trainer The type of this user
	* @return void
	*/
	public function setIs_trainer($is_trainer) {
		$this->is_trainer = $is_trainer;
	}

	/**
	* Gets the type of this user
	*
	* @return string The type of this user
	*/
	public function getIs_pupil() {
		return $this->is_pupil;
	}

	/**
	* Sets the state of this user
	*
	* @param string $is_pupil The type of this user
	* @return void
	*/
	public function setIs_pupil($is_pupil) {
		$this->is_pupil = $is_pupil;
	}

	/**
	* Gets the type of this user
	*
	* @return string The type of this user
	*/
	public function getIs_competitor() {
		return $this->is_competitor;
	}

	/**
	* Sets the state of this user
	*
	* @param string $is_competitor The type of this user
	* @return void
	*/
	public function setIs_competitor($is_competitor) {
		$this->is_competitor = $is_competitor;
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
	public function validateUser($password, $repitedpassword, $imageName, $imageType, $imageSize, $checkPassword, $checkImage){
		$errors = array();
		$expression = '/^[9|6|7][0-9]{8}$/';
		$expName = '/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]+$/';
		$expSurname = '/^[A-Za-zñÑáéíóúÁÉÍÓÚ]+ [A-Za-zñÑáéíóúÁÉÍÓÚ]+$/';
		$expPass = '/^[A-Za-zñÑáéíóúÁÉÍÓÚ0-9\.]+$/';

		if($this->getUsername() == NULL){
			$errors["email"] = "The email can not be empty";
		}

		if(strlen($this->getUsername()) > 25){
			$errors["email"] = "The email can not be longer than 25 characters";
		}

		if(!$this->getUsername() == NULL && !$this->validate_email($this->getUsername())){
			$errors["email"] = "The email is wrong";
		}

		if($this->getName() == NULL){
			$errors["name"] = "The name can not be empty";
		}

		if(strlen($this->getName()) > 20){
			$errors["name"] = "The name can not be longer than 20 characters";
		}

		if(!$this->getName() == NULL &&!preg_match($expName, $this->getName())){
			$errors["name"] = "Name must have only letters";
		}

		if($this->getSurname() == NULL){
			$errors["surname"] = "The surname can not be empty";
		}

		if(strlen($this->getSurname()) > 60){
			$errors["surname"] = "The surname can not be longer than 60 characters";
		}

		if(!preg_match($expSurname, $this->getSurname())){
			$errors["surname"] = "Surame must have two words with only letters";
		}

		if($this->getDni() == NULL){
		 	$errors["dni"] = "DNI can not be empty";
		}

		if (!$this->getDni() == NULL && strlen($this->getDni()) < 9) {
			$errors["dni"] = "DNI must be at least 9 characters length";
		}

		if (!$this->getDni() == NULL && strlen($this->getDni()) > 9) {
			$errors["dni"] = "DNI must be less than 10 characters length";
		}

	 	if(!$this->getDni() == NULL && strlen($this->getDni()) == 9 && !$this->validate_dni($this->getDni())){
		 	$errors["dni"] = "DNI incorrect";
		}

		if($checkPassword){
			if (strlen($password) < 5) {
				$errors["password"] = "Password must be at least 5 characters length";
			}

			if (strlen($password) > 15) {
				$errors["password"] = "Password must not be more than 15 characters length";
			}

			if(!preg_match($expPass, $password) && !strlen($password) < 5){
				$errors["password"] = "Password must have letters, numbers and points";
			}

			if($repitedpassword != $password){
				$errors["password"] = "Passwords do not match";
			}
		}

		if($this->getTelephone() == NULL){
			$errors["telephone"] = "The phone can not be empty";
		}

		if(!$this->getTelephone() == NULL && strlen($this->getTelephone()) < 9){
			$errors["telephone"] = "The phone number must have 9 numbers";
		}

		if(!$this->getTelephone() == NULL && strlen($this->getTelephone()) == 9 && !preg_match($expression, $this->getTelephone())){
			$errors["telephone"] = "The phone number is wrong";
		}

		if($this->getBirthdate() == NULL){
			$errors["birthdate"] = "The date born is wrong";
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

		if($this->getIs_administrator() == NULL and $this->getIs_trainer() == NULL and
		$this->getIs_pupil() == NULL and $this->getIs_competitor() == NULL){
			$errors["type"] = "The user must have a type";
		}

		if (sizeof($errors) > 0){
			throw new ValidationException($errors, "User is not valid");
		}
	}

	/**
	* Checks if the email is valid
	* for being inserted in the database.
	*
	* @param string $str The email of the user
	*
	* @return boolean true if the email is valid, false otherwise
	*/
	public function validate_email($str){
		return (false !== strpos($str, "@") && false !== strpos($str, "."));
	}

	/**
	* Checks if the DNI is valid
	* for being inserted in the database.
	*
	* @param string $email The DNI of the user
	*
	* @return boolean true if the DNI is valid, false otherwise
	*/
	public function validate_dni($email){
		$letter = substr($email, -1);
		$numbers = substr($email, 0, -1);
		if(ctype_digit($numbers)){
			if ( substr("TRWAGMYFPDXBNJZSQVHLCKE", $numbers%23, 1) == $letter && strlen($letter) == 1 && strlen ($numbers) == 8 ){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}

	}

	/**
	* Returns the type of the current user
	*
	*
	* @return string The type of the user
	*/
	public function getType(){
		$toret="";
		if($this->is_administrator == 1){
			$toret = $toret."administrator ";
		}

		if ($this->is_trainer == 1) {
			$toret = $toret."trainer ";
		}

		if ($this->is_pupil == 1) {
			$toret = $toret."pupil ";
		}

		if ($this->is_competitor == 1) {
			$toret = $toret."competitor ";
		}
		return $toret;
	}
}
