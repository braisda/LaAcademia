<?php
// file: model/CourseMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

/**
* Class CourseReservationMapper
*
* Database interface for CourseReservation entities
*
* @author lipido <lipido@gmail.com>
*/
class CourseReservationMapper {

	/**
	* Reference to the PDO connection
	* @var PDO
	*/
	private $db;

	public function __construct() {
		$this->db = PDOConnection::getInstance();
	}

	/**
	* Saves a Course into the database
	*
	* @param CourseReservation $courseReservation The reservation to be saved
	* @throws PDOException if a database error occurs
	* @return void
	*/

	public function show() {
		$stmt = $this->db->query ( "SELECT * FROM courses_reservations ORDER BY date" );

		$reservations_db = $stmt->fetchAll ( PDO::FETCH_ASSOC );

		$reservations = array ();

		foreach ($reservations_db as $reservation) {
			array_push ($reservations, new CourseReservation($reservation ["id_reservation"],
                                       $reservation ["date"], $reservation ["time"],
																			 $reservation ["is_confirmed"], $reservation ["id_pupil"],
                                       $reservation ["id_course"]));
		}

		return $reservations;
	}

  public function getPupils() {
		$stmt = $this->db->query("SELECT id_user, name, surname FROM users WHERE is_pupil = 1");

		$pupils = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $pupils;
	}

	public function getCourses() {
		$stmt = $this->db->query("SELECT id_course, name, type FROM courses");

		$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $courses;
	}
/*
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
												$course ["start_time"], $course ["end_time"], $course ["id_space"],
												$course ["id_trainer"], $space_name, $trainer_name, $course ["price"]);
		} else {
			return NULL;
		}
	}



	public function add($course) {
		$stmt = $this->db->prepare("INSERT INTO courses(name, type, description, capacity, days, start_time, end_time, id_space, id_trainer, price)
																values (?,?,?,?,?,?,?,?,?,?)");

    $days = "";
    for($i=0; $i<count($course->getDays()); $i++){
      $days = $days.$course->getDays()[$i].",";
    }
    $size = strlen($days);
    $days = substr($days, 0, $size-1);

		$stmt->execute(array($course->getName(), $course->getType(), $course->getDescription(),
												 $course->getCapacity(), $days, $course->getStart_time(),
												 $course->getEnd_time(), $course->getId_space(), $course->getId_trainer(),
											   $course->getPrice()));
		return $this->db->lastInsertId();
	}

	public function update($course) {
		$stmt = $this->db->prepare("UPDATE courses
																set name = ?, type = ?, description = ?,
																		capacity = ?, days = ?, start_time = ?,
																		end_time = ?, id_space = ?, id_trainer= ?,
																		price = ?
																WHERE id_course = ?");

		$days = "";
    for($i=0; $i<count($course->getDays()); $i++){
      $days = $days.$course->getDays()[$i].",";
    }
    $size = strlen($days);
    $days = substr($days, 0, $size-1);var_dump($course->getPrice());

		$stmt->execute(array($course->getName(), $course->getType(),
												 $course->getDescription(), $course->getCapacity(), $days,
												 $course->getStart_time(), $course->getEnd_time(),
												 $course->getId_space(), $course->getId_trainer(),
												 $course->getPrice(), $course->getId_course()));
		return $this->db->lastInsertId();
	}

	public function delete($course) {
		//Borrado físico
		$stmt = $this->db->prepare("DELETE FROM courses WHERE id_course=?");
		$stmt->execute(array($course->getId_course()));
	}*/
}
