<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../model/CourseReservation.php");
require_once(__DIR__."/../model/CourseReservationMapper.php");
require_once(__DIR__."/../model/UserMapper.php");

require_once(__DIR__."/../controller/BaseController.php");

/**
* Class CourseReservationsController
*
* Controller to course reservation CRUD
*
* @author braisda <braisda@gmail.com>
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

	/**
	* Action to list course reservations
	*
	* Loads all the course reservations from the database.
	* No HTTP parameters are needed.
	*
	*/
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

	/**
	* Action to view a provided course reservation
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

	/**
	* Action to add a new course reservation
	*
	* When called via GET, it shows the add form
	* When called via POST, it adds the reservation to the database
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>date: Date of the reservation (via HTTP POST)</li>
	* <li>time: Time of the reservation (via HTTP POST)</li>
	* <li>is_confirmed: Surnme of the reservation (via HTTP POST)</li>
	* <li>id_pupil: Pupil id of the reservation (via HTTP POST)</li>
	* <li>id_course: Course id of the reservation (via HTTP POST)</li>
	* </ul>
	*
	* @throws Exception if no user is in session
	* @throws Exception if the type is not admin
	* @throws Exception if there is not any course with the provided id
	* @return void
	*/
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
			$reservation->setTime(date("H:i:sa"));
			$reservation->setIs_confirmed(0);
			$reservation->setId_pupil($id_user);
			$reservation->setId_course($id_course);

			try {
				// check if reservation exists in the database
				if(!$this->courseReservationMapper->reservationExists($id_user, $id_course)){
					//save the course object into the database
					$this->courseReservationMapper->add($reservation);

					// POST-REDIRECT-GET
					// Everything OK, we will redirect the user to the list of posts
					// We want to see a message after redirection, so we establish
					// a "flash" message (which is simply a Session variable) to be
					// get in the view after redirection.
					$this->view->setFlash(sprintf(i18n("Course reservation \"%s at %s\" successfully added."), $reservation->getDate(), $reservation->getTime()));

					// perform the redirection. More or less:
					// header("Location: index.php?controller=courseReservations&action=show")
					// die();
					$this->view->redirect("courseReservations", "show");
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
		// put the course object to the view
		$this->view->setVariable("course", $course);

		// render the view (/view/courses/add.php)
		$this->view->render("courseReservations", "add");
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
		$reservation = $this->courseReservationMapper->view($id_reservation);

		if ($reservation == NULL) {
			throw new Exception("no such reservation with id: ".$id_reservation);
		}

		try {

			//save the reservation object into the database
			$this->courseReservationMapper->cancel($reservation);

			$this->view->setFlash(sprintf(i18n("Reservation \"%s at %s\" successfully cancelled."),$reservation->getDate(), $reservation->getTime()));

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

	/**
	* Action to delete a course reservation
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

	/**
	* Action to list reservations that match a search pattern
	*
	* This action should only be called via HTTP POST
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>id_pupil: Pupil id of the reservation (via HTTP POST)</li>
	* <li>id_course: Course id of the reservation (via HTTP POST)</li>
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

		if($this->userMapper->findType() != "admin" && $this->userMapper->findType() != "pupil"){
			throw new Exception("You aren't an admin or a trainer. Search reservations requires be admin or trainer");
		}

		if (isset($_POST["submit"])) {
			$query = "";
			$flag = 0;
			if($this->userMapper->findType() == "admin"){
				if ($_POST["pupil"]){
					if ($flag){
						$query .= " AND ";
					}
					$query .= "id_pupil='". $_POST["pupil"]."'";
					$flag = 1;
				}
			}

			if ($_POST["course"]){
				if ($flag){
					$query .= " AND ";
				}
				$query .= "id_course='". $_POST["course"]."'";
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

			if($this->userMapper->findType() == "pupil"){
				$id = $this->courseReservationMapper->getId_user($_SESSION["currentuser"]);
				if ($flag){
					$query .= " AND ";
				}
				$query .= "id_pupil='".$id."'";
				$flag = 1;
			}

			if (empty($query)) {
				if($this->userMapper->findType() == "admin"){
					$reservations = $this->courseReservationMapper->show();
				}else{
					$reservations = $this->courseReservationMapper->showMine($this->courseReservationMapper->getId_user($_SESSION["currentuser"]));
				}
			} else {
				$reservations = $this->courseReservationMapper->search($query);
			}
			//Get the id, name and surname of the pupils
			$pupils = $this->courseReservationMapper->getPupils();

			// Put the space variable visible to the view
			$this->view->setVariable("pupils", $pupils);

	    //Get the id, name and type of the courses
			$courses = $this->courseReservationMapper->getCourses();

			// Put the course variable visible to the view
			$this->view->setVariable("courses", $courses);

			$this->view->setVariable("courseReservation", $reservations);
			$this->view->render("courseReservations", "show");
		}else {
			//Get the id, name and surname of the pupils
			$pupils = $this->courseReservationMapper->getPupils();

			// Put the space variable visible to the view
			$this->view->setVariable("pupils", $pupils);

	    //Get the id, name and type of the courses
			$courses = $this->courseReservationMapper->getCourses();

			// Put the course variable visible to the view
			$this->view->setVariable("courses", $courses);

			// render the view (/view/courseReservations/search.php)
			$this->view->render("courseReservations", "search");
		}
	}
}
