<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../model/TournamentReservation.php");
require_once(__DIR__."/../model/TournamentReservationMapper.php");
require_once(__DIR__."/../model/UserMapper.php");

require_once(__DIR__."/../controller/BaseController.php");

/**
* Class TournamentReservationsController
*
* Controller to tournament reservation CRUD
*
* @author braisda <braisda@gmail.com>
*/
class TournamentReservationsController extends BaseController {

	/**
	* Reference to the TournamentReservationMapper to interact
	* with the database
	*
	* @var TournamentReservationMapper
	*/
	private $tournamentReservationMapper;
  private $userMapper;

	public function __construct() {
		parent::__construct();

		$this->tournamentReservationMapper = new TournamentReservationMapper();
    $this->userMapper = new UserMapper();
	}

	/**
	* Action to list tournament reservations
	*
	* Loads all the tournament reservations from the database.
	* No HTTP parameters are needed.
	*
	*/
	public function show(){
		if(!isset($this->currentUser)){
			throw new Exception("Not in session. Show tournaments requires login");
		}

		if($this->userMapper->findType() != "admin" && $this->userMapper->findType() != "competitor"){
			throw new Exception("You aren't an admin or a competitor. See all reservations requires be admin or competitor");
		}

		//Get the id, name and surname of the competitors
		$competitors = $this->tournamentReservationMapper->getPupils();

		if($_SESSION["admin"]){
			$reservations = $this->tournamentReservationMapper->show();
		}else{
			foreach ($competitors as $competitor) {
				if($competitor["email"] == $_SESSION["currentuser"]){
					$id_user = $competitor["id_user"];
				}
			}
			$reservations = $this->tournamentReservationMapper->showMine($id_user);
		}

		// Put the space variable visible to the view
		$this->view->setVariable("competitors", $competitors);

    //Get the id, name and type of the tournaments
		$tournaments = $this->tournamentReservationMapper->getTournaments();

		// Put the tournament variable visible to the view
		$this->view->setVariable("tournaments", $tournaments);

		// put the tournaments object to the view
		$this->view->setVariable("tournamentReservation", $reservations);

		// render the view (/view/tournamentReservations/show.php)
		$this->view->render("tournamentReservations", "show");
	}

	/**
	* Action to view a provided tournament reservation
	*
	* This action should only be called via GET
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>id: Id of the reservation (via HTTP GET)</li>
	* </ul>
	*
	* @throws Exception If no such reservation of the provided id is found
	* @return void
	*
	*/
	public function view(){
		if (!isset($_GET["id_reservation"])) {
			throw new Exception("id is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. View Tournaments Reservations requires login");
		}

		if($this->userMapper->findType() != "admin" && $this->userMapper->findType() != "competitor"){
			throw new Exception("You aren't an admin or a competitor. See all reservations requires be admin or competitor");
		}

		$id_reservation = $_GET["id_reservation"];

		// find the Reservation object in the database
		$reservation = $this->tournamentReservationMapper->view($id_reservation);

		if ($reservation == NULL) {
			throw new Exception("no such tournament with id: ".$id_reservation);
		}

    //Get the id, name and surname of the competitors
		$competitors = $this->tournamentReservationMapper->getPupils();

		// Put the space variable visible to the view
		$this->view->setVariable("competitors", $competitors);

    //Get the id, name and type of the tournaments
		$tournaments = $this->tournamentReservationMapper->getTournaments();

		// Put the tournament variable visible to the view
		$this->view->setVariable("tournaments", $tournaments);

		// put the tournament object to the view
		$this->view->setVariable("tournamentReservation", $reservation);

		// render the view (/view/tournamentReservations/view.php)
		$this->view->render("tournamentReservations", "view");
	}

	/**
	* Action to add a new tournament reservation
	*
	* When called via GET, it shows the add form
	* When called via POST, it adds the reservation to the database
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>date: Date of the reservation (via HTTP POST)</li>
	* <li>time: Time of the reservation (via HTTP POST)</li>
	* <li>is_confirmed: Surnme of the reservation (via HTTP POST)</li>
	* <li>id_competitor: Pupil id of the reservation (via HTTP POST)</li>
	* <li>id_tournament: Tournament id of the reservation (via HTTP POST)</li>
	* </ul>
	*
	* @throws Exception if no user is in session
	* @throws Exception if the type is not admin
	* @throws Exception if there is not any tournament with the provided id
	* @return void
	*/
	public function add(){
		if (!isset($_REQUEST["id_tournament"])) {
			throw new Exception("A id is mandatory");
		}

		$id_tournament = $_REQUEST["id_tournament"];

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding tournament reservation requires login");
		}

		if($this->userMapper->findType() != "competitor"){
			throw new Exception("You aren't a competitor. Adding an tournament reservation requires be competitor");
		}

		$reservation = new TournamentReservation();
		// find the Tournament object in the database
		$tournament = $this->tournamentReservationMapper->getTournament($id_tournament);
		$id_user = $this->tournamentReservationMapper->getId_user($_SESSION["currentuser"]);

		if(isset($_POST["submit"])) { // reaching via HTTP tournament...

			// populate the tournament reservation object with data
			$reservation->setDate(date("Y/m/d"));
			$reservation->setTime(date("h:i:sa"));
			$reservation->setIs_confirmed(0);
			$reservation->setId_competitor($id_user);
			$reservation->setId_tournament($id_tournament);

			try {
				// check if reservation exists in the database
				if(!$this->tournamentReservationMapper->reservationExists($id_user, $id_tournament)){
					//save the tournament object into the database
					$this->tournamentReservationMapper->add($reservation);

					// POST-REDIRECT-GET
					// Everything OK, we will redirect the user to the list of posts
					// We want to see a message after redirection, so we establish
					// a "flash" message (which is simply a Session variable) to be
					// get in the view after redirection.
					$this->view->setFlash(sprintf(i18n("Tournament reservation \"%s at %s\" successfully added."), $reservation->getDate(), $reservation->getTime()));

					// perform the redirection. More or less:
					// header("Location: index.php?controller=tournamentReservations&action=show")
					// die();
					$this->view->redirect("tournamentReservations", "show");
				} else {
					$errors = array();
					$errors["reservation"] = "Reservation already exists";
					$this->view->setVariable("errors", $errors);
				}
			}catch(ValidationException $ex) {
				// Get the errors array inside the exepction...
				$errors = $ex->getErrors();
				// And put it to the view as "errors" variable
				$this->view->setVariable("errors", $errors);
			}
		}
		// put the tournament object to the view
		$this->view->setVariable("tournament", $tournament);

		// render the view (/view/tournaments/add.php)
		$this->view->render("tournamentReservations", "add");
	}

	/**
	* Action to confirm a reservation
	*
	* When called via GET, it shows the add form
	* When called via POST, it modifies the reservation in the database.
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>id: Id of the reservation (via HTTP POST and GET)</li>
	* </ul>
	*
	* @throws Exception if no user is in session
	* @throws Exception if a reservation id is not provided
	* @throws Exception if the type is not admin
	* @throws Exception if there is not any reservation with the provided id
	* @return void
	*/
	public function confirm(){
		if (!isset($_REQUEST["id_reservation"])) {
			throw new Exception("A id is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Confirm a reservation requires login");
		}

		if($this->userMapper->findType() != "admin"){
			throw new Exception("You aren't an admin. Confirm a reservation requires be admin");
		}

		$id_reservation = $_REQUEST["id_reservation"];
		$reservation = $this->tournamentReservationMapper->view($id_reservation);

		if ($reservation == NULL) {
			throw new Exception("no such reservation with id: ".$id_reservation);
		}

		try {
			//save the reservation object into the database
			$this->tournamentReservationMapper->confirm($reservation);

			$this->view->setFlash(sprintf(i18n("Reservation \"%s at %s\" successfully confirmed."),$reservation->getDate(), $reservation->getTime()));

			$this->view->redirect("tournamentReservations", "show");

		}catch(ValidationException $ex) {
			// Get the errors array inside the exepction...
			$errors = $ex->getErrors();
			// And put it to the view as "errors" variable
			$this->view->setVariable("errors", $errors);
		}

		// render the view (/view/users/add.php)
		$this->view->render("tournamentReservations", "show");
	}

	/**
	* Action to cancel a reservation
	*
	* When called via GET, it shows the add form
	* When called via POST, it modifies the reservation in the database.
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>id: Id of the reservation (via HTTP POST and GET)</li>
	* </ul>
	*
	* @throws Exception if no user is in session
	* @throws Exception if a reservation id is not provided
	* @throws Exception if the type is not admin
	* @throws Exception if there is not any reservation with the provided id
	* @return void
	*/
	public function cancel(){
		if (!isset($_REQUEST["id_reservation"])) {
			throw new Exception("A id is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Confirm a reservation requires login");
		}

		if($this->userMapper->findType() != "admin"){
			throw new Exception("You aren't an admin. Confirm a reservation requires be admin");
		}

		$id_reservation = $_REQUEST["id_reservation"];
		$reservation = $this->tournamentReservationMapper->view($id_reservation);

		if ($reservation == NULL) {
			throw new Exception("no such reservation with id: ".$id_reservation);
		}

		try {

			//save the reservation object into the database
			$this->tournamentReservationMapper->cancel($reservation);

			$this->view->setFlash(sprintf(i18n("Reservation \"%s at %s\" successfully cancelled."),$reservation->getDate(), $reservation->getTime()));

			$this->view->redirect("tournamentReservations", "show");

		}catch(ValidationException $ex) {
			// Get the errors array inside the exepction...
			$errors = $ex->getErrors();
			// And put it to the view as "errors" variable
			$this->view->setVariable("errors", $errors);
		}

		// render the view (/view/users/add.php)
		$this->view->render("tournamentReservations", "show");
	}

	/**
	* Action to delete a tournament reservation
	*
	* This action should only be called via HTTP POST
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>id: Id of the reservation (via HTTP POST and GET)</li>
	* </ul>
	*
	* @throws Exception if no user is in session
	* @throws Exception if a user id is not provided
	* @throws Exception if the type is not admin
	* @throws Exception if there is not any reservation with the provided id
	* @return void
	*/
	public function delete() {

		if (!isset($_REQUEST["id_reservation"])) {
			throw new Exception("A id is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding tournaments reservations requires login");
		}

		if($this->userMapper->findType() != "admin" && $this->userMapper->findType() != "competitor"){
			throw new Exception("You aren't an admin. Delete a tournament reservation requires be admin or competitor");
		}

		// Get the User object from the database
		$id_reservation = $_REQUEST["id_reservation"];
		$reservation = $this->tournamentReservationMapper->view($id_reservation);

		if($_SESSION["competitor"]){
			if($this->tournamentReservationMapper->getState($id_reservation) == 1){
				throw new Exception("You can't delete a tournament reservation which is confirmed");
			}
		}
		// Does the reservation exist?
		if ($reservation == NULL) {
			throw new Exception("no such reservation with id: ".$id_reservation);
		}

		if (isset($_POST["submit"])) {

			try {
				// Delete the TournamentReservation object from the database
				$this->tournamentReservationMapper->delete($reservation);

				// POST-REDIRECT-GET
				// Everything OK, we will redirect the user to the list of posts
				// We want to see a message after redirection, so we establish
				// a "flash" message (which is simply a Session variable) to be
				// get in the view after redirection.
				$this->view->setFlash(sprintf(i18n("Tournament reservation \"%s at %s\" successfully deleted."), $reservation->getDate(), $reservation->getTime()));

				// perform the redirection. More or less:
				// header("Location: index.php?controller=posts&action=index")
				// die();
				$this->view->redirect("tournamentReservations", "show");

			}catch(ValidationException $ex) {
				// Get the errors array inside the exepction...
				$errors = $ex->getErrors();
				// And put it to the view as "errors" variable
				$this->view->setVariable("errors", $errors);
			}
		}

    //Get the id, name and surname of the competitors
		$competitors = $this->tournamentReservationMapper->getPupils();

		// Put the space variable visible to the view
		$this->view->setVariable("competitors", $competitors);

    //Get the id, name and type of the tournaments
		$tournaments = $this->tournamentReservationMapper->getTournaments();

		// Put the tournament variable visible to the view
		$this->view->setVariable("tournaments", $tournaments);

		// Put the user object visible to the view
		$this->view->setVariable("tournamentReservation", $reservation);
		// render the view (/view/tournamentReservations/delete.php)
		$this->view->render("tournamentReservations", "delete");
	}

	/**
	* Action to list reservations that match a search pattern
	*
	* This action should only be called via HTTP POST
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>id_competitor: Pupil id of the reservation (via HTTP POST)</li>
	* <li>id_tournament: Tournament id of the reservation (via HTTP POST)</li>
	* <li>date: Date id of the reservation (via HTTP POST)</li>
	* <li>time: Time id of the reservation (via HTTP POST)</li>
	* <li>is_confirmed: State of the reservation (via HTTP POST)</li>
	* </ul>
	*
	* @throws Exception if no user is in session
	* @throws Exception if the type is not admin
	* @return void
	*/
	public function search() {
		if(!isset($this->currentUser)){
			throw new Exception("Not in session. Show users requires login");
		}

		if($this->userMapper->findType() != "admin" && $this->userMapper->findType() != "competitor"){
			throw new Exception("You aren't an admin or a trainer. Search reservations requires be admin or trainer");
		}

		if (isset($_POST["submit"])) {
			$query = "";
			$flag = 0;
			if($this->userMapper->findType() == "admin"){
				if ($_POST["competitor"]){
					if ($flag){
						$query .= " AND ";
					}
					$query .= "id_competitor='". $_POST["competitor"]."'";
					$flag = 1;
				}
			}

			if ($_POST["tournament"]){
				if ($flag){
					$query .= " AND ";
				}
				$query .= "id_tournament='". $_POST["tournament"]."'";
				$flag = 1;
			}

			if ($_POST["date"]){
				if ($flag){
					$query .= " AND ";
				}
				$query .= "date='". $_POST["date"]."'";
				$flag = 1;
			}

			if ($_POST["time"]){
				if ($flag){
					$query .= " AND ";
				}
				$query .= "time='". $_POST["time"]."'";
				$flag = 1;
			}

			if ($_POST["confirmed"] == 1 || $_POST["confirmed"] == 0){
				if ($flag){
					$query .= " AND ";
				}
				$query .= "is_confirmed='". $_POST["confirmed"]."'";
				$flag = 1;
			}

			if($this->userMapper->findType() == "competitor"){
				$id = $this->tournamentReservationMapper->getId_user($_SESSION["currentuser"]);
				if ($flag){
					$query .= " AND ";
				}
				$query .= "id_competitor='".$id."'";
				$flag = 1;
			}

			if (empty($query)) {
				if($this->userMapper->findType() == "admin"){
					$reservations = $this->tournamentReservationMapper->show();
				}else{
					$reservations = $this->tournamentReservationMapper->showMine($this->tournamentReservationMapper->getId_user($_SESSION["currentuser"]));
				}
			} else {
				$reservations = $this->tournamentReservationMapper->search($query);
			}
			//Get the id, name and surname of the competitors
			$competitors = $this->tournamentReservationMapper->getPupils();

			// Put the space variable visible to the view
			$this->view->setVariable("competitors", $competitors);

	    //Get the id, name and type of the tournaments
			$tournaments = $this->tournamentReservationMapper->getTournaments();

			// Put the tournament variable visible to the view
			$this->view->setVariable("tournaments", $tournaments);

			$this->view->setVariable("tournamentReservation", $reservations);
			$this->view->render("tournamentReservations", "show");
		}else {
			//Get the id, name and surname of the competitors
			$competitors = $this->tournamentReservationMapper->getPupils();

			// Put the space variable visible to the view
			$this->view->setVariable("competitors", $competitors);

	    //Get the id, name and type of the tournaments
			$tournaments = $this->tournamentReservationMapper->getTournaments();

			// Put the tournament variable visible to the view
			$this->view->setVariable("tournaments", $tournaments);

			// render the view (/view/tournamentReservations/search.php)
			$this->view->render("tournamentReservations", "search");
		}
	}
}
