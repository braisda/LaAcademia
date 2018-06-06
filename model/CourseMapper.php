<?php
// file: model/CourseMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

/**
* Class CourseMapper
*
* Database interface for Course entities
*
* @author braisda <braisda@gmail.com>
*/
class CourseMapper {

	/**
	* Reference to the PDO connection
	* @var PDO
	*/
	private $db;

	public function __construct() {
		$this->db = PDOConnection::getInstance();
	}

	/**
	* Checks if a given name and type are already in the database
	*
	* @param string $name the name to check
	* @param string $type the name to check
	* @return boolean true if the name and type exists, false otherwise
	*/
	public function courseExists($name, $type) {
		$stmt = $this->db->prepare("SELECT count(name) FROM courses where name=? and type=?");
		$stmt->execute(array($name, $type));

		if ($stmt->fetchColumn() > 0) {
			return true;
		}
	}

	/**
	* Retrieves all courses
	*
	* @throws PDOException if a database error occurs
	* @return mixed Array of Course instances
	*/
	public function show() {
		$stmt = $this->db->query ( "SELECT * FROM courses ORDER BY name" );

		$courses_db = $stmt->fetchAll ( PDO::FETCH_ASSOC );

		$courses = array ();

		foreach ($courses_db as $course) {
			array_push ($courses, new Course($course ["id_course"], $course ["name"], $course ["type"],
																			 $course ["description"], $course ["capacity"], $course ["days"],
																			 $course ["start_date"], $course ["end_date"],
																			 $course ["start_time"], $course ["end_time"], $course ["id_space"],
																			 $course ["id_trainer"], $course["price"], NULL, NULL));
		}

		return $courses;
	}

	/**
	* Loads a Course from the database given its id
	*
	* @param string $id_course The id of the course
	* @throws PDOException if a database error occurs
	* @return Space The Course instances. NULL if the Course is not found
	*
	*/
	public function view($id_course) {
		$stmt = $this->db->prepare("SELECT * FROM courses WHERE id_course=?");
		$stmt->execute(array($id_course));

		$course = $stmt->fetch ( PDO::FETCH_ASSOC );

		$stmt2 = $this->db->prepare("SELECT name FROM spaces WHERE id_space=?");
    $stmt2->execute(array($course ["id_space"]));

    $space = $stmt2->fetch ( PDO::FETCH_ASSOC );

    $space_name = $space ["name"];

		$stmt3 = $this->db->prepare("SELECT name FROM users WHERE id_user=?");
    $stmt3->execute(array($course ["id_trainer"]));

    $trainer = $stmt3->fetch ( PDO::FETCH_ASSOC );

    $trainer_name = $trainer ["name"];

		if ($course != null) {
			return new Course($course ["id_course"], $course ["name"], $course ["type"],
												$course ["description"], $course ["capacity"], $course ["days"],
												$course ["start_date"], $course ["end_date"],
												$course ["start_time"], $course ["end_time"], $course ["id_space"],
												$course ["id_trainer"], $space_name, $trainer_name, $course ["price"]);
		} else {
			return NULL;
		}
	}

	/**
	* Retrieves the id and the name of the users who are trainers
	*
	* @throws PDOException if a database error occurs
	* @return mixed Array of User instances
	*/
	public function getTrainers() {
		$stmt = $this->db->query("SELECT id_user, name FROM users WHERE is_trainer = 1");

		$trainers = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $trainers;
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
	* Saves a Course into the database
	*
	* @param Course $course The course to be saved
	* @throws PDOException if a database error occurs
	* @return void
	*/
	public function add($course) {
		$stmt = $this->db->prepare("INSERT INTO courses(name, type, description, capacity, days, start_date, end_date, start_time, end_time, id_space, id_trainer, price)
																values (?,?,?,?,?,?,?,?,?,?,?,?)");

    $days = "";
    for($i=0; $i<count($course->getDays()); $i++){
      $days = $days.$course->getDays()[$i].",";
    }
    $size = strlen($days);
    $days = substr($days, 0, $size-1);

		$stmt->execute(array($course->getName(), $course->getType(), $course->getDescription(),
												 $course->getCapacity(), $days, $course->getStart_date(), $course->getEnd_date(),
												 $course->getStart_time(), $course->getEnd_time(),
												 $course->getId_space(), $course->getId_trainer(),
											   $course->getPrice()));
		return $this->db->lastInsertId();
	}

	/**
	* Updates a Course in the database
	*
	* @param Course $course The course to be saved
	* @throws PDOException if a database error occurs
	* @return int The modified id course
	*/
	public function update($course) {
		$stmt = $this->db->prepare("UPDATE courses
																set name = ?, type = ?, description = ?,
																		capacity = ?, days = ?, start_date = ?,
																		end_date = ?, start_time = ?,
																		end_time = ?, id_space = ?, id_trainer= ?,
																		price = ?
																WHERE id_course = ?");

		$days = "";
    for($i=0; $i<count($course->getDays()); $i++){
      $days = $days.$course->getDays()[$i].",";
    }
    $size = strlen($days);
    $days = substr($days, 0, $size-1);

		$stmt->execute(array($course->getName(), $course->getType(),
												 $course->getDescription(), $course->getCapacity(), $days,
												 $course->getStart_date(), $course->getEnd_date(),
												 $course->getStart_time(), $course->getEnd_time(),
												 $course->getId_space(), $course->getId_trainer(),
												 $course->getPrice(), $course->getId_course()));
		return $this->db->lastInsertId();
	}

	/**
	* Deletes a Course into the database
	*
	* @param Course $course The course to be deleted
	* @throws PDOException if a database error occurs
	* @return void
	*/
	public function delete($course) {
		//Borrado físico
		$stmt = $this->db->prepare("DELETE FROM courses WHERE id_course=?");
		$stmt->execute(array($course->getId_course()));
	}

	/**
	* Searches a Course into the database
	*
	* @param string $query The query for the course to be searched
	* @throws PDOException if a database error occurs
	* @return mixed Array of Course instances that match the search parameter
	*/
	public function search($query) {
        $search_query = "SELECT * FROM courses WHERE ". $query;
        $stmt = $this->db->prepare($search_query);
        $stmt->execute();
        $courses_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $courses = array();

        foreach ($courses_db as $course) {
            array_push ($courses, new Course($course ["id_course"], $course ["name"], $course ["type"],
																						 $course ["description"], $course ["capacity"], $course ["days"],
																						 $course ["start_time"], $course ["end_time"], $course ["id_space"],
																						 $course ["id_trainer"], $course["price"]));
        }

        return $courses;
    }
}
