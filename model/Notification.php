<?php
// file: model/Notification.php

require_once(__DIR__."/../core/ValidationException.php");

/**
* Class Notification
*
* Represents a Notification in the academy
*
* @author braisda <braisda@gmail.com>
*/
class Notification {

	/**
	* The id of this notification
	* @var string
	*/
	private $id_notification;

	/**
	* The title of the notification
	* @var string
	*/
	private $title;

  /**
	* The body of the notification
	* @var string
	*/
	private $body;

	/**
	* The sender of the notification
	* @var string
	*/
	private $sender;

  /**
	* The receiver of the notification
	* @var string
	*/
	private $receiver;

  /**
	* The date of the notification
	*/
	private $date;

	/**
	* The time of the notification
	*/
	private $time;

  /**
	* The state of the notification
	*/
	private $is_read;

	/**
	* The constructor
	*
	* @param string $id_notification The notification id
	* @param string $title The title of the notification
  * @param string $body The body of the notification
  * @param string $sender The sender of the notification
  * @param string $receiver The receiver of the notification
  * @param string $date The date of the notification
	* @param string $time The time of the notification
  * @param string $is_read The state of the notification
	*/
	public function __construct($id_notification=NULL, $title=NULL, $body=NULL, $sender=NULL,
                              $receiver=NULL, $date=NULL, $time=NULL, $is_read=NULL) {
		$this->id_notification = $id_notification;
		$this->title = $title;
    $this->body = $body;
    $this->sender = $sender;
    $this->receiver = $receiver;
    $this->date = $date;
		$this->time = $time;
    $this->is_read = $is_read;
	}

	/**
	* Gets the id of this notification
	*
	* @return string The id of this notification
	*/
	public function getId_notification() {
		return $this->id_notification;
	}

	/**
	* Gets the title of this notification
	*
	* @return string The title of this notification
	*/
	public function getTitle() {
		return $this->title;
	}

	/**
	* Sets the title of this notification
	*
	* @param string $title The title of this notification
	* @return void
	*/
	public function setTitle($title) {
		$this->title = $title;
	}

  /**
	* Gets the body of this notification
	*
	* @return string The body of this notification
	*/
	public function getBody() {
		return $this->body;
	}

	/**
	* Sets the body of this notification
	*
	* @param string $body The body of this notification
	* @return void
	*/
	public function setBody($body) {
		$this->body = $body;
	}

  /**
	* Gets the sender of this notification
	*
	* @return string The sender of this notification
	*/
	public function getSender() {
		return $this->sender;
	}

	/**
	* Sets the sender of this notification
	*
	* @param string $sender The sender of this notification
	* @return void
	*/
	public function setSender($sender) {
		$this->sender = $sender;
	}

  /**
	* Gets the receiver of this notification
	*
	* @return string The receiver of this notification
	*/
	public function getReceiver() {
		return $this->receiver;
	}

	/**
	* Sets the receiver of this notification
	*
	* @param string $receiver The receiver of this notification
	* @return void
	*/
	public function setReceiver($receiver) {
		$this->receiver = $receiver;
	}

  /**
	* Gets the date of this notification
	*
	* @return string The date of this notification
	*/
	public function getDate() {
		return $this->date;
	}

	/**
	* Sets the date of this notification
	*
	* @param string $date The date of this notification
	* @return void
	*/
	public function setDate($date) {
		$this->date = $date;
	}

	/**
	* Gets the time of this notification
	*
	* @return string The time of this notification
	*/
	public function getTime() {
		return $this->time;
	}

	/**
	* Sets the time of this notification
	*
	* @param string $time The time of this notification
	* @return void
	*/
	public function setTime($time) {
		$this->time = $time;
	}

  /**
	* Gets the state of this notification
	*
	* @return string The state of this notification
	*/
	public function getIs_read() {
		return $this->is_read;
	}

	/**
	* Sets the state of this notification
	*
	* @param string $is_read The state of this notification
	* @return void
	*/
	public function setIs_read($is_read) {
		$this->is_read = $is_read;
	}

	/**
	* Checks if the current instance is valid
	* for being inserted in the database.
	*
	* @param string $senderTitle The title of the sender of this notification
	* @param string $senderType The type the sender of this notification
	* @param string $senderSize The sender size of the sender of this notification
	* @param string $checkSender A indicator to check the sender
	*								(don't check if is a update that doesn't changes the sender)
	*
	* @throws ValidationException if the instance is not valid
	*
	* @return void
	*/
	public function validateNotification($senderTitle, $senderType, $senderSize, $checkSender){
		$errors = array();

		$expTitle = '/^[A-Za-z0-9\sáéíóúÁÉÍÓÚ]+$/';
		$expBody = '/^\d+$/';

		if($this->getTitle() == NULL){
			$errors["title"] = "The title is wrong";
		}

		if(!$this->getTitle() == NULL &&!preg_notification($expTitle, $this->getTitle())){
			$errors["title"] = "Title must have only letters and numbers";
		}

		if($this->getBody() == NULL){
			$errors["body"] = "The body is wrong";
		}

		if(!$this->getBody() == NULL &&!preg_notification($expBody, $this->getBody())){
			$errors["title"] = "Body must have only numbers";
		}

		if($checkSender){
			if($senderSize < 5242880){
				if($checkSender){
					if ($senderTitle == NULL){
						$errors["sendertype"] = "Not sender selected";
					}
				}

				if ($senderTitle != NULL and $senderType != "sender/gif" and $senderType != "sender/jpeg" and $senderType != "sender/jpg" and $senderType != "sender/png"){
					$errors["sendertype"] = "The sender is not valid";
				}
			}else{
				$errors["sendertype"] = "The sender is too big";
			}
		}


		if (sizeof($errors) > 0){
			throw new ValidationException($errors, "Notification is not valid");
		}
	}
}
