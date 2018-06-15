<?php
// file: model/NotificationMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

/**
* Class NotificationMapper
*
* Database interface for Notification entities
*
* @author braisda <braisda@gmail.com>
*/
class NotificationMapper {

	/**
	* Reference to the PDO connection
	* @var PDO
	*/
	private $db;

	public function __construct() {
		$this->db = PDOConnection::getInstance();
	}

	/**
	* Checks if a given name is already in the database
	*
	* @param string $name the name to check
	* @return boolean true if the name exists, false otherwise
	*/
	public function getSender($username) {
		$stmt = $this->db->prepare("SELECT id_user FROM users where email=?");
		$stmt->execute(array($username));

    $id_user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($id_user != null) {
			return $id_user;
		} else {
			return NULL;
		}
	}

	/**
	* Gets an user
	*
	* @param string $id_user the user id
	* @return User an user object
	*/
	public function getSenderName($id_user) {
		$stmt = $this->db->prepare("SELECT id_user, name, surname FROM users where id_user=?" );
		$stmt->execute(array($id_user));

		$user = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($user != null) {
			return new User(NULL, $user["id_user"], $user["name"],
											$user["surname"], NULL, NULL,
											NULL, NULL, NULL,
											NULL, NULL, NULL,
											NULL, NULL);
		} else {
			return NULL;
		}
	}

	/**
	* Gets a id of a user
	*
	* @param string $username the username of the user
	* @return string the user id
	*/
	public function getId_user($username) {
		$stmt = $this->db->prepare("SELECT id_user FROM users where email=?" );
		$stmt->execute(array($username));

		$user = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($user != null) {
			return new User(NULL, $user["id_user"], NULL,
											NULL, NULL, NULL,
											NULL, NULL, NULL,
											NULL, NULL, NULL,
											NULL, NULL);
		} else {
			return NULL;
		}
	}

  /**
	* Retrieves all users
	*
	* @throws PDOException if a database error occurs
	* @return mixed Array of User instances
	*/
  public function getUsers() {
		$stmt = $this->db->query("SELECT id_user, name, surname FROM users" );

		$users_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$users = array ();

		foreach ( $users_db as $user ) {
			array_push($users, new User(NULL, $user ["id_user"], $user ["name"],
																	NULL, NULL, NULL,
																	NULL, NULL, NULL,
																	NULL, NULL, NULL,
																	NULL, NULL));
		}

		return $users;
	}

	/**
	* Retrieves received notifications
	*
	* @throws PDOException if a database error occurs
	* @return mixed Array of Notification instances
	*/
	public function show($receiver) {
		$stmt = $this->db->prepare("SELECT * FROM notifications WHERE receiver=? ORDER BY date DESC");

    $stmt->execute(array($receiver));

		$notifications_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$notifications = array();

		foreach ($notifications_db as $notification) {
			array_push ($notifications, new Notification($notification ["id_notification"],
                  $notification ["title"], $notification["body"],
                  $notification["sender"], $notification ["receiver"],
                  $notification ["date"], $notification["time"], $notification["is_read"]));
		}

		return $notifications;
	}

	/**
	* Loads a Notification from the database given its id
	*
	* @param string $id_notification The id of the notification
	* @throws PDOException if a database error occurs
	* @return Notification The Notification instances. NULL if the Notification is not found
	*
	*/
	public function view($id_notification) {
		$stmt = $this->db->prepare("SELECT * FROM notifications WHERE id_notification=?");
		$stmt->execute(array($id_notification));

		$notification = $stmt->fetch ( PDO::FETCH_ASSOC );

		if ($notification != null) {
			return new Notification($notification ["id_notification"], $notification ["title"],
                       $notification ["body"], $notification ["sender"], $notification ["receiver"],
										   $notification ["date"], $notification ["time"], $notification["is_read"]);
		} else {
			return NULL;
		}
	}

	/**
	* Saves a Notification into the database
	*
	* @param Notification $notification The notification to be saved
	* @throws PDOException if a database error occurs
	* @return int The new user id
	*/
	public function add($notification) {
		$stmt = $this->db->prepare("INSERT INTO notifications(title, body, date, time, is_read, sender, receiver)
																values (?,?,?,?,?,?,?)");

		$stmt->execute(array($notification->getTitle(), $notification->getbody(), $notification->getDate(),
												 $notification->getTime(), $notification->getIs_read(), $notification->getSender(), $notification->getReceiver()));
		return $this->db->lastInsertId();
	}

	/**
	* Updates a Notification in the database
	*
	* @param Notification $notification The notification to be saved
	* @throws PDOException if a database error occurs
	* @return int The modified id notification
	*/
	public function setRead($id_notification) {
		$stmt = $this->db->prepare("UPDATE notifications
																set is_read = 1
																WHERE id_notification = ?");

		$stmt->execute(array($id_notification));
		//return $this->db->lastInsertId();
	}

	/**
	* Deletes a Notification into the database
	*
	* @param Notification $notification The notification to be deleted
	* @throws PDOException if a database error occurs
	* @return void
	*/
	public function delete($notification) {
		//Borrado físico
		$stmt = $this->db->prepare("DELETE FROM notifications WHERE id_notification=?");
		$stmt->execute(array($notification->getId_notification()));
	}

	/**
	* Searhes a Notification into the database
	*
	* @param string $query The query for the notification to be searched
	* @throws PDOException if a database error occurs
	* @return mixed Array of Notification instances that match the search parameter
	*/
	public function search($query) {
        $search_query = "SELECT * FROM notifications WHERE ". $query;
        $stmt = $this->db->prepare($search_query);

        $stmt->execute();
        $notifications_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $notifications = array();

        foreach ($notifications_db as $notification) {
            array_push ($notifications, new Notification($notification ["id_notification"], $notification ["title"],
			                       $notification ["body"], $notification ["sender"], $notification ["receiver"],
													   $notification ["date"], $notification ["time"], $notification["is_read"]));
        }

        return $notifications;
    }
}
