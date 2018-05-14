<?php
// file: model/SpaceMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

/**
* Class SpaceMapper
*
* Database interface for Space entities
*
* @author braisda <braisda@gmail.com>
*/
class SpaceMapper {

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
	public function spaceExists($name) {
		$stmt = $this->db->prepare("SELECT count(name) FROM spaces where name=?");
		$stmt->execute(array($name));

		if ($stmt->fetchColumn() > 0) {
			return true;
		}
	}

	/**
	* Retrieves all spaces
	*
	* @throws PDOException if a database error occurs
	* @return mixed Array of Space instances
	*/
	public function show() {
		$stmt = $this->db->query("SELECT * FROM spaces ORDER BY name");

		$spaces_db = $stmt->fetchAll ( PDO::FETCH_ASSOC );

		$spaces = array();

		foreach ($spaces_db as $space) {
			array_push ($spaces, new Space($space ["id_space"], $space ["name"], $space["capacity"], $space["image"]));
		}

		return $spaces;
	}

	/**
	* Loads a Space from the database given its id
	*
	* @param string $id_space The id of the space
	* @throws PDOException if a database error occurs
	* @return Space The Space instances. NULL if the Space is not found
	*
	*/
	public function view($id_space) {
		$stmt = $this->db->prepare("SELECT * FROM spaces WHERE id_space=?");
		$stmt->execute(array($id_space));

		$space = $stmt->fetch ( PDO::FETCH_ASSOC );

		if ($space != null) {
			return new Space($space ["id_space"], $space ["name"],
                       $space ["capacity"], $space ["image"]);
		} else {
			return NULL;
		}
	}
	/**
	* Saves a Space into the database
	*
	* @param Space $space The space to be saved
	* @throws PDOException if a database error occurs
	* @return int The new user id
	*/
	public function add($space) {
		$stmt = $this->db->prepare("INSERT INTO spaces(name, capacity, image)
																values (?,?,?)");

		$stmt->execute(array($space->getName(), $space->getCapacity(), $space->getImage()));
		return $this->db->lastInsertId();
	}

	/**
	* Updates a Space in the database
	*
	* @param Space $space The space to be saved
	* @throws PDOException if a database error occurs
	* @return int The modified id space
	*/
	public function update($space) {
		$stmt = $this->db->prepare("UPDATE spaces
																set name = ?, capacity = ?, image = ?
																WHERE id_space = ?");

		$stmt->execute(array($space->getName(), $space->getCapacity(), $space->getImage(), $space->getId_space()));
		return $this->db->lastInsertId();
	}

	/**
	* Deletes a Space into the database
	*
	* @param Space $space The space to be deleted
	* @throws PDOException if a database error occurs
	* @return void
	*/
	public function delete($space) {
		//Borrado físico
		$stmt = $this->db->prepare("DELETE FROM spaces WHERE id_space=?");
		$stmt->execute(array($space->getId_space()));
	}

	/**
	* Searhes a Space into the database
	*
	* @param string $query The query for the space to be searched
	* @throws PDOException if a database error occurs
	* @return mixed Array of Space instances that match the search parameter
	*/
	public function search($query) {
        $search_query = "SELECT * FROM spaces WHERE ". $query;
        $stmt = $this->db->prepare($search_query);
        $stmt->execute();
        $spaces_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $spaces = array();

        foreach ($spaces_db as $space) {
            array_push ($spaces, new Space($space ["id_space"], $space ["name"], $space["capacity"], $space["image"]));
        }

        return $spaces;
    }
}
