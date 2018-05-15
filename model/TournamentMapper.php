<?php
// file: model/TournamentMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

/**
* Class TournamentMapper
*
* Database interface for Tournament entities
*
* @author braisda <braisda@gmail.com>
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
	* Checks if a given name is already in the database
	*
	* @param string $name the name to check
	* @return boolean true if the name exists, false otherwise
	*/
	public function tournamentExists($name) {
		$stmt = $this->db->prepare("SELECT count(name) FROM tournaments where name=?");
		$stmt->execute(array($name));

		if ($stmt->fetchColumn() > 0) {
			return true;
		}
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

	/**
	* Updates a Tournament in the database
	*
	* @param Tournament $tournament The tournament to be saved
	* @throws PDOException if a database error occurs
	* @return int The modified id tournament
	*/
	public function update($tournament) {
		$stmt = $this->db->prepare("UPDATE tournaments
																set name = ?, description = ?, start_date = ?,
																		end_date = ?, price = ?
																WHERE id_tournament = ?");

		$stmt->execute(array($tournament->getName(), $tournament->getDescription(), $tournament->getStart_date(),
												 $tournament->getEnd_date(), $tournament->getPrice(), $tournament->getId_tournament()));
		return $this->db->lastInsertId();
	}

	/**
	* Deletes a Tournament into the database
	*
	* @param Tournament $tournament The tournament to be deleted
	* @throws PDOException if a database error occurs
	* @return void
	*/
	public function delete($tournament) {
		//Borrado físico
		$stmt = $this->db->prepare("DELETE FROM tournaments WHERE id_tournament=?");
		$stmt->execute(array($tournament->getId_tournament()));
	}

	/**
	* Searhes a Tournament into the database
	*
	* @param string $query The query for the space to be searched
	* @throws PDOException if a database error occurs
	* @return mixed Array of Tournament instances that match the search parameter
	*/
	public function search($query) {
        $search_query = "SELECT * FROM tournaments WHERE ". $query;
        $stmt = $this->db->prepare($search_query);
        $stmt->execute();
        $tournaments_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $tournaments = array();

				foreach ($tournaments_db as $tournament) {
					array_push ($tournaments, new Tournament($tournament ["id_tournament"],
		                                               $tournament ["name"],
		                                               $tournament ["description"],
																					         $tournament ["start_date"],
		                                               $tournament ["end_date"]));
				}

				return $tournaments;
    }
}
