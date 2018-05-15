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
	* Retrieves all tournaments
	*
	* @throws PDOException if a database error occurs
	* @return mixed Array of Tournament instances
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

	/**
	* Loads a Tournament from the database given its id
	*
	* @param string $id_tournament The id of the tournament
	* @throws PDOException if a database error occurs
	* @return Tournament The Tournament instances. NULL if the Tournament is not found
	*
	*/
	public function view($id_tournament) {
		$stmt = $this->db->prepare("SELECT * FROM tournaments WHERE id_tournament=?");
		$stmt->execute(array($id_tournament));

		$tournament = $stmt->fetch ( PDO::FETCH_ASSOC );

		if ($tournament != null) {
			return new Tournament($tournament ["id_tournament"], $tournament ["name"], $tournament ["description"],
											 $tournament ["start_date"], $tournament ["end_date"], $tournament ["price"]);
		} else {
			return NULL;
		}
	}

	/**
	* Saves a Tournament into the database
	*
	* @param Tournament $tournamente The tournament to be saved
	* @throws PDOException if a database error occurs
	* @return int The new tournament id
	*/
	public function add($tournament) {
		$stmt = $this->db->prepare("INSERT INTO tournaments(name, description, start_date, end_date, price)
																values (?,?,?,?,?)");

		$stmt->execute(array($tournament->getName(), $tournament->getDescription(), $tournament->getStart_date(),
												 $tournament->getEnd_date(), $tournament->getPrice(),));
		return $this->db->lastInsertId();
	}
/*
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
