<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../model/CourseReservation.php");
require_once(__DIR__."/../model/CourseReservationMapper.php");
require_once(__DIR__."/../model/UserMapper.php");

require_once(__DIR__."/../controller/BaseController.php");

/**
* Class CoursesController
*
* Controller to courses CRUD
*
* @author lipido <lipido@gmail.com>
*/
class CourseReservationsController extends BaseController {

	/**
	* Reference to the CourseReservationMapper to interact
	* with the database
	*
	* @var CourseReservationMapper
	*/
	private $courseReservationMapper;
  private $userMapper;

	public function __construct() {
		parent::__construct();

		$this->courseReservationMapper = new CourseReservationMapper();
    $this->userMapper = new UserMapper();
	}

	public function show(){
		if(!isset($this->currentUser)){
			throw new Exception("Not in session. Show courses requires login");
		}

		$reservations = $this->courseReservationMapper->show();

    //Get the id, name and surname of the pupils
		$pupils = $this->courseReservationMapper->getPupils();

		// Put the space variable visible to the view
		$this->view->setVariable("pupils", $pupils);

    //Get the id, name and type of the courses
		$courses = $this->courseReservationMapper->getCourses();

		// Put the course variable visible to the view
		$this->view->setVariable("courses", $courses);

		// put the courses object to the view
		$this->view->setVariable("courseReservation", $reservations);

		// render the view (/view/courseReservations/show.php)
		$this->view->render("courseReservations", "show");
	}

	public function view(){
		if (!isset($_GET["id_reservation"])) {
			throw new Exception("id is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. View Courses Reservations requires login");
		}

		$id_reservation = $_GET["id_reservation"];

		// find the Reservation object in the database
		$reservation = $this->courseReservationMapper->view($id_reservation);

		if ($reservation == NULL) {
			throw new Exception("no such course with id: ".$id_reservation);
		}

    //Get the id, name and surname of the pupils
		$pupils = $this->courseReservationMapper->getPupils();

		// Put the space variable visible to the view
		$this->view->setVariable("pupils", $pupils);

    //Get the id, name and type of the courses
		$courses = $this->courseReservationMapper->getCourses();

		// Put the course variable visible to the view
		$this->view->setVariable("courses", $courses);

		// put the course object to the view
		$this->view->setVariable("courseReservation", $reservation);

		// render the view (/view/courseReservations/view.php)
		$this->view->render("courseReservations", "view");
	}
/*
	public function add(){

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding courses requires login");
		}

		if($this->userMapper->findType() != "admin"){
			throw new Exception("You aren't an admin. Adding an course requires be admin");
		}

		$course = new Course();

		if(isset($_POST["submit"])) { // reaching via HTTP course...

			// populate the course object with data form the form
			$course->setName($_POST["name"]);
			$course->setType($_POST["type"]);
			$course->setDescription($_POST["description"]);
			$course->setCapacity($_POST["capacity"]);
			if(isset($_POST["days"])){
				$course->setDays($_POST["days"]);
			}else{
				$course->setDays(NULL);
			}
			$course->setStart_time($_POST["start_time"]);
			$course->setEnd_time($_POST["end_time"]);
			$course->setId_space($_POST["space"]);
			$course->setId_trainer($_POST["trainer"]);
			$course->setPrice($_POST["price"]);

			try {
				//validate course object
				$course->ValidateCourse(); // if it fails, ValidationException

				//save the course object into the database
				$this->courseMapper->add($course);

				$this->view->setFlash(sprintf(i18n("Course \"%s\" successfully added."),$course ->getName()));

				$this->view->redirect("courses", "show");

			}catch(ValidationException $ex) {
				// Get the errors array inside the exepction...
				$errors = $ex->getErrors();
				// And put it to the view as "errors" variable
				$this->view->setVariable("errors", $errors);
			}
		}
		//Get the id and name of the spaces
		$spaces = $this->courseMapper->getSpaces();

		// Put the space variable visible to the view
		$this->view->setVariable("spaces", $spaces);

		//Get the id and name of the trainers
		$trainers = $this->courseMapper->getTrainers();

		// Put the space variable visible to the view
		$this->view->setVariable("trainers", $trainers);

		// Put the course object visible to the view
		$this->view->setVariable("course", $course);
		// render the view (/view/courses/add.php)
		$this->view->render("courses", "add");
	}

	public function update(){
		if (!isset($_REQUEST["id_course"])) {
			throw new Exception("A id_course is mandatory");
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
			$course->setId_space($_POST["space"]);
			$course->setId_trainer($_POST["trainer"]);
			$course->setPrice($_POST["price"]);

			try {
				//validate course object
				$course->ValidateCourse(); // if it fails, ValidationException

				//save the course object into the database
				$this->courseMapper->update($course);

				$this->view->setFlash(sprintf(i18n("Course \"%s\" successfully updated."),$course ->getName()));

				$this->view->redirect("courses", "show");

			}catch(ValidationException $ex) {
				// Get the errors array inside the exepction...
				$errors = $ex->getErrors();
				// And put it to the view as "errors" variable
				$this->view->setVariable("errors", $errors);
			}
		}
		//Get the id and name of the spaces
		$spaces = $this->courseMapper->getSpaces();

		// Put the space variable visible to the view
		$this->view->setVariable("spaces", $spaces);

		//Get the id and name of the trainers
		$trainers = $this->courseMapper->getTrainers();

		// Put the space variable visible to the view
		$this->view->setVariable("trainers", $trainers);

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
