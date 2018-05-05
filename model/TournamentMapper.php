<?php
// file: model/TournamentMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

/**
* Class TournamentMapper
*
* Database interface for Tournament entities
*
* @author lipido <lipido@gmail.com>
*/
class TournamentMapper {

	/**
	* Reference to the PDO connection
	* @var PDO
	*/
	private $db;

	public function __construct() {
		$this->db = PDOConnection::getInstance();
	}

	/**
	* Saves a Tournament into the database
	*
	* @param Tournament $tournament The tournament to be saved
	* @throws PDOException if a database error occurs
	* @return void
	*/

	public function show() {
		$stmt = $this->db->query ( "SELECT * FROM tournaments ORDER BY start_date" );

		$tournaments_db = $stmt->fetchAll ( PDO::FETCH_ASSOC );

		$tournaments = array ();

		foreach ($tournaments_db as $tournament) {
			array_push ($tournaments, new Tournament($tournament ["id_tournament"],
                                               $tournament ["name"],
                                               $tournament ["description"],
																			         $tournament ["start_date"],
                                               $tournament ["end_date"]));
		}

		return $tournaments;
	}
/*
	public function view($id_tournament) {
		$stmt = $this->db->prepare("SELECT * FROM tournaments WHERE id_tournament=?");
		$stmt->execute(array($id_tournament));

		$tournament = $stmt->fetch ( PDO::FETCH_ASSOC );

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

	public function add($event) {
		$stmt = $this->db->prepare("INSERT INTO events(name, description, price, capacity, date, time, id_space)
																values (?,?,?,?,?,?,?)");

		$stmt->execute(array($event->getName(), $event->getDescription(), $event->getPrice(),
												 $event->getCapacity(), $event->getDate(), $event->getTime(),
												 $event->getId_space()));
		return $this->db->lastInsertId();
	}

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

	public function delete($event) {
		//Borrado físico
		$stmt = $this->db->prepare("DELETE FROM events WHERE id_event=?");
		$stmt->execute(array($event->getId_event()));
	}*/
}
