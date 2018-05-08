<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../model/EventReservation.php");
require_once(__DIR__."/../model/EventReservationMapper.php");
require_once(__DIR__."/../model/UserMapper.php");

require_once(__DIR__."/../controller/BaseController.php");

/**
* Class EventsController
*
* Controller to events CRUD
*
* @author lipido <lipido@gmail.com>
*/
class EventReservationsController extends BaseController {

	/**
	* Reference to the EventReservationMapper to interact
	* with the database
	*
	* @var EventReservationMapper
	*/
	private $eventReservationMapper;
  private $userMapper;

	public function __construct() {
		parent::__construct();

		$this->eventReservationMapper = new EventReservationMapper();
    $this->userMapper = new UserMapper();
	}

	public function show(){
		if(!isset($this->currentUser)){
			throw new Exception("Not in session. Show events requires login");
		}

		if($this->userMapper->findType() == "trainer"){
			throw new Exception("You aren't an admin, a competitor or a pupil. See all reservatinos requires be admin, competitor or pupil");
		}

    //Get the id, name and surname of the assistants
		$assistants = $this->eventReservationMapper->getAssistants();

		if($_SESSION["admin"]){
			$reservations = $this->eventReservationMapper->show();
		}else{
			foreach ($assistants as $assistant) {
				if($assistant["email"] == $_SESSION["currentuser"]){
					$id_user = $assistant["id_user"];
				}
			}
			$reservations = $this->eventReservationMapper->showMine($id_user);
		}

		// Put the space variable visible to the view
		$this->view->setVariable("assistants", $assistants);

    //Get the id, name and type of the events
		$events = $this->eventReservationMapper->getEvents();

		// Put the event variable visible to the view
		$this->view->setVariable("events", $events);

		// put the events object to the view
		$this->view->setVariable("eventReservation", $reservations);

		// render the view (/view/eventReservations/show.php)
		$this->view->render("eventReservations", "show");
	}

	public function view(){
		if (!isset($_GET["id_reservation"])) {
			throw new Exception("id is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. View Events Reservations requires login");
		}

		if($this->userMapper->findType() == "trainer"){
			throw new Exception("You aren't an admin, a competitor or a pupil. See all reservatinos requires be admin, competitor or pupil");
		}

		$id_reservation = $_GET["id_reservation"];

		// find the Reservation object in the database
		$reservation = $this->eventReservationMapper->view($id_reservation);

		if ($reservation == NULL) {
			throw new Exception("no such event with id: ".$id_reservation);
		}

    //Get the id, name and surname of the assistants
		$assistants = $this->eventReservationMapper->getAssistants();

		// Put the space variable visible to the view
		$this->view->setVariable("assistants", $assistants);

    //Get the id, name and type of the events
		$events = $this->eventReservationMapper->getEvents();

		// Put the event variable visible to the view
		$this->view->setVariable("events", $events);

		// put the event object to the view
		$this->view->setVariable("eventReservation", $reservation);

		// render the view (/view/eventReservations/view.php)
		$this->view->render("eventReservations", "view");
	}

	public function add(){
		if (!isset($_REQUEST["id_event"])) {
			throw new Exception("A id is mandatory");
		}

		$id_event = $_REQUEST["id_event"];

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding event reservation requires login");
		}

		if($this->userMapper->findType() != "pupil" && $this->userMapper->findType() != "competitor"){
			throw new Exception("You aren't a pupil. Adding an event reservation requires be pupil or competitor");
		}

		$reservation = new EventReservation();
		// find the Event object in the database
		$event = $this->eventReservationMapper->getEvent($id_event);
		$id_user = $this->eventReservationMapper->getId_user($_SESSION["currentuser"]);

		if(isset($_POST["submit"])) { // reaching via HTTP event...

			// populate the event reservation object with data
			$reservation->setDate(date("Y-m-d"));
			$reservation->setTime(date("H:i:s"));
			$reservation->setIs_confirmed(0);
			$reservation->setId_assistant($id_user);
			$reservation->setId_event($id_event);

			try {
				//save the event reservation object into the database
				$this->eventReservationMapper->add($reservation);

				$this->view->setFlash(sprintf(i18n("Event reservation \"%s at %s\" successfully added."), date("Y-m-d"), date("H:i:s")));

				$this->view->redirect("eventReservations", "show");

			}catch(ValidationException $ex) {
				// Get the errors array inside the exepction...
				$errors = $ex->getErrors();
				// And put it to the view as "errors" variable
				$this->view->setVariable("errors", $errors);
			}
		}
		// put the event object to the view
		$this->view->setVariable("event", $event);

		// render the view (/view/events/add.php)
		$this->view->render("eventReservations", "add");
	}

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
		$reservation = $this->eventReservationMapper->view($id_reservation);

		if ($reservation == NULL) {
			throw new Exception("no such reservation with id: ".$id_reservation);
		}

		try {

			//save the reservation object into the database
			$this->eventReservationMapper->confirm($reservation);

			$this->view->setFlash(sprintf(i18n("Reservation \"%s at %s\" successfully confirmed."),$reservation->getDateReservation(), $reservation->getTimeReservation()));

			$this->view->redirect("eventReservations", "show");

		}catch(ValidationException $ex) {
			// Get the errors array inside the exepction...
			$errors = $ex->getErrors();
			// And put it to the view as "errors" variable
			$this->view->setVariable("errors", $errors);
		}

		// render the view (/view/users/add.php)
		$this->view->render("eventReservations", "show");
	}

	public function cancel(){
		if (!isset($_REQUEST["id_reservation"])) {
			throw new Exception("A id is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Cancel a reservation requires login");
		}

		if($this->userMapper->findType() != "admin"){
			throw new Exception("You aren't an admin. Cancel a reservation requires be admin");
		}

		$id_reservation = $_REQUEST["id_reservation"];
		$reservation = $this->eventReservationMapper->view($id_reservation);

		if ($reservation == NULL) {
			throw new Exception("no such reservation with id: ".$id_reservation);
		}

		try {

			//save the reservation object into the database
			$this->eventReservationMapper->cancel($reservation);

			$this->view->setFlash(sprintf(i18n("Reservation \"%s at %s\" successfully cancelled."),$reservation->getDateReservation(), $reservation->getTimeReservation()));

			$this->view->redirect("eventReservations", "show");

		}catch(ValidationException $ex) {
			// Get the errors array inside the exepction...
			$errors = $ex->getErrors();
			// And put it to the view as "errors" variable
			$this->view->setVariable("errors", $errors);
		}

		// render the view (/view/users/add.php)
		$this->view->render("eventReservations", "show");
	}

	public function delete() {

		if (!isset($_REQUEST["id_reservation"])) {
			throw new Exception("A id is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding events reservations requires login");
		}

		if($this->userMapper->findType() != "admin" && $this->userMapper->findType() != "pupil" && $this->userMapper->findType() != "competitor"){
			throw new Exception("You aren't an admin. Adding a event reservation requires be admin");
		}

		// Get the User object from the database
		$id_reservation = $_REQUEST["id_reservation"];
		$reservation = $this->eventReservationMapper->view($id_reservation);

		if($_SESSION["pupil"] || $_SESSION["competitor"]){
			if($this->eventReservationMapper->getState($id_reservation) == 1){
				throw new Exception("You can't delete a event reservation which is confirmed");
			}
		}

		// Does the reservation exist?
		if ($reservation == NULL) {
			throw new Exception("no such reservation with id: ".$id_reservation);
		}

		if (isset($_POST["submit"])) {

			try {
				// Delete the EventReservation object from the database
				$this->eventReservationMapper->delete($reservation);

				// POST-REDIRECT-GET
				// Everything OK, we will redirect the user to the list of posts
				// We want to see a message after redirection, so we establish
				// a "flash" message (which is simply a Session variable) to be
				// get in the view after redirection.
				$this->view->setFlash(sprintf(i18n("Event reservation \"%s at %s\" successfully deleted."), $reservation->getDateReservation(), $reservation->getTimeReservation()));

				// perform the redirection. More or less:
				// header("Location: index.php?controller=posts&action=index")
				// die();
				$this->view->redirect("eventReservations", "show");

			}catch(ValidationException $ex) {
				// Get the errors array inside the exepction...
				$errors = $ex->getErrors();
				// And put it to the view as "errors" variable
				$this->view->setVariable("errors", $errors);
			}
		}

    //Get the id, name and surname of the assistants
		$assistants = $this->eventReservationMapper->getAssistants();

		// Put the space variable visible to the view
		$this->view->setVariable("assistants", $assistants);

    //Get the id, name and type of the events
		$events = $this->eventReservationMapper->getEvents();

		// Put the event variable visible to the view
		$this->view->setVariable("events", $events);

		// Put the user object visible to the view
		$this->view->setVariable("eventReservation", $reservation);
		// render the view (/view/eventReservations/delete.php)
		$this->view->render("eventReservations", "delete");

	}
}
