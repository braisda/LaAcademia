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
* @author lipido <lipido@gmail.com>
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

	public function show(){
		if(!isset($this->currentUser)){
			throw new Exception("Not in session. Show events requires login");
		}

		$events = $this->eventMapper->show();

		// put the events object to the view
		$this->view->setVariable("events", $events);

		// render the view (/view/events/show.php)
		$this->view->render("events", "show");
	}

	public function view(){
		if (!isset($_GET["id_event"])) {
			throw new Exception("Event id is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. View Events requires login");
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
				// validate event object
				//$user->ValidRegister($_POST["rpass"]); // if it fails, ValidationException

				//if(!$user->userMapper->is_valid_DNI($user->getUsername())){
				//	$this->userMapper->update($user);
				//}else{
					//save the user object into the database
					$this->eventMapper->add($event);
				//}

				$this->view->setFlash(sprintf(i18n("Event \"%s\" successfully added."),$event ->getName()));

				$this->view->redirect("events", "show");

			}catch(ValidationException $ex) {
				// Get the errors array inside the exepction...
				$errors = $ex->getErrors();
				// And put it to the view as "errors" variable
				$this->view->setVariable("errors", $errors);
			}
		}

		$spaces = $this->eventMapper->getSpaces();
		$this->view->setVariable("spaces", $spaces);

		// Put the event object visible to the view
		$this->view->setVariable("event", $event);
		// render the view (/view/events/add.php)
		$this->view->render("events", "add");
	}
/*
	public function update(){
		if (!isset($_REQUEST["id_event"])) {
			throw new Exception("A event id is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding users requires login");
		}

		if($this->userMapper->findType() != "admin"){
			throw new Exception("You aren't an admin. Adding an user requires be admin");
		}

		$id_course = $_REQUEST["id_course"];
		$course = $this->courseMapper->view($id_course);

		if ($course == NULL) {
			throw new Exception("no such course with id_course: ".$id_course);
		}

		if(isset($_POST["submit"])) { // reaching via HTTP user...

			// populate the course object with data form the form
			$course->setName($_POST["name"]);
			$course->setType($_POST["type"]);
			$course->setDescription($_POST["description"]);
			$course->setCapacity($_POST["capacity"]);
			$course->setDays($_POST["days"]);
			$course->setStart_time($_POST["start_time"]);
			$course->setEnd_time($_POST["end_time"]);

			try {
				// validate user object
				//$user->ValidRegister($_POST["rpass"]); // if it fails, ValidationException

				//if(!$user->userMapper->is_valid_DNI($user->getUsername())){
				//	$this->userMapper->update($user);
				//}else{
					//save the user object into the database
					$this->courseMapper->update($course);
				//}

				$this->view->setFlash(sprintf(i18n("Course \"%s\" successfully updated."),$course ->getName()));

				$this->view->redirect("courses", "show");

			}catch(ValidationException $ex) {
				// Get the errors array inside the exepction...
				$errors = $ex->getErrors();
				// And put it to the view as "errors" variable
				$this->view->setVariable("errors", $errors);
			}
		}

		// Put the user object visible to the view
		$this->view->setVariable("course", $course);
		// render the view (/view/users/add.php)
		$this->view->render("courses", "update");
	}


	public function delete() {

		if (!isset($_REQUEST["id_course"])) {
			throw new Exception("A id_course is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding courses requires login");
		}

		if($this->userMapper->findType() != "admin"){
			throw new Exception("You aren't an admin. Adding a course requires be admin");
		}

		// Get the User object from the database
		$id_course = $_REQUEST["id_course"];
		$course = $this->courseMapper->view($id_course);

		// Does the course exist?
		if ($course == NULL) {
			throw new Exception("no such user with id_user: ".$id_course);
		}

		if (isset($_POST["submit"])) {

			try {
				// Delete the Post object from the database
				$this->courseMapper->delete($course);

				// POST-REDIRECT-GET
				// Everything OK, we will redirect the user to the list of posts
				// We want to see a message after redirection, so we establish
				// a "flash" message (which is simply a Session variable) to be
				// get in the view after redirection.
				$this->view->setFlash(sprintf(i18n("Course \"%s\" successfully deleted."), $course->getName()));

				// perform the redirection. More or less:
				// header("Location: index.php?controller=posts&action=index")
				// die();
				$this->view->redirect("courses", "show");

			}catch(ValidationException $ex) {
				// Get the errors array inside the exepction...
				$errors = $ex->getErrors();
				// And put it to the view as "errors" variable
				$this->view->setVariable("errors", $errors);
			}
		}

		// Put the user object visible to the view
		$this->view->setVariable("course", $course);
		// render the view (/view/users/add.php)
		$this->view->render("courses", "delete");

	}*/
}
