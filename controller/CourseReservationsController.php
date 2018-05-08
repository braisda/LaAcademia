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

		if($this->userMapper->findType() != "admin" && $this->userMapper->findType() != "pupil"){
			throw new Exception("You aren't an admin or a pupil. See all reservations requires be admin or pupil");
		}

		//Get the id, name and surname of the pupils
		$pupils = $this->courseReservationMapper->getPupils();

		if($_SESSION["admin"]){
			$reservations = $this->courseReservationMapper->show();
		}else{
			foreach ($pupils as $pupil) {
				if($pupil["email"] == $_SESSION["currentuser"]){
					$id_user = $pupil["id_user"];
				}
			}
			$reservations = $this->courseReservationMapper->showMine($id_user);
		}

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

		if($this->userMapper->findType() != "admin" && $this->userMapper->findType() != "pupil"){
			throw new Exception("You aren't an admin or a pupil. See all reservations requires be admin or pupil");
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

	public function add(){
		if (!isset($_REQUEST["id_course"])) {
			throw new Exception("A id is mandatory");
		}

		$id_course = $_REQUEST["id_course"];

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding course reservation requires login");
		}

		if($this->userMapper->findType() != "pupil"){
			throw new Exception("You aren't a pupil. Adding an course reservation requires be pupil");
		}

		$reservation = new CourseReservation();
		// find the Course object in the database
		$course = $this->courseReservationMapper->getCourse($id_course);
		$id_user = $this->courseReservationMapper->getId_user($_SESSION["currentuser"]);

		if(isset($_POST["submit"])) { // reaching via HTTP course...

			// populate the course reservation object with data
			$reservation->setDate(date("Y/m/d"));
			$reservation->setTime(date("h:i:sa"));
			$reservation->setIs_confirmed(0);
			$reservation->setId_pupil($id_user);
			$reservation->setId_course($id_course);

			try {
				//save the course object into the database
				$this->courseReservationMapper->add($reservation);

				$this->view->setFlash(sprintf(i18n("Course reservation \"%s at %s\" successfully added."), $reservation->getDate(), $reservation->getTime()));

				$this->view->redirect("courseReservations", "show");

			}catch(ValidationException $ex) {
				// Get the errors array inside the exepction...
				$errors = $ex->getErrors();
				// And put it to the view as "errors" variable
				$this->view->setVariable("errors", $errors);
			}
		}
		// put the course object to the view
		$this->view->setVariable("course", $course);

		// render the view (/view/courses/add.php)
		$this->view->render("courseReservations", "add");
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
		$reservation = $this->courseReservationMapper->view($id_reservation);

		if ($reservation == NULL) {
			throw new Exception("no such reservation with id: ".$id_reservation);
		}

		try {
			//save the reservation object into the database
			$this->courseReservationMapper->confirm($reservation);

			$this->view->setFlash(sprintf(i18n("Reservation \"%s at %s\" successfully confirmed."),$reservation->getDate(), $reservation->getTime()));

			$this->view->redirect("courseReservations", "show");

		}catch(ValidationException $ex) {
			// Get the errors array inside the exepction...
			$errors = $ex->getErrors();
			// And put it to the view as "errors" variable
			$this->view->setVariable("errors", $errors);
		}

		// render the view (/view/users/add.php)
		$this->view->render("courseReservations", "show");
	}

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
		$reservation = $this->courseReservationMapper->view($id_reservation);

		if ($reservation == NULL) {
			throw new Exception("no such reservation with id: ".$id_reservation);
		}

		try {

			//save the reservation object into the database
			$this->courseReservationMapper->cancel($reservation);

			$this->view->setFlash(sprintf(i18n("Reservation \"%s at %s\" successfully confirmed."),$reservation->getDate(), $reservation->getTime()));

			$this->view->redirect("courseReservations", "show");

		}catch(ValidationException $ex) {
			// Get the errors array inside the exepction...
			$errors = $ex->getErrors();
			// And put it to the view as "errors" variable
			$this->view->setVariable("errors", $errors);
		}

		// render the view (/view/users/add.php)
		$this->view->render("courseReservations", "show");
	}

	public function delete() {

		if (!isset($_REQUEST["id_reservation"])) {
			throw new Exception("A id is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding courses reservations requires login");
		}

		if($this->userMapper->findType() != "admin" && $this->userMapper->findType() != "pupil"){
			throw new Exception("You aren't an admin. Delete a course reservation requires be admin or pupil");
		}

		// Get the User object from the database
		$id_reservation = $_REQUEST["id_reservation"];
		$reservation = $this->courseReservationMapper->view($id_reservation);

		if($_SESSION["pupil"]){
			if($this->courseReservationMapper->getState($id_reservation) == 1){
				throw new Exception("You can't delete a course reservation which is confirmed");
			}
		}
		// Does the reservation exist?
		if ($reservation == NULL) {
			throw new Exception("no such reservation with id: ".$id_reservation);
		}

		if (isset($_POST["submit"])) {

			try {
				// Delete the CourseReservation object from the database
				$this->courseReservationMapper->delete($reservation);

				// POST-REDIRECT-GET
				// Everything OK, we will redirect the user to the list of posts
				// We want to see a message after redirection, so we establish
				// a "flash" message (which is simply a Session variable) to be
				// get in the view after redirection.
				$this->view->setFlash(sprintf(i18n("Course reservation \"%s at %s\" successfully deleted."), $reservation->getDate(), $reservation->getTime()));

				// perform the redirection. More or less:
				// header("Location: index.php?controller=posts&action=index")
				// die();
				$this->view->redirect("courseReservations", "show");

			}catch(ValidationException $ex) {
				// Get the errors array inside the exepction...
				$errors = $ex->getErrors();
				// And put it to the view as "errors" variable
				$this->view->setVariable("errors", $errors);
			}
		}

    //Get the id, name and surname of the pupils
		$pupils = $this->courseReservationMapper->getPupils();

		// Put the space variable visible to the view
		$this->view->setVariable("pupils", $pupils);

    //Get the id, name and type of the courses
		$courses = $this->courseReservationMapper->getCourses();

		// Put the course variable visible to the view
		$this->view->setVariable("courses", $courses);

		// Put the user object visible to the view
		$this->view->setVariable("courseReservation", $reservation);
		// render the view (/view/courseReservations/delete.php)
		$this->view->render("courseReservations", "delete");

	}
}
