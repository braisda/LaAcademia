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

	public function view($id_user) {
		$stmt = $this->db->prepare("SELECT * FROM courses WHERE id_course=?");
		$stmt->execute(array($id_user));

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
/*
	public function update($user) {
		$stmt = $this->db->prepare("UPDATE users set name = ?, surname = ?, dni = ?, email = ?, password = ?,
																								 telephone = ?, birthdate = ?, is_administrator = ?,
																								 is_trainer = ?, is_pupil = ?, is_competitor = ? WHERE id_user = ?");

		$stmt->execute(array($user->getName(), $user->getSurname(), $user->getDni(),
												 $user->getUsername(), md5($user->getPassword()), $user->getTelephone(),
												 $user->getBirthdate(), $user->getIs_administrator(),
												 $user->getIs_trainer(), $user->getIs_pupil(),
												 $user->getIs_competitor(), $user->getId_user()));
		return $this->db->lastInsertId();
	}

	public function sendTotrash($user) {
		//Borrado físico
		$stmt = $this->db->prepare ( "DELETE from USUARIO WHERE DNI=?" );
		$stmt->execute ( array (
				$user->getUsername ()
		) );
		$stmt2 = $this->db->prepare ( "DELETE from TLF_USUARIO WHERE DNI=?" );
		$stmt2->execute ( array (
				$user->getUsername ()
		) );

	}*/




}
