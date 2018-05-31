<?php
// file: model/TournamentReservationMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

/**
* Class TournamentReservationMapper
*
* Database interface for TournamentReservation entities
*
* @author braisda <braisda@gmail.com>
*/
class TournamentReservationMapper {

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
	* @param string $competitors the competitors of the reservation to check
	* @param string $tournament the tournament of the reservation to check
	* @return boolean true if the name exists, false otherwise
	*/
	public function reservationExists($competitors, $tournament) {
		$stmt = $this->db->prepare("SELECT count(id_player) FROM tournaments_reservations where id_player=? AND id_tournament=?");
		$stmt->execute(array($competitors, $tournament));

		if ($stmt->fetchColumn() > 0) {
			return true;
		}
	}

	/**
	* Retrieves all reservations
	*
	* @throws PDOException if a database error occurs
	* @return mixed Array of TournamentReservation instances
	*/
	public function show() {
		$stmt = $this->db->query ("SELECT * FROM tournaments_reservations ORDER BY date DESC");

		$reservations_db = $stmt->fetchAll ( PDO::FETCH_ASSOC );

		$reservations = array ();

		foreach ($reservations_db as $reservation) {
			array_push ($reservations, new TournamentReservation($reservation ["id_reservation"],
                                       $reservation ["date"], $reservation ["time"],
																			 $reservation ["is_confirmed"], $reservation ["id_player"],
                                       $reservation ["id_tournament"]));
		}

		return $reservations;
	}

	/**
	* Retrieves reservations of the current user
	*
	* @param string $id_player The id of the user
	* @throws PDOException if a database error occurs
	* @return mixed Array of TournamentReservation instances
	*/
	public function showMine($id_player) {
		$stmt = $this->db->prepare("SELECT * FROM tournaments_reservations WHERE id_player= ? ORDER BY date DESC");
		$stmt->execute(array($id_player));
		$reservations_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$reservations = array();

		foreach ($reservations_db as $reservation) {
			array_push($reservations, new TournamentReservation($reservation ["id_reservation"],
	                                     $reservation ["date"], $reservation ["time"],
																			 $reservation ["is_confirmed"], $reservation ["id_player"],
	                                     $reservation ["id_tournament"]));
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
		$stmt = $this->db->query("SELECT id_user, name, surname, email FROM users WHERE is_competitor = 1 ORDER BY name");

		$competitorss = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $competitorss;
	}

	/**
	* Retrieves id, name from all tournaments
	*
	* @throws PDOException if a database error occurs
	* @return mixed Array of tournaments
	*/
	public function getTournaments() {
		$stmt = $this->db->query("SELECT id_tournament, name FROM tournaments ORDER BY name");

		$tournaments = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $tournaments;
	}

	/**
	* Loads a TournamentReservation from the database given its id
	*
	* @param string $id_reservation The id of the reservation
	* @throws PDOException if a database error occurs
	* @return TournamentReservation The TournamentReservation instances. NULL if the User is not found
	*
	*/
	public function view($id_reservation) {
		$stmt = $this->db->prepare("SELECT * FROM tournaments_reservations WHERE id_reservation=?");
		$stmt->execute(array($id_reservation));

		$reservation = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($reservation != null) {
			return new TournamentReservation($reservation["id_reservation"], $reservation["date"], $reservation["time"],
												$reservation["is_confirmed"], $reservation["id_player"], $reservation["id_tournament"]);
		} else {
			return NULL;
		}
	}

	/**
	* Loads the state of a TournamentReservation from the database given its id
	*
	* @param string $id_reservation The id of the reservation
	* @throws PDOException if a database error occurs
	* @return string The state of the reservation. NULL if the TournamentReservation is not found
	*
	*/
	public function getState($id_reservation){
		$stmt = $this->db->prepare("SELECT is_confirmed FROM tournaments_reservations WHERE id_reservation=?");
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
	* Saves a TournamentReservation into the database
	*
	* @param TournamentReservation $tournamentReservation The reservation to be saved
	* @throws PDOException if a database error occurs
	* @return int The new reservation id
	*/
	public function add($tournamentReservation) {
		$stmt = $this->db->prepare("INSERT INTO tournaments_reservations(date, time, is_confirmed, id_player, id_tournament)
																values (?,?,?,?,?)");

		$stmt->execute(array($tournamentReservation->getDate(), $tournamentReservation->getTime(),
												 $tournamentReservation->getIs_confirmed(), $tournamentReservation->getId_competitor(),
												 $tournamentReservation->getId_tournament()));
		return $this->db->lastInsertId();
	}

	/**
	* Loads a TournamentReservation with the informatin of the tournament from the database given its id
	*
	* @param string $id_tournament The id of the tournament
	* @throws PDOException if a database error occurs
	* @return TournamentReservation The TournamentReservation instances. NULL if the TournamentReservation is not found
	*
	*/
	public function getTournament($id_tournament) {
		$stmt = $this->db->prepare("SELECT * FROM tournaments WHERE id_tournament=?");
		$stmt->execute(array($id_tournament));

		$tournament = $stmt->fetch ( PDO::FETCH_ASSOC );

		if ($tournament != null) {
			return new TournamentReservation(NULL, NULL, NULL, NULL, NULL,$tournament ["id_tournament"], $tournament ["name"],
												$tournament ["description"], $tournament ["start_date"], $tournament ["end_date"],
												$tournament ["price"]);
		} else {
			return NULL;
		}
	}

	/**
	* Updates a TournamentReservation in the database
	*
	* @param Space $reservation The reservation to be saved
	* @throws PDOException if a database error occurs
	* @return int The modified id reservation
	*/
	public function confirm($reservation) {
		$stmt = $this->db->prepare("UPDATE tournaments_reservations
																set is_confirmed = ?
																WHERE id_reservation = ?");

		$stmt->execute(array(1, $reservation->getId_reservation()));
		return $this->db->lastInsertId();
	}

	/**
	* Updates a TournamentReservation in the database
	*
	* @param TournamentReservation $reservation The reservation to be saved
	* @throws PDOException if a database error occurs
	* @return int The modified id reservation
	*/
	public function cancel($reservation) {
		$stmt = $this->db->prepare("UPDATE tournaments_reservations
																set is_confirmed = ?
																WHERE id_reservation = ?");

		$stmt->execute(array(0, $reservation->getId_reservation()));
		return $this->db->lastInsertId();
	}

	/**
	* Deletes a TournamentReservation into the database
	*
	* @param TournamentReservation $tournament The reservation to be deleted
	* @throws PDOException if a database error occurs
	* @return void
	*/
	public function delete($reservation) {
		$stmt = $this->db->prepare("DELETE FROM tournaments_reservations WHERE id_reservation=?");
		$stmt->execute(array($reservation->getId_reservation()));
	}

	/**
	* Searhes a TournamentReservation into the database
	*
	* @param string $query The query for the tournament to be searched
	* @throws PDOException if a database error occurs
	* @return mixed Array of TournamentReservation instances that match the search parameter
	*/
	public function search($query) {
        $search_query = "SELECT * FROM tournaments_reservations WHERE ". $query;
        $stmt = $this->db->prepare($search_query);
        $stmt->execute();
        $reservations_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

				$reservations = array ();

				foreach ($reservations_db as $reservation) {
					array_push ($reservations, new TournamentReservation($reservation ["id_reservation"],
																					 $reservation ["date"], $reservation ["time"],
																					 $reservation ["is_confirmed"], $reservation ["id_player"],
																					 $reservation ["id_tournament"]));
				}

        return $reservations;
    }
}
