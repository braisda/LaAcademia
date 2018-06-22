<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../model/Event.php");
require_once(__DIR__."/../model/EventMapper.php");
require_once(__DIR__."/../model/UserMapper.php");

require_once(__DIR__."/../controller/BaseController.php");

/**
* Class EventsController
*
* Controller to events CRUD
*
* @author braisda <braisda@gmail.com>
*/
class EventsController extends BaseController {

	/**
	* Reference to the EventMapper to interact
	* with the database
	*
	* @var EventMapper
	*/
	private $eventMapper;
  private $userMapper;

	public function __construct() {
		parent::__construct();

		$this->eventMapper = new EventMapper();
    $this->userMapper = new UserMapper();
	}

	/**
	* Action to list events
	*
	* Loads all the events from the database.
	* No HTTP parameters are needed.
	*
	*/
	public function show(){
		if(!isset($this->currentUser)){
			throw new Exception("Not in session. Show events requires login");
		}

		if($this->userMapper->findType() != "admin" && $this->userMapper->findType() != "trainer"
      && $this->userMapper->findType() != "pupil" && $this->userMapper->findType() != "competitor"){
			throw new Exception("You aren't an admin, a trainer, a pupil or a competitor. See all notifications requires be admin, trainer, pupil or competitor");
		}

		$events = $this->eventMapper->show();

		// put the events object to the view
		$this->view->setVariable("events", $events);

		// render the view (/view/events/show.php)
		$this->view->render("events", "show");
	}

	/**
	* Action to view a provided event
	*
	* This action should only be called via GET
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>id: Id of the event (via HTTP GET)</li>
	* </ul>
	*
	* @throws Exception If no such user of the provided id is found
	* @return void
	*
	*/
	public function view(){
		if (!isset($_GET["id_event"])) {
			throw new Exception("Event id is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. View Events requires login");
		}

		if($this->userMapper->findType() != "admin" && $this->userMapper->findType() != "trainer"
      && $this->userMapper->findType() != "pupil" && $this->userMapper->findType() != "competitor"){
			throw new Exception("You aren't an admin, a trainer, a pupil or a competitor. See all notifications requires be admin, trainer, pupil or competitor");
		}

		$id_event = $_GET["id_event"];

		// find the Event object in the database
		$event = $this->eventMapper->view($id_event);

		if ($event == NULL) {
			throw new Exception("No such event with id: ".$id_event);
		}

		// put the event object to the view
		$this->view->setVariable("event", $event);

		// render the view (/view/events/view.php)
		$this->view->render("events", "view");
	}

	/**
	* Action to add a new event
	*
	* When called via GET, it shows the add form
	* When called via POST, it adds the user to the database
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>name: Name of the event (via HTTP POST)</li>
	* <li>description: Description of the event (via HTTP POST)</li>
	* <li>price: Price of the event (via HTTP POST)</li>
	* <li>capacity: Capacity of the event (via HTTP POST)</li>
	* <li>date: Date of the event (via HTTP POST)</li>
	* <li>time: Time of the event (via HTTP POST)</li>
	* <li>space: Space of the event (via HTTP POST)</li>
	* </ul>
	*
	* @throws Exception if no user is in session
	* @throws Exception if the type is not admin
	* @return void
	*/
	public function add(){

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding events requires login");
		}

		if($this->userMapper->findType() != "admin"){
			throw new Exception("You aren't an admin. Adding an event requires be admin");
		}

		$event = new event();

		if(isset($_POST["submit"])) { // reaching via HTTP event...

			// populate the event object with data form the form
			$event->setName($_POST["name"]);
			$event->setDescription($_POST["description"]);
			$event->setCapacity($_POST["capacity"]);
			$event->setDate($_POST["date"]);
			$event->setTime($_POST["time"]);
			$event->setId_space($_POST["space"]);
			$event->setPrice($_POST["price"]);

			try {
				// check if space exists in the database
				if(!$this->eventMapper->eventExists($_POST["name"])){
					// validate event object
					$event->validateEvent(); // if it fails, ValidationException

					$this->eventMapper->add($event);
					// POST-REDIRECT-GET
					// Everything OK, we will redirect the user to the list of posts
					// We want to see a message after redirection, so we establish
					// a "flash" message (which is simply a Session variable) to be
					// get in the view after redirection.
					$this->view->setFlash(sprintf(i18n("Event \"%s\" successfully added."),$event ->getName()));

					// perform the redirection. More or less:
					// header("Location: index.php?controller=events&action=show")
					// die();
					$this->view->redirect("events", "show");
				} else {
					$errors = array();
					$errors["name"] = "Event already exists";
					$this->view->setVariable("errors", $errors);
				}
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

		// Put the event object visible to the view
		$this->view->setVariable("event", $event);
		// render the view (/view/events/add.php)
		$this->view->render("events", "add");
	}

	/**
	* Action to edit an event
	*
	* When called via GET, it shows the add form
	* When called via POST, it modifies the event in the database.
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>name: Name of the event (via HTTP POST)</li>
	* <li>description: Description of the event (via HTTP POST)</li>
	* <li>price: Price of the event (via HTTP POST)</li>
	* <li>capacity: Capacity of the event (via HTTP POST)</li>
	* <li>date: Date of the event (via HTTP POST)</li>
	* <li>time: Time of the event (via HTTP POST)</li>
	* <li>space: Space of the event (via HTTP POST)</li>
	* </ul>
	*
	* @throws Exception if no user is in session
	* @throws Exception if a user id is not provided
	* @throws Exception if the type is not admin
	* @throws Exception if there is not any event with the provided id
	* @return void
	*/
	public function update(){
		if (!isset($_REQUEST["id_event"])) {
			throw new Exception("A event id is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding users requires login");
		}

		if($this->userMapper->findType() != "admin" && $this->userMapper->findType() != "trainer"){
			throw new Exception("You aren't an admin or trainer. Adding an user requires be admin or trainer");
		}

		$id_event = $_REQUEST["id_event"];
		$event = $this->eventMapper->view($id_event);

		if ($event == NULL) {
			throw new Exception("no such event with id: ".$id_event);
		}

		if(isset($_POST["submit"])) { // reaching via HTTP user...

			// populate the event object with data form the form

			// put the flag to true if the user changes the space name
			$flag = false;
			if($event->getName() != $_POST["name"]){
				$flag = true;
			}

			$event->setName($_POST["name"]);
			$event->setDescription($_POST["description"]);
			$event->setCapacity($_POST["capacity"]);
			$event->setDate($_POST["date"]);
			$event->setTime($_POST["time"]);
			$event->setId_space($_POST["space"]);
			$event->setPrice($_POST["price"]);

			try {
				// check if space exists in the database
				if(!$flag){
					// validate user object
					$event->validateEvent(); // if it fails, ValidationException

					$this->eventMapper->update($event);

					// POST-REDIRECT-GET
					// Everything OK, we will redirect the user to the list of posts
					// We want to see a message after redirection, so we establish
					// a "flash" message (which is simply a Session variable) to be
					// get in the view after redirection.
					$this->view->setFlash(sprintf(i18n("Event \"%s\" successfully updated."),$event ->getName()));

					// perform the redirection. More or less:
					// header("Location: index.php?controller=events&action=show")
					// die();
					$this->view->redirect("events", "show");
				} else if($flag && !$this->eventMapper->eventExists($_POST["name"])){
					$event->validateEvent(); // if it fails, ValidationException

					$this->eventMapper->update($event);

					// POST-REDIRECT-GET
					// Everything OK, we will redirect the user to the list of posts
					// We want to see a message after redirection, so we establish
					// a "flash" message (which is simply a Session variable) to be
					// get in the view after redirection.
					$this->view->setFlash(sprintf(i18n("Event \"%s\" successfully updated."),$event ->getName()));

					// perform the redirection. More or less:
					// header("Location: index.php?controller=events&action=show")
					// die();
					$this->view->redirect("events", "show");
				} else {
					$errors = array();
					$errors["name"] = "Name already exists";
					$this->view->setVariable("errors", $errors);
				}

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

	/**
	* Action to delete an event
	*
	* This action should only be called via HTTP POST
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>id: Id of the event (via HTTP POST)</li>
	* </ul>
	*
	* @throws Exception if no user is in session
	* @throws Exception if a user id is not provided
	* @throws Exception if the type is not admin
	* @throws Exception if there is not any event with the provided id
	* @return void
	*/
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
				// header("Location: index.php?controller=events&action=show")
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
	}

	/**
	* Action to list events that match a search pattern
	*
	* This action should only be called via HTTP POST
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>name: Name of the event (via HTTP POST)</li>
	* <li>description: Description of the event (via HTTP POST)</li>
	* <li>price: Price of the event (via HTTP POST)</li>
	* <li>capacity: Capacity of the event (via HTTP POST)</li>
	* <li>date: Date of the event (via HTTP POST)</li>
	* <li>time: Time of the event (via HTTP POST)</li>
	* <li>space: Space of the event (via HTTP POST)</li>
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

		if($this->userMapper->findType() != "admin" && $this->userMapper->findType() != "trainer"
      && $this->userMapper->findType() != "pupil" && $this->userMapper->findType() != "competitor"){
			throw new Exception("You aren't an admin, a trainer, a pupil or a competitor. See all notifications requires be admin, trainer, pupil or competitor");
		}

		if (isset($_POST["submit"])) {
			$query = "";
			$flag = 0;

			if ($_POST["name"]){
				$query .= "name LIKE '%". $_POST["name"]."%'";
				$flag = 1;
			}

			if ($_POST["description"]){
				if ($flag){
				$query .= " AND ";
				}
				$query .= "description LIKE '%". $_POST["description"] ."%'";
				$flag = 1;
			}

			if ($_POST["price"]){
				if ($flag){
					$query .= " AND ";
				}
				$query .= "price='". $_POST["price"]."'";
				$flag = 1;
			}

			if ($_POST["capacity"]){
				if ($flag){
					$query .= " AND ";
				}
				$query .= "capacity='". $_POST["capacity"]."'";
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

			if ($_POST["space"]){
				if ($flag){
					$query .= " AND ";
				}
				$query .= "id_space='". $_POST["space"]."'";
				$flag = 1;
			}

			if (empty($query)) {
				$events = $this->eventMapper->show();
			} else {
				$events = $this->eventMapper->search($query);
			}
			$this->view->setVariable("events", $events);
			$this->view->render("events", "show");
		}else {
			//Get the id and name of the spaces
			$spaces = $this->eventMapper->getSpaces();
			// Put the space variable visible to the view
			$this->view->setVariable("spaces", $spaces);

			// render the view (/view/events/search.php)
			$this->view->render("events", "search");
		}
	}
}
