<?php
// file: model/CourseReservationMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

/**
* Class CourseReservationMapper
*
* Database interface for CourseReservation entities
*
* @author lipido <braisda@gmail.com>
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
		$stmt = $this->db->query ( "SELECT * FROM courses_reservations ORDER BY date DESC" );

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

	public function showMine($id_pupil) {
		$stmt = $this->db->prepare("SELECT * FROM courses_reservations WHERE id_pupil= ? ORDER BY date DESC");
		$stmt->execute(array($id_pupil));
		$reservations_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$reservations = array();

		foreach ($reservations_db as $reservation) {
			array_push($reservations, new CourseReservation($reservation ["id_reservation"],
	                                     $reservation ["date"], $reservation ["time"],
																			 $reservation ["is_confirmed"], $reservation ["id_pupil"],
	                                     $reservation ["id_course"]));
		}

		return $reservations;
	}

  public function getPupils() {
		$stmt = $this->db->query("SELECT id_user, name, surname, email FROM users WHERE is_pupil = 1");

		$pupils = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $pupils;
	}

	public function getCourses() {
		$stmt = $this->db->query("SELECT id_course, name, type FROM courses");

		$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $courses;
	}

	public function view($id_reservation) {
		$stmt = $this->db->prepare("SELECT * FROM courses_reservations WHERE id_reservation=?");
		$stmt->execute(array($id_reservation));

		$reservation = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($reservation != null) {
			return new CourseReservation($reservation["id_reservation"], $reservation["date"], $reservation["time"],
												$reservation["is_confirmed"], $reservation["id_pupil"], $reservation["id_course"]);
		} else {
			return NULL;
		}
	}

	public function getState($id_course){
		$stmt = $this->db->prepare("SELECT is_confirmed FROM courses_reservations WHERE id_reservation=?");
		$stmt->execute(array($id_course));
		$state = $stmt->fetch(PDO::FETCH_ASSOC);

		if($state != null) {
			return $state["is_confirmed"];
		} else {
			return NULL;
		}
	}

	public function getId_user($email){
		$stmt = $this->db->prepare("SELECT id_user FROM users WHERE email=?");
		$stmt->execute(array($email));
		$id_user = $stmt->fetch(PDO::FETCH_ASSOC);

		if($id_user != null) {
			return $id_user["id_user"];
		} else {
			return NULL;
		}
	}

	public function add($courseReservation) {
		$stmt = $this->db->prepare("INSERT INTO courses_reservations(date, time, is_confirmed, id_pupil, id_course)
																values (?,?,?,?,?)");

		$stmt->execute(array($courseReservation->getDate(), $courseReservation->getTime(),
												 $courseReservation->getIs_confirmed(), $courseReservation->getId_pupil(),
												 $courseReservation->getId_course()));
		return $this->db->lastInsertId();
	}

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

	public function getCourse($id_course) {
		$stmt = $this->db->prepare("SELECT * FROM courses WHERE id_course=?");
		$stmt->execute(array($id_course));

		$course = $stmt->fetch ( PDO::FETCH_ASSOC );

		//var_dump($course);

		$stmt2 = $this->db->prepare("SELECT name FROM spaces WHERE id_space=?");
    $stmt2->execute(array($course ["id_space"]));

    $space = $stmt2->fetch ( PDO::FETCH_ASSOC );

    $space_name = $space ["name"];

		$stmt3 = $this->db->prepare("SELECT name FROM users WHERE id_user=?");
    $stmt3->execute(array($course ["id_trainer"]));

    $trainer = $stmt3->fetch ( PDO::FETCH_ASSOC );

    $trainer_name = $trainer ["name"];

$a=new CourseReservation(NULL, NULL, NULL, NULL, NULL,$course ["id_course"], $course ["name"], $course ["type"],
									$course ["description"], $course ["capacity"], $course ["days"],
									$course ["start_time"], $course ["end_time"], $course ["id_space"],
									$course ["id_trainer"], $space_name, $trainer_name, $course ["price"]);

									//var_dump($a);

		if ($course != null) {
			return new CourseReservation(NULL, NULL, NULL, NULL, NULL,$course ["id_course"], $course ["name"], $course ["type"],
												$course ["description"], $course ["capacity"], $course ["days"],
												$course ["start_time"], $course ["end_time"], $course ["id_space"],
												$course ["id_trainer"], $space_name, $trainer_name, $course ["price"]);
		} else {
			return NULL;
		}
	}

	public function confirm($reservation) {
		$stmt = $this->db->prepare("UPDATE courses_reservations
																set is_confirmed = ?
																WHERE id_reservation = ?");

		$stmt->execute(array(1, $reservation->getId_reservation()));
		return $this->db->lastInsertId();
	}

	public function cancel($reservation) {
		$stmt = $this->db->prepare("UPDATE courses_reservations
																set is_confirmed = ?
																WHERE id_reservation = ?");

		$stmt->execute(array(0, $reservation->getId_reservation()));
		return $this->db->lastInsertId();
	}

	public function delete($course) {
		//Borrado físico
		$stmt = $this->db->prepare("DELETE FROM courses_reservations WHERE id_reservation=?");
		$stmt->execute(array($course->getId_reservation()));
	}
}
