<?php
// file: model/EventReservationMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

/**
* Class EventReservationMapper
*
* Database interface for EventReservation entities
*
* @author braisda <braisda@gmail.com>
*/
class EventReservationMapper {

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
	* @param string $assistant the assistant of the reservation to check
	* @param string $event the event of the reservation to check
	* @return boolean true if the name exists, false otherwise
	*/
	public function reservationExists($assistant, $event) {
		$stmt = $this->db->prepare("SELECT count(id_assistant) FROM events_reservations where id_assistant=? AND id_event=?");
		$stmt->execute(array($assistant, $event));

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
		$stmt = $this->db->query ( "SELECT * FROM events_reservations ORDER BY date" );

		$reservations_db = $stmt->fetchAll ( PDO::FETCH_ASSOC );

		$reservations = array ();

		foreach ($reservations_db as $reservation) {
			array_push ($reservations, new EventReservation($reservation ["id_reservation"],
                                       $reservation ["date"], $reservation ["time"],
																			 $reservation ["is_confirmed"], $reservation ["id_assistant"],
                                       $reservation ["id_event"]));
		}

		return $reservations;
	}

	/**
	* Retrieves reservations of the current user
	*
	* @param string $id_assistant The id of the user
	* @throws PDOException if a database error occurs
	* @return mixed Array of EventReservation instances
	*/
	public function showMine($id_assistant) {
		$stmt = $this->db->prepare("SELECT * FROM events_reservations WHERE id_assistant= ? ORDER BY date DESC");
		$stmt->execute(array($id_assistant));
		$reservations_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$reservations = array();

		foreach ($reservations_db as $reservation) {
			array_push($reservations, new EventReservation($reservation ["id_reservation"],
	                                     $reservation ["date"], $reservation ["time"],
																			 $reservation ["is_confirmed"], $reservation ["id_assistant"],
	                                     $reservation ["id_event"]));
		}

		return $reservations;
	}

	/**
	* Retrieves id, name, surname and email from all users
	*
	* @throws PDOException if a database error occurs
	* @return mixed Array of users
	*/
  public function getAssistants() {
		$stmt = $this->db->query("SELECT id_user, name, surname, email FROM users where is_pupil = 1 OR is_competitor = 1 ORDER BY name");

		$assistants = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $assistants;
	}

	/**
	* Retrieves id, name, and type from all events
	*
	* @throws PDOException if a database error occurs
	* @return mixed Array of courses
	*/
	public function getEvents() {
		$stmt = $this->db->query("SELECT id_event, name FROM events");

		$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $events;
	}

	/**
	* Loads a EventReservation from the database given its id
	*
	* @param string $id_reservation The id of the reservation
	* @throws PDOException if a database error occurs
	* @return CourseReservation The EventReservation instances. NULL if the User is not found
	*
	*/
	public function view($id_reservation) {
		$stmt = $this->db->prepare("SELECT * FROM events_reservations WHERE id_reservation=?");
		$stmt->execute(array($id_reservation));

		$reservation = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($reservation != null) {
			return new EventReservation($reservation["id_reservation"], $reservation["date"], $reservation["time"],
												$reservation["is_confirmed"], $reservation["id_assistant"], $reservation["id_event"]);
		} else {
			return NULL;
		}
	}

	/**
	* Loads the state of a EventReservation from the database given its id
	*
	* @param string $id_reservation The id of the reservation
	* @throws PDOException if a database error occurs
	* @return string The state of the reservation. NULL if the EventReservation is not found
	*
	*/
	public function getState($id_course){
		$stmt = $this->db->prepare("SELECT is_confirmed FROM events_reservations WHERE id_reservation=?");
		$stmt->execute(array($id_course));
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
	* Saves a EventReservation into the database
	*
	* @param CourseReservation $eventReservation The reservation to be saved
	* @throws PDOException if a database error occurs
	* @return int The new reservation id
	*/
	public function add($eventReservation) {
		$stmt = $this->db->prepare("INSERT INTO events_reservations(date, time, is_confirmed, id_event, id_assistant)
																values (?,?,?,?,?)");

		$stmt->execute(array($eventReservation->getDate(), $eventReservation->getTime(),
												 $eventReservation->getIs_confirmed(), $eventReservation->getId_event(),
												 $eventReservation->getId_assistant()));
		return $this->db->lastInsertId();
	}

	/**
	* Loads a EventReservation with the informatin of the course from the database given its id
	*
	* @param string $id_event The id of the course
	* @throws PDOException if a database error occurs
	* @return CourseReservation The EventReservation instances. NULL if the EventReservation is not found
	*
	*/
	public function getEvent($id_event) {
		$stmt = $this->db->prepare("SELECT * FROM events WHERE id_event=?");
		$stmt->execute(array($id_event));

		$event = $stmt->fetch(PDO::FETCH_ASSOC);

		$stmt2 = $this->db->prepare("SELECT name FROM spaces WHERE id_space=?");
    $stmt2->execute(array($event ["id_space"]));

    $space = $stmt2->fetch ( PDO::FETCH_ASSOC );

    $space_name = $space ["name"];

		if ($event != null) {
			return new EventReservation(NULL, NULL, NULL, NULL, NULL, $event["id_event"],
																  $event["name"],	$event["description"],
																	$event["price"], $event["capacity"], $event["date"],
																	$event["time"], $event["id_space"], $space_name);
		}else {
			return NULL;
		}
	}

	/**
	* Updates a EventReservation in the database
	*
	* @param Space $reservation The reservation to be saved
	* @throws PDOException if a database error occurs
	* @return int The modified id reservation
	*/
	public function confirm($reservation) {
		$stmt = $this->db->prepare("UPDATE events_reservations
																set is_confirmed = ?
																WHERE id_event = ?");

		$stmt->execute(array(1, $reservation->getId_event()));
		return $this->db->lastInsertId();
	}

	/**
	* Updates a EventReservation in the database
	*
	* @param CourseReservation $reservation The reservation to be saved
	* @throws PDOException if a database error occurs
	* @return int The modified id reservation
	*/
	public function cancel($reservation) {
		$stmt = $this->db->prepare("UPDATE events_reservations
																set is_confirmed = ?
																WHERE id_reservation = ?");

		$stmt->execute(array(0, $reservation->getId_reservation()));
		return $this->db->lastInsertId();
	}

	/**
	* Deletes a EventReservation into the database
	*
	* @param CourseReservation $course The reservation to be deleted
	* @throws PDOException if a database error occurs
	* @return void
	*/
	public function delete($event) {
		$stmt = $this->db->prepare("DELETE FROM events_reservations WHERE id_reservation=?");
		$stmt->execute(array($event->getId_reservation()));
	}

	/**
	* Searhes a EventReservation into the database
	*
	* @param string $query The query for the event to be searched
	* @throws PDOException if a database error occurs
	* @return mixed Array of CourseReservation instances that match the search parameter
	*/
	public function search($query) {
        $search_query = "SELECT * FROM events_reservations WHERE ". $query;
        $stmt = $this->db->prepare($search_query);
        $stmt->execute();
        $reservations_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

				$reservations = array ();

				foreach ($reservations_db as $reservation) {
					array_push ($reservations, new EventReservation($reservation ["id_reservation"],
		                                       $reservation ["date"], $reservation ["time"],
																					 $reservation ["is_confirmed"], $reservation ["id_assistant"],
		                                       $reservation ["id_event"]));
				}

        return $reservations;
    }
}
