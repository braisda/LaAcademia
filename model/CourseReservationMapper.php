<?php
// file: model/CourseReservationMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

/**
* Class CourseReservationMapper
*
* Database interface for CourseReservation entities
*
* @author braisda <braisda@gmail.com>
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
	* Checks if a given reservation is already in the database
	*
	* @param string $pupil the pupil of the reservation to check
	* @param string $course the course of the reservation to check
	* @return boolean true if the name exists, false otherwise
	*/
	public function reservationExists($pupil, $course) {
		$stmt = $this->db->prepare("SELECT count(id_pupil) FROM courses_reservations where id_pupil=? AND id_course=?");
		$stmt->execute(array($pupil, $course));

		if ($stmt->fetchColumn() > 0) {
			return true;
		}
	}

	/**
	* Retrieves all reservations
	*
	* @throws PDOException if a database error occurs
	* @return mixed Array of CourseReservation instances
	*/
	public function show() {
		$stmt = $this->db->query ("SELECT * FROM courses_reservations ORDER BY date DESC");

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

	/**
	* Retrieves reservations of the current user
	*
	* @param string $id_pupil The id of the user
	* @throws PDOException if a database error occurs
	* @return mixed Array of CourseReservation instances
	*/
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

	/**
	* Retrieves id, name, surname and email from all users
	*
	* @throws PDOException if a database error occurs
	* @return mixed Array of users
	*/
  public function getPupils() {
		$stmt = $this->db->query("SELECT id_user, name, surname, email FROM users WHERE is_pupil = 1 ORDER BY name");

		$pupils = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $pupils;
	}

	/**
	* Retrieves id, name, and type from all courses
	*
	* @throws PDOException if a database error occurs
	* @return mixed Array of courses
	*/
	public function getCourses() {
		$stmt = $this->db->query("SELECT id_course, name, type FROM courses ORDER BY name");

		$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $courses;
	}

	/**
	* Loads a CourseReservation from the database given its id
	*
	* @param string $id_reservation The id of the reservation
	* @throws PDOException if a database error occurs
	* @return CourseReservation The CourseReservation instances. NULL if the User is not found
	*
	*/
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

	/**
	* Loads the state of a CourseReservation from the database given its id
	*
	* @param string $id_reservation The id of the reservation
	* @throws PDOException if a database error occurs
	* @return string The state of the reservation. NULL if the CourseReservation is not found
	*
	*/
	public function getState($id_reservation){
		$stmt = $this->db->prepare("SELECT is_confirmed FROM courses_reservations WHERE id_reservation=?");
		$stmt->execute(array($id_reservation));
		$state = $stmt->fetch(PDO::FETCH_ASSOC);

		if($state != null) {
			return $state["is_confirmed"];
		} else {
			return NULL;
		}
	}

	/**
	* Loads the id of the current user
	*
	* @param string $email The email of the current user
	* @throws PDOException if a database error occurs
	* @return string The id of the current user. NULL if the user is not found
	*
	*/
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

	/**
	* Saves a CourseReservation into the database
	*
	* @param CourseReservation $courseReservation The reservation to be saved
	* @throws PDOException if a database error occurs
	* @return int The new reservation id
	*/
	public function add($courseReservation) {
		$stmt = $this->db->prepare("INSERT INTO courses_reservations(date, time, is_confirmed, id_pupil, id_course)
																values (?,?,?,?,?)");

		$stmt->execute(array($courseReservation->getDate(), $courseReservation->getTime(),
												 $courseReservation->getIs_confirmed(), $courseReservation->getId_pupil(),
												 $courseReservation->getId_course()));
		return $this->db->lastInsertId();
	}

	/**
	* Loads a CourseReservation with the informatin of the course from the database given its id
	*
	* @param string $id_course The id of the course
	* @throws PDOException if a database error occurs
	* @return CourseReservation The CourseReservation instances. NULL if the CourseReservation is not found
	*
	*/
	public function getCourse($id_course) {
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
			return new CourseReservation(NULL, NULL, NULL, NULL, NULL,$course ["id_course"], $course ["name"], $course ["type"],
												$course ["description"], $course ["capacity"], $course ["days"],
												$course ["start_time"], $course ["end_time"], $course ["id_space"],
												$course ["id_trainer"], $space_name, $trainer_name, $course ["price"]);
		} else {
			return NULL;
		}
	}

	/**
	* Updates a CourseReservation in the database
	*
	* @param Space $reservation The reservation to be saved
	* @throws PDOException if a database error occurs
	* @return int The modified id reservation
	*/
	public function confirm($reservation) {
		$stmt = $this->db->prepare("UPDATE courses_reservations
																set is_confirmed = ?
																WHERE id_reservation = ?");

		$stmt->execute(array(1, $reservation->getId_reservation()));
		return $this->db->lastInsertId();
	}

	/**
	* Updates a CourseReservation in the database
	*
	* @param CourseReservation $reservation The reservation to be saved
	* @throws PDOException if a database error occurs
	* @return int The modified id reservation
	*/
	public function cancel($reservation) {
		$stmt = $this->db->prepare("UPDATE courses_reservations
																set is_confirmed = ?
																WHERE id_reservation = ?");

		$stmt->execute(array(0, $reservation->getId_reservation()));
		return $this->db->lastInsertId();
	}

	/**
	* Deletes a CourseReservation into the database
	*
	* @param CourseReservation $course The reservation to be deleted
	* @throws PDOException if a database error occurs
	* @return void
	*/
	public function delete($reservation) {
		$stmt = $this->db->prepare("DELETE FROM courses_reservations WHERE id_reservation=?");
		$stmt->execute(array($reservation->getId_reservation()));
	}

	/**
	* Searhes a CourseReservation into the database
	*
	* @param string $query The query for the course to be searched
	* @throws PDOException if a database error occurs
	* @return mixed Array of CourseReservation instances that match the search parameter
	*/
	public function search($query) {
        $search_query = "SELECT * FROM courses_reservations WHERE ". $query;
        $stmt = $this->db->prepare($search_query);
        $stmt->execute();
        $reservations_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

				$reservations = array ();

				foreach ($reservations_db as $reservation) {
					array_push ($reservations, new CourseReservation($reservation ["id_reservation"],
																					 $reservation ["date"], $reservation ["time"],
																					 $reservation ["is_confirmed"], $reservation ["id_pupil"],
																					 $reservation ["id_course"]));
				}

        return $reservations;
    }
}
