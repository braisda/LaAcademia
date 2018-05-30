<?php
// file: model/EventMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

/**
* Class EventReservationMapper
*
* Database interface for EventReservation entities
*
* @author lipido <lipido@gmail.com>
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
	* Saves a Event into the database
	*
	* @param EventReservation $EventReservation The reservation to be saved
	* @throws PDOException if a database error occurs
	* @return void
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

  public function getAssistants() {
		$stmt = $this->db->query("SELECT id_user, name, surname, email FROM users where is_pupil = 1 OR is_competitor = 1 ORDER BY name");

		$assistants = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $assistants;
	}

	public function getEvents() {
		$stmt = $this->db->query("SELECT id_event, name FROM events");

		$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $events;
	}

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
		$stmt = $this->db->prepare("INSERT INTO events_reservations(date, time, is_confirmed, id_event, id_assistant)
																values (?,?,?,?,?)");

		$stmt->execute(array($courseReservation->getDate(), $courseReservation->getTime(),
												 $courseReservation->getIs_confirmed(), $courseReservation->getId_event(),
												 $courseReservation->getId_assistant()));
		return $this->db->lastInsertId();
	}

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

	public function confirm($reservation) {
		$stmt = $this->db->prepare("UPDATE events_reservations
																set is_confirmed = ?
																WHERE id_event = ?");

		$stmt->execute(array(1, $reservation->getId_event()));
		return $this->db->lastInsertId();
	}

	public function cancel($reservation) {
		$stmt = $this->db->prepare("UPDATE events_reservations
																set is_confirmed = ?
																WHERE id_reservation = ?");

		$stmt->execute(array(0, $reservation->getId_reservation()));
		return $this->db->lastInsertId();
	}

	public function delete($event) {
		//Borrado físico
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
