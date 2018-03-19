<?php
// file: model/SpaceMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

/**
* Class SpaceMapper
*
* Database interface for Space entities
*
* @author lipido <lipido@gmail.com>
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
	* Saves a Space into the database
	*
	* @param Space $space The space to be saved
	* @throws PDOException if a database error occurs
	* @return void
	*/

	public function show() {
		$stmt = $this->db->query ( "SELECT * FROM spaces ORDER BY name" );

		$spaces_db = $stmt->fetchAll ( PDO::FETCH_ASSOC );

		$spaces = array();

		foreach ($spaces_db as $space) {
			array_push ($spaces, new Space($space ["id_space"], $space ["name"], $space["capacity"], $space["image"]));
		}

		return $spaces;
	}

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

	public function add($space) {
		$stmt = $this->db->prepare("INSERT INTO spaces(name, capacity, image)
																values (?,?,?)");

		$stmt->execute(array($space->getName(), $space->getCapacity(), $space->getImage()));
		return $this->db->lastInsertId();
	}

	public function update($space) {
		$stmt = $this->db->prepare("UPDATE spaces
																set name = ?, capacity = ?, image = ?
																WHERE id_space = ?");

		$stmt->execute(array($space->getName(), $space->getCapacity(), $space->getImage(), $space->getId_space()));
		return $this->db->lastInsertId();
	}
/*
	public function delete($course) {
		//Borrado físico
		$stmt = $this->db->prepare("DELETE FROM courses WHERE id_course=?");
		$stmt->execute(array($course->getId_course()));
	}*/
}
