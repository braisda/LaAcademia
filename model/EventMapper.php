<?php
// file: model/EventMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

/**
* Class EventMapper
*
* Database interface for Event entities
*
* @author lipido <lipido@gmail.com>
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
	* Saves a Event into the database
	*
	* @param Event $event The event to be saved
	* @throws PDOException if a database error occurs
	* @return void
	*/

	public function show() {
		$stmt = $this->db->query ( "SELECT * FROM events ORDER BY date" );

		$events_db = $stmt->fetchAll ( PDO::FETCH_ASSOC );

		$events = array ();

		foreach ($events_db as $event) {
			array_push ($events, new Event($event ["id_event"], $event ["name"], $event ["description"],
																			$event ["price"], $event ["capacity"], $event ["date"], $event ["time"],
																			$event ["id_space"]));
		}

		return $events;
	}

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

	public function getSpaces() {
		$stmt = $this->db->query("SELECT id_space, name FROM spaces");

		$spaces = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $spaces;
	}

	public function add($space) {
		$stmt = $this->db->prepare("INSERT INTO events(name, description, price, capacity, date, time, id_space)
																values (?,?,?,?,?,?,?)");

		$stmt->execute(array($space->getName(), $space->getDescription(), $space->getPrice(),
												 $space->getCapacity(), $space->getDate(), $space->getTime(),
												 $space->getId_space()));
		return $this->db->lastInsertId();
	}
/*
	public function update($course) {
		$stmt = $this->db->prepare("UPDATE courses
																set name = ?, type = ?, description = ?,
																		capacity = ?, days = ?, start_time = ?,
																		end_time = ?
																WHERE id_course = ?");

		$days = "";
    for($i=0; $i<count($course->getDays()); $i++){
      $days = $days.$course->getDays()[$i].",";
    }
    $size = strlen($days);
    $days = substr($days, 0, $size-1); echo $days;

		$stmt->execute(array($course->getName(), $course->getType(),
												 $course->getDescription(), $course->getCapacity(), $days,
												 $course->getStart_time(), $course->getEnd_time(),
												 $course->getId_course()));
		return $this->db->lastInsertId();
	}

	public function delete($course) {
		//Borrado físico
		$stmt = $this->db->prepare("DELETE FROM courses WHERE id_course=?");
		$stmt->execute(array($course->getId_course()));
	}*/
}
