<?php
// file: model/EventMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

/**
* Class EventMapper
*
* Database interface for Event entities
*
* @author braisda <braisda@gmail.com>
*/
class EventMapper {

	/**
	* Reference to the PDO connection
	* @var PDO
	*/
	private $db;

	public function __construct() {
		$this->db = PDOConnection::getInstance();
	}

	/**
	* Retrieves all events
	*
	* @throws PDOException if a database error occurs
	* @return mixed Array of Event instances
	*/
	public function show() {
		$stmt = $this->db->query("SELECT * FROM events ORDER BY date");

		$events_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$events = array();

		foreach ($events_db as $event) {
			array_push ($events, new Event($event ["id_event"], $event ["name"], $event ["description"],
																			$event ["price"], $event ["capacity"], $event ["date"], $event ["time"],
																			$event ["id_space"]));
		}

		return $events;
	}

	/**
	* Loads a Event from the database given its id
	*
	* @param string $id_event The id of the event
	* @throws PDOException if a database error occurs
	* @return Event The Event instances. NULL if the Event is not found
	*
	*/
	public function view($id_event) {
		$stmt = $this->db->prepare("SELECT * FROM events WHERE id_event=?");
		$stmt->execute(array($id_event));

		$event = $stmt->fetch ( PDO::FETCH_ASSOC );

    $stmt2 = $this->db->prepare("SELECT name FROM spaces WHERE id_space=?");
    $stmt2->execute(array($event ["id_space"]));

    $space = $stmt2->fetch ( PDO::FETCH_ASSOC );

    $space_name = $space ["name"];

		if ($event != null) {
			return new Event($event ["id_event"], $event ["name"], $event ["description"],
											 $event ["price"], $event ["capacity"], $event ["date"], $event ["time"],
											 $event ["id_space"], $space_name);
		} else {
			return NULL;
		}
	}

	/**
	* Retrieves the id and the name of all spaces
	*
	* @throws PDOException if a database error occurs
	* @return mixed Array of Space instances
	*/
	public function getSpaces() {
		$stmt = $this->db->query("SELECT id_space, name FROM spaces");

		$spaces = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $spaces;
	}

	/**
	* Saves a Event into the database
	*
	* @param Event $event The event to be saved
	* @throws PDOException if a database error occurs
	* @return void
	*/
	public function add($event) {
		$stmt = $this->db->prepare("INSERT INTO events(name, description, price, capacity, date, time, id_space)
																values (?,?,?,?,?,?,?)");

		$stmt->execute(array($event->getName(), $event->getDescription(), $event->getPrice(),
												 $event->getCapacity(), $event->getDate(), $event->getTime(),
												 $event->getId_space()));
		return $this->db->lastInsertId();
	}

	/**
	* Updates a Event in the database
	*
	* @param Event $event The event to be saved
	* @throws PDOException if a database error occurs
	* @return int The modified id event
	*/
	public function update($event) {
		$stmt = $this->db->prepare("UPDATE events
																set name = ?, description = ?, price = ?,
																		capacity = ?, date = ?, time = ?,
																	  id_space = ?
																WHERE id_event = ?");

		$stmt->execute(array($event->getName(), $event->getDescription(), $event->getPrice(),
												 $event->getCapacity(), $event->getDate(), $event->getTime(),
												 $event->getId_space(), $event->getId_event()));
		return $this->db->lastInsertId();
	}

	/**
	* Deletes an Event into the database
	*
	* @param Event $event The event to be deleted
	* @throws PDOException if a database error occurs
	* @return void
	*/
	public function delete($event) {
		//Borrado físico
		$stmt = $this->db->prepare("DELETE FROM events WHERE id_event=?");
		$stmt->execute(array($event->getId_event()));
	}

	/**
	* Searches an Event into the database
	*
	* @param string $query The query for the event to be searched
	* @throws PDOException if a database error occurs
	* @return mixed Array of Event instances that match the search parameter
	*/
	public function search($query) {
        $search_query = "SELECT * FROM events WHERE ". $query;
        $stmt = $this->db->prepare($search_query);
        $stmt->execute();
        $events_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $events = array();

				foreach ($events_db as $event) {
					array_push ($events, new Event($event ["id_event"], $event ["name"], $event ["description"],
																					$event ["price"], $event ["capacity"], $event ["date"], $event ["time"],
																					$event ["id_space"]));
				}

        return $events;
    }
}
