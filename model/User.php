<?php
// file: model/User.php

require_once(__DIR__."/../core/ValidationException.php");

/**
* Class User
*
* Represents a User in the academy
*
* @author lipido <lipido@gmail.com>
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
	*/
	private $dni;

	/**
	* The email of the user
	*/
	private $username;

	/**
	* The password of the user
	*/
	private $password;

	/**
	* The telephone of the user
	*/
	private $telephone;

	/**
	* The birthdate of the user
	*/
	private $birthdate;

	/**
	* The image of the user
	*/
	private $image;

	/**
	* The state of the user
	*/
	private $is_active;

	/**
	* The type of the user
	*/
	private $is_administrator;

	/**
	* The type of the user
	*/
	private $is_trainer;

	/**
	* The type of the user
	*/
	private $is_pupil;

	/**
	* The type of the user
	*/
	private $is_competitor;

	/**
	* The constructor
	*
	* @param $username The email of the user
	* @param $id_user The id of the user
	* @param $name The name of the user
	* @param $surname The surname of the user
	* @param $dni The dni of the user
	* @param $password The password of the user
	* @param $telephone The telephone of the user
	* @param $birthdate The birthdate of the user
	* @param $image The birthdate of the user
	* @param $is_active The state of the user
	* @param $is_administrator The type of the user
	* @param $is_trainer The type of the user
	* @param $is_pupil The type of the user
	* @param $is_competitor The type of the user
	*/
	public function __construct($username=NULL, $id_user=NULL, $name=NULL, $surname=NULL,
															$dni=NULL, $password=NULL, $telephone=NULL, $birthdate=NULL,
															$image=NULL, $is_active=NULL, $is_administrator=NULL, $is_trainer=NULL,
															$is_pupil=NULL, $is_competitor=NULL) {
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

	public function validateUserInsertion($pass_rep){
		$errors = array();
		$expresion = '/^[9|6|7][0-9]{8}$/';
		if (strlen($this->username) < 8 ) {
			$errors["DNI"] = "DNI must be at least 8 characters length";
		}

		if(!$this->validar_username($this->username) || $this->getUsername()==NULL){
			$errors["DNI"] = "DNI incorrect";
		}
		if (strlen($this->pass) < 5) {
			$errors["passwd"] = "Password must be at least 5 characters length";
		}
		if($pass_rep != $this->pass){
			$errors["passwd"] = "Passwords do not match";
		}
		if(strlen($this->tlf) != 9){
			$errors["tlf"] = "The phone number must have 9 numbers";
		}
		if(!preg_match($expresion, $this->tlf)){
			$errors["tlf"] = "The phone number is wrong";
		}
		if(!$this->is_valid_email($this->email)){
			$errors["email"] = "The email is wrong";
		}
		if($this->getName()==NULL){
			$errors["name"] = "The name is wrong";
		}
		if($this->getSurname()==NULL){
			$errors["surname"] = "The surname is wrong";
		}
		if($this->getDateBorn()==NULL){
			$errors["dateborn"] = "The date born is wrong";
		}
		if (sizeof($errors)>0){
			throw new ValidationException($errors, "user is not valid");
		}
	}
}
