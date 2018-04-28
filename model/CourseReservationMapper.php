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
