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
			$this->courseReservationMapper->update($reservation);

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

		if($this->userMapper->findType() != "admin"){
			throw new Exception("You aren't an admin. Adding a course reservation requires be admin");
		}

		// Get the User object from the database
		$id_reservation = $_REQUEST["id_reservation"];
		$reservation = $this->courseReservationMapper->view($id_reservation);

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
