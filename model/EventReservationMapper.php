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

  public function getAssistants() {
		$stmt = $this->db->query("SELECT id_user, name, surname FROM users");

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

	public function update($reservation) {
		$stmt = $this->db->prepare("UPDATE events_reservations
																set is_confirmed = ?
																WHERE id_event = ?");

		$stmt->execute(array(1, $reservation->getId_event()));
		return $this->db->lastInsertId();
	}

	public function delete($event) {
		//Borrado físico
		$stmt = $this->db->prepare("DELETE FROM events_reservations WHERE id_reservation=?");
		$stmt->execute(array($event->getId_reservation()));
	}
}
