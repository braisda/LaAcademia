<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../model/Tournament.php");
require_once(__DIR__."/../model/TournamentMapper.php");
require_once(__DIR__."/../model/UserMapper.php");

require_once(__DIR__."/../controller/BaseController.php");

/**
* Class EventsController
*
* Controller to events CRUD
*
* @author lipido <lipido@gmail.com>
*/
class TournamentsController extends BaseController {

	/**
	* Reference to the EventMapper to interact
	* with the database
	*
	* @var TournamentMapper
	*/
	private $tournamentMapper;
  private $userMapper;

	public function __construct() {
		parent::__construct();

		$this->tournamentMapper = new TournamentMapper();
    $this->userMapper = new UserMapper();
	}

	public function show(){
		if(!isset($this->currentUser)){
			throw new Exception("Not in session. Show tournaments requires login");
		}

		$tournaments = $this->tournamentMapper->show();

		// put the tournaments object to the view
		$this->view->setVariable("tournaments", $tournaments);

		// render the view (/view/tournaments/show.php)
		$this->view->render("tournaments", "show");
	}

	public function view(){
		if (!isset($_GET["id_tournament"])) {
			throw new Exception("Event id is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. View Events requires login");
		}

		$id_tournament = $_GET["id_tournament"];

		// find the Event object in the database
		$tournament = $this->tournamentMapper->view($id_tournament);

		if ($tournament == NULL) {
			throw new Exception("No such tournament with id: ".$id_tournament);
		}

		// put the event object to the view
		$this->view->setVariable("tournament", $tournament);

		// render the view (/view/tournaments/view.php)
		$this->view->render("tournaments", "view");
	}
/*
	public function add(){

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding tournaments requires login");
		}

		if($this->userMapper->findType() != "admin"){
			throw new Exception("You aren't an admin. Adding an tournament requires be admin");
		}

		$tournament = new tournament();

		if(isset($_POST["submit"])) { // reaching via HTTP tournament...

			// populate the tournament object with data form the form
			$tournament->setName($_POST["name"]);
			$tournament->setDescription($_POST["description"]);
			$tournament->setCapacity($_POST["capacity"]);
			$tournament->setDate($_POST["date"]);
			$tournament->setTime($_POST["time"]);
			$tournament->setId_space($_POST["space"]);
			$tournament->setPrice($_POST["price"]);

			try {
				// validate tournament object
				$tournament->validateEvent(); // if it fails, ValidationException

				$this->tournamentMapper->add($tournament);

				$this->view->setFlash(sprintf(i18n("tournament \"%s\" successfully added."),$tournament ->getName()));

				$this->view->redirect("tournaments", "show");

			}catch(ValidationException $ex) {
				// Get the errors array inside the exepction...
				$errors = $ex->getErrors();
				// And put it to the view as "errors" variable
				$this->view->setVariable("errors", $errors);
			}
		}

		//Get the id and name of the spaces
		$spaces = $this->tournamentMapper->getSpaces();
		// Put the space variable visible to the view
		$this->view->setVariable("spaces", $spaces);

		// Put the tournament object visible to the view
		$this->view->setVariable("tournament", $tournament);
		// render the view (/view/tournaments/add.php)
		$this->view->render("tournaments", "add");
	}

	public function update(){
		if (!isset($_REQUEST["id_tournament"])) {
			throw new Exception("A event id is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding users requires login");
		}

		if($this->userMapper->findType() != "admin"){
			throw new Exception("You aren't an admin. Adding an user requires be admin");
		}

		$id_event = $_REQUEST["id_event"];
		$event = $this->eventMapper->view($id_event);

		if ($event == NULL) {
			throw new Exception("no such event with id: ".$id_event);
		}

		if(isset($_POST["submit"])) { // reaching via HTTP user...

			// populate the event object with data form the form
			$event->setName($_POST["name"]);
			$event->setDescription($_POST["description"]);
			$event->setCapacity($_POST["capacity"]);
			$event->setDate($_POST["date"]);
			$event->setTime($_POST["time"]);
			$event->setId_space($_POST["space"]);
			$event->setPrice($_POST["price"]);

			try {
				// validate user object
				$event->validateEvent(); // if it fails, ValidationException

				$this->eventMapper->update($event);

				$this->view->setFlash(sprintf(i18n("Event \"%s\" successfully updated."),$event ->getName()));

				$this->view->redirect("events", "show");

			}catch(ValidationException $ex) {
				// Get the errors array inside the exepction...
				$errors = $ex->getErrors();
				// And put it to the view as "errors" variable
				$this->view->setVariable("errors", $errors);
			}
		}

		//Get the id and name of the spaces
		$spaces = $this->eventMapper->getSpaces();
		// Put the space variable visible to the view
		$this->view->setVariable("spaces", $spaces);

		// Put the user object visible to the view
		$this->view->setVariable("event", $event);
		// render the view (/view/users/add.php)
		$this->view->render("events", "update");
	}

	public function delete() {

		if (!isset($_REQUEST["id_event"])) {
			throw new Exception("A event id is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding events requires login");
		}

		if($this->userMapper->findType() != "admin"){
			throw new Exception("You aren't an admin. Adding a event requires be admin");
		}

		// Get the User object from the database
		$id_event = $_REQUEST["id_event"];
		$event = $this->eventMapper->view($id_event);

		// Does the event exist?
		if ($event == NULL) {
			throw new Exception("no such user with id_user: ".$id_event);
		}

		if (isset($_POST["submit"])) {

			try {
				// Delete the Post object from the database
				$this->eventMapper->delete($event);

				// POST-REDIRECT-GET
				// Everything OK, we will redirect the user to the list of posts
				// We want to see a message after redirection, so we establish
				// a "flash" message (which is simply a Session variable) to be
				// get in the view after redirection.
				$this->view->setFlash(sprintf(i18n("Event \"%s\" successfully deleted."), $event->getName()));

				// perform the redirection. More or less:
				// header("Location: index.php?controller=posts&action=index")
				// die();
				$this->view->redirect("events", "show");

			}catch(ValidationException $ex) {
				// Get the errors array inside the exepction...
				$errors = $ex->getErrors();
				// And put it to the view as "errors" variable
				$this->view->setVariable("errors", $errors);
			}
		}

		// Put the user object visible to the view
		$this->view->setVariable("event", $event);
		// render the view (/view/users/add.php)
		$this->view->render("events", "delete");

	}*/
}
