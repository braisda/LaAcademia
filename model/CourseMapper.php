<?php
// file: model/CourseMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

/**
* Class CourseMapper
*
* Database interface for User entities
*
* @author lipido <lipido@gmail.com>
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
	* Saves a User into the database
	*
	* @param Course $course The course to be saved
	* @throws PDOException if a database error occurs
	* @return void
	*/

	public function show() {
		$stmt = $this->db->query ( "SELECT * FROM courses ORDER BY name" );

		$courses_db = $stmt->fetchAll ( PDO::FETCH_ASSOC );

		$courses = array ();

		foreach ($courses_db as $course) {
			array_push ($courses, new Course($course ["id_course"], $course ["name"], $course ["type"], $course ["description"],
																			$course ["capacity"], $course ["days"], $course ["start_time"],
																			$course ["end_time"]));
		}

		return $courses;
	}

	public function view($id_course) {
		$stmt = $this->db->prepare("SELECT * FROM courses WHERE id_course=?");
		$stmt->execute(array($id_course));

		$course = $stmt->fetch ( PDO::FETCH_ASSOC );

		if ($course != null) {
			return new Course($course ["id_course"], $course ["name"], $course ["type"], $course ["description"],
												$course ["capacity"], $course ["days"], $course ["start_time"],
												$course ["end_time"]);
		} else {
			return NULL;
		}
	}

	public function add($course) {
		$stmt = $this->db->prepare("INSERT INTO courses(name, type, description, capacity, days, start_time, end_time)
																values (?,?,?,?,?,?,?)");

//INSERT INTO `courses` (`id_course`, `name`, `type`, `description`, `capacity`, `days`, `start_time`, `end_time`)
//VALUES (NULL, 'Avanzado', 'Children', 'Curso avanzado infantil', '5', 'Thursday,Friday', '10:00:00', '12:00:00');

    $days = "";
    for($i=0; $i<count($course->getDays()); $i++){
      $days = $days.$course->getDays()[$i].",";
    }
    $size = strlen($days);
    $days = substr($days, 0, $size-1);

		$stmt->execute(array($course->getName(), $course->getType(), $course->getDescription(),
												 $course->getCapacity(), $days, $course->getStart_time(),
												 $course->getEnd_time()));
		return $this->db->lastInsertId();
	}

//UPDATE `courses` SET `name` = 'Cacaa', `type` = 'Adults', `description` = 'Pruebass', `capacity` = '9', `days` = 'Tuesday', `start_time` = '10:00:00', `end_time` = '12:00:00'
//WHERE `courses`.`id_course` = 11;


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
	}
}
