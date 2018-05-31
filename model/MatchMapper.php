<?php
// file: model/MatchMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

/**
* Class MatchMapper
*
* Database interface for Match entities
*
* @author braisda <braisda@gmail.com>
*/
class MatchMapper {

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
	public function matchExists($rival1a, $rival1b, $rival2a, $rival2b) {
		$stmt = $this->db->prepare("SELECT count(name) FROM matches where rival1a=? AND rival1b=? AND rival2a=? AND rival2b=?");
		$stmt->execute(array($rival1a, $rival1b, $rival2a, $rival2a));

		if ($stmt->fetchColumn() > 0) {
			return true;
		}
	}

	/**
	* Retrieves all matches
	*
	* @throws PDOException if a database error occurs
	* @return mixed Array of Match instances
	*/
	public function show() {
		$stmt = $this->db->query("SELECT * FROM matches");

		$matches_db = $stmt->fetchAll ( PDO::FETCH_ASSOC );

		$matches = array ();

		foreach ($matches_db as $match) {
			array_push ($matches, new Match($match ["id_match"],
                                               $match ["rival1a"],
                                               $match ["rival1b"],
																			         $match ["rival2a"],
                                               $match ["rival2b"],
                                               $match ["date"],
                                               $match ["round"],
                                               $match ["cell"],
                                               $match ["set1a"],
                                               $match ["set1b"],
                                               $match ["set2a"],
                                               $match ["set2b"],
                                               $match ["set3a"],
                                               $match ["set3b"],
                                               $match ["set4a"],
                                               $match ["set4b"],
                                               $match ["set5a"],
                                               $match ["set5b"],
                                               $match ["id_draw"]));
		}

		return $matches;
	}

	public function getCompetitors() {
		$stmt = $this->db->query("SELECT id_user, name, surname FROM users where is_competitor = 1");

		$competitors_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$competitors = array ();

		foreach($competitors_db as $competitor) {
			array_push ($competitors, new User(NULL, $competitor ["id_user"], $competitor ["name"],
																			$competitor ["surname"], NULL, NULL,
																			NULL, NULL, NULL,
																			NULL, NULL, NULL,
																			NULL, NULL));
		}

		return $competitors;
	}

	/**
	* Loads a Match from the database given its id
	*
	* @param string $id_match The id of the match
	* @throws PDOException if a database error occurs
	* @return Match The Match instances. NULL if the Match is not found
	*
	*/
	public function view($id_match) {
		$stmt = $this->db->prepare("SELECT * FROM matches WHERE id_match=?");
		$stmt->execute(array($id_match));

		$match = $stmt->fetch ( PDO::FETCH_ASSOC );

		$stmt2 = $this->db->prepare("SELECT name, surname FROM users WHERE id_user=?");
    $stmt2->execute(array($match["rival1a"]));

    $player1a = $stmt2->fetch ( PDO::FETCH_ASSOC );

    $player1a_name = $player1a["name"]." ".$player1a["surname"];

		$stmt3 = $this->db->prepare("SELECT name, surname FROM users WHERE id_user=?");
    $stmt3->execute(array($match["rival1b"]));

    $player1b = $stmt3->fetch ( PDO::FETCH_ASSOC );

    $player1b_name = $player1b["name"]." ".$player1b["surname"];

		$stmt4 = $this->db->prepare("SELECT name, surname FROM users WHERE id_user=?");
    $stmt4->execute(array($match["rival2a"]));

    $player2a = $stmt4->fetch ( PDO::FETCH_ASSOC );

    $player2a_name = $player2a["name"]." ".$player2a["surname"];

		$stmt5 = $this->db->prepare("SELECT name, surname FROM users WHERE id_user=?");
    $stmt5->execute(array($match["rival2b"]));

    $player2b = $stmt5->fetch ( PDO::FETCH_ASSOC );

    $player2b_name = $player2b["name"]." ".$player2b["surname"];

		if ($match != null) {
			return new Match($match ["id_match"],
                       $match ["rival1a"],
                       $match ["rival1b"],
											 $match ["rival2a"],
                       $match ["rival2b"],
                       $match ["date"],
                       $match ["round"],
											 $match ["cell"],
                       $match ["set1a"],
                       $match ["set1b"],
                       $match ["set2a"],
                       $match ["set2b"],
                       $match ["set3a"],
                       $match ["set3b"],
                       $match ["set4a"],
                       $match ["set4b"],
                       $match ["set5a"],
                       $match ["set5b"],
                       $match ["id_draw"],
										 	 $player1a_name,
										 	 $player1b_name,
									 	   $player2a_name,
								 		 	 $player2b_name);
		} else {
			return NULL;
		}
	}

	/**
	* Saves a Match into the database
	*
	* @param Match $matche The match to be saved
	* @throws PDOException if a database error occurs
	* @return int The new match id
	*/
	public function add($match) {
		$stmt = $this->db->prepare("INSERT INTO matches(rival1a, rival1b, rival2a, rival2b,
                                                    date, round, cell set1a, set1b, set2a,
                                                    set2b, set3a, set3b, set4a, set4b,
                                                    set5a, set5b, id_draw)
																values (?,?,?,?,?)");

		$stmt->execute(array($match->getRival1a(), $match->getRival1b(), $match->getRival2a(),
												 $match->getRival2b(), $match->getDate(), $match->getRound(), $match->getCell(),
                         $match->getSet1a(), $match->getSet1b(), $match->getSet2a(),
                     		 $match->getSet2b(), $match->getSet3a(), $match->getSet3b(),
                         $match->getSet4a(), $match->getSet4b(), $match->getSet5a(),
                         $match->getSet5b(), $match->getId_draw()));
		return $this->db->lastInsertId();
	}

	/**
	* Updates a Match in the database
	*
	* @param Match $match The match to be saved
	* @throws PDOException if a database error occurs
	* @return int The modified id match
	*/
	public function update($match) {
		$stmt = $this->db->prepare("UPDATE matches
																set rival1a = ?, rival1b = ?, rival2a = ?,
																		rival2b = ?, date = ?, round = ?, cell=?, set1a = ?,
                                    set1b = ? , set2a = ?, set2b = ?, set3a = ?,
                                    set3b = ?, set4a = ?, set4b=?, set5a = ?,
                                    set5b = ?, id_draw = ?
																WHERE id_match = ?");

		$stmt->execute(array($match->getRival1a(), $match->getRival1b(), $match->getRival2a(),
												 $match->getRival2b(), $match->getDate(), $match->getRound(), $match->getCell(),
                         $match->getSet1a(), $match->getSet1b(), $match->getSet2a(),
                     		 $match->getSet2b(), $match->getSet3a(), $match->getSet3b(),
                         $match->getSet4a(), $match->getSet4b(), $match->getSet5a(),
                         $match->getSet5b(), $match->getId_draw(), $match->getId_match()));
		return $this->db->lastInsertId();
	}

	/**
	* Deletes a Match into the database
	*
	* @param Match $match The match to be deleted
	* @throws PDOException if a database error occurs
	* @return void
	*/
	public function delete($match) {
		//Borrado físico
		$stmt = $this->db->prepare("DELETE FROM matches WHERE id_match=?");
		$stmt->execute(array($match->getId_match()));
	}

	/**
	* Searhes a Match into the database
	*
	* @param string $query The query for the space to be searched
	* @throws PDOException if a database error occurs
	* @return mixed Array of Match instances that match the search parameter
	*/
	public function search($query) {
        $search_query = "SELECT * FROM matches WHERE ". $query;
        $stmt = $this->db->prepare($search_query);
        $stmt->execute();
        $matches_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $matches = array();

				foreach ($matches_db as $match) {
					array_push ($matches, new Match($match ["id_match"],
                                                   $match ["rival1a"],
                                                   $match ["rival1b"],
    																			         $match ["rival2a"],
                                                   $match ["rival2b"],
                                                   $match ["date"],
                                                   $match ["round"],
																									 $match ["cell"],
                                                   $match ["set1a"],
                                                   $match ["set1b"],
                                                   $match ["set2a"],
                                                   $match ["set2b"],
                                                   $match ["set3a"],
                                                   $match ["set3b"],
                                                   $match ["set4a"],
                                                   $match ["set4b"],
                                                   $match ["set5a"],
                                                   $match ["set5b"],
                                                   $match ["id_draw"]));
				}

				return $matches;
    }
}
