<?php
// file: model/DrawMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

/**
* Class DrawMapper
*
* Database interface for Draw entities
*
* @author braisda <braisda@gmail.com>
*/
class DrawMapper {

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
	public function drawExists($modality, $gender, $category, $type) {
		$stmt = $this->db->prepare("SELECT count(modality) FROM draws where modality=? AND gender=? AND category=? AND type=?");
		$stmt->execute(array($modality, $gender, $category, $type));

		if ($stmt->fetchColumn() > 0) {
			return true;
		}
	}

	/**
	* Retrieves all draws
	*
	* @throws PDOException if a database error occurs
	* @return mixed Array of Draw instances
	*/
	public function show($id_draw) {
		$stmt = $this->db->prepare( "SELECT * FROM draws WHERE id_tournament=? ORDER BY id_draw");
    $stmt->execute(array($id_draw));

		$draws_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$draws = array ();

		foreach ($draws_db as $draw) {
			array_push ($draws, new Draw($draw ["id_draw"], $draw ["modality"],
                                   $draw ["gender"], $draw ["category"],
																	 $draw ["type"], $draw ["id_tournament"]));
		}

		return $draws;
	}

	/**
	* Loads a Draw from the database given its id
	*
	* @param string $id_draw The id of the draw
	* @throws PDOException if a database error occurs
	* @return Draw The Draw instances. NULL if the Draw is not found
	*
	*/
	public function view($id_draw) {
		$stmt = $this->db->prepare("SELECT * FROM draws WHERE id_draw=?");
		$stmt->execute(array($id_draw));

		$draw = $stmt->fetch ( PDO::FETCH_ASSOC );

		if ($draw != null) {
			return new Draw($draw ["id_draw"], $draw ["modality"],
                      $draw ["gender"], $draw ["category"],
											$draw ["type"], $draw ["id_tournament"]);
		} else {
			return NULL;
		}
	}

	/**
	* Saves a Draw into the database
	*
	* @param Draw $drawe The draw to be saved
	* @throws PDOException if a database error occurs
	* @return int The new draw id
	*/
	public function add($draw) {
		$stmt = $this->db->prepare("INSERT INTO draws(modality, gender, category, type, id_tournament)
																values (?,?,?,?,?)");

		$stmt->execute(array($draw->getModality(), $draw->getGender(),
												 $draw->getCategory(), $draw->getType(),
											   $draw->getId_tournament()));
		return $this->db->lastInsertId();
	}

	/**
	* Updates a Draw in the database
	*
	* @param Draw $draw The draw to be saved
	* @throws PDOException if a database error occurs
	* @return int The modified id draw
	*/
	public function update($draw) {
		$stmt = $this->db->prepare("UPDATE draws
																set modality = ?, gender = ?, category = ?,
																		type = ?, id_tournament = ?
																WHERE id_draw = ?");

		$stmt->execute(array($draw->getModality(), $draw->getGender(),
												 $draw->getCategory(), $draw->getType(),
												 $draw->getId_tournament(), $draw->getId_draw()));

		return $this->db->lastInsertId();
	}

	/**
	* Deletes a Draw into the database
	*
	* @param Draw $draw The draw to be deleted
	* @throws PDOException if a database error occurs
	* @return void
	*/
	public function delete($draw) {
		//Borrado físico
		$stmt = $this->db->prepare("DELETE FROM draws WHERE id_draw=?");
		$stmt->execute(array($draw->getId_draw()));
	}

	/**
	* Searhes a Draw into the database
	*
	* @param string $query The query for the space to be searched
	* @throws PDOException if a database error occurs
	* @return mixed Array of Draw instances that match the search parameter
	*/
	public function search($query) {
        $search_query = "SELECT * FROM draws WHERE ". $query;
        $stmt = $this->db->prepare($search_query);
        $stmt->execute();
        $draws_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $draws = array();

				foreach ($draws_db as $draw) {
					array_push ($draws, new Draw($draw ["id_draw"], $draw ["modality"],
		                      						 $draw ["gender"], $draw ["category"],
																			 $draw ["type"], $draw ["id_tournament"]));
				}

				return $draws;
    }
}
