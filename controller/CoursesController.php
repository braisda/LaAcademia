<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../model/Course.php");
require_once(__DIR__."/../model/CourseMapper.php");
require_once(__DIR__."/../model/UserMapper.php");

require_once(__DIR__."/../controller/BaseController.php");

/**
* Class CoursesController
*
* Controller to courses CRUD
*
* @author braisda <braisda@gmail.com>
*/
class CoursesController extends BaseController {

	/**
	* Reference to the CourseMapper to interact
	* with the database
	*
	* @var CourseMapper
	*/
	private $courseMapper;
  private $userMapper;

	public function __construct() {
		parent::__construct();

		$this->courseMapper = new CourseMapper();
    $this->userMapper = new UserMapper();
	}

	/**
	* Action to list courses
	*
	* Loads all the courses from the database.
	* No HTTP parameters are needed.
	*
	*/
	public function show(){
		if(!isset($this->currentUser)){
			throw new Exception("Not in session. Show courses requires login");
		}

		if($this->userMapper->findType() == "competitor"){
			throw new Exception("You aren't an admin, a trainer or a pupil. See all spaces requires be admin, trainer or pupil");
		}

		$courses = $this->courseMapper->show();

		// put the courses object to the view
		$this->view->setVariable("courses", $courses);

		// render the view (/view/courses/show.php)
		$this->view->render("courses", "show");
	}

	/**
	* Action to view a provided course
	*
	* This action should only be called via GET
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>id: Id of the course (via HTTP GET)</li>
	* </ul>
	*
	* @throws Exception If no such course of the provided id is found
	* @return void
	*
	*/
	public function view(){
		if (!isset($_GET["id_course"])) {
			throw new Exception("id is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. View Courses requires login");
		}

		if($this->userMapper->findType() == "competitor"){
			throw new Exception("You aren't an admin, a trainer or a pupil. See all spaces requires be admin, trainer or pupil");
		}

		$id_course = $_GET["id_course"];

		// find the Course object in the database
		$course = $this->courseMapper->view($id_course);

		if ($course == NULL) {
			throw new Exception("no such course with id: ".$id_course);
		}

		// put the course object to the view
		$this->view->setVariable("course", $course);

		// render the view (/view/courses/view.php)
		$this->view->render("courses", "view");
	}

	/**
	* Action to add a new course
	*
	* When called via GET, it shows the add form
	* When called via POST, it adds the user to the database
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>name: Name of the course (via HTTP POST)</li>
	* <li>type: Type of the course (via HTTP POST)</li>
	* <li>description: Description of the course (via HTTP POST)</li>
	* <li>capacity: Capacity of the course (via HTTP POST)</li>
	* <li>days: Days of the course (via HTTP POST)</li>
	* <li>start_time: Start time of the course (via HTTP POST)</li>
	* <li>end_time: End time of the course (via HTTP POST)</li>
	* <li>id_space: Space id of the course (via FILES POST)</li>
	* <li>id_trainer: Trainer id of the course (via FILES POST)</li>
	* <li>price: Price of the course (administrator) (via HTTP POST)</li>
	* </ul>
	*
	* @throws Exception if no user is in session
	* @throws Exception if the type is not admin
	* @return void
	*/
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
				// check if space exists in the database
				if(!$this->courseMapper->courseExists($_POST["name"], $_POST["type"])){
					//validate course object
					$course->ValidateCourse(); // if it fails, ValidationException

					//save the course object into the database
					$this->courseMapper->add($course);

					// POST-REDIRECT-GET
					// Everything OK, we will redirect the user to the list of posts
					// We want to see a message after redirection, so we establish
					// a "flash" message (which is simply a Session variable) to be
					// get in the view after redirection.
					$this->view->setFlash(sprintf(i18n("Course \"%s\" successfully added."),$course ->getName()));

					// perform the redirection. More or less:
					// header("Location: index.php?controller=courses&action=show")
					// die();
					$this->view->redirect("courses", "show");
				} else {
					$errors = array();
					$errors["name"] = "Course already exists";
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

	/**
	* Action to edit a course
	*
	* When called via GET, it shows the add form
	* When called via POST, it modifies the user in the database.
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>name: Name of the course (via HTTP POST)</li>
	* <li>type: Type of the course (via HTTP POST)</li>
	* <li>description: Description of the course (via HTTP POST)</li>
	* <li>capacity: Capacity of the course (via HTTP POST)</li>
	* <li>days: Days of the course (via HTTP POST)</li>
	* <li>start_time: Start time of the course (via HTTP POST)</li>
	* <li>end_time: End time of the course (via HTTP POST)</li>
	* <li>id_space: Space id of the course (via FILES POST)</li>
	* <li>id_trainer: Trainer id of the course (via FILES POST)</li>
	* <li>price: Price of the course (administrator) (via HTTP POST)</li>
	* </ul>
	*
	* @throws Exception if no user is in session
	* @throws Exception if a user id is not provided
	* @throws Exception if the type is not admin
	* @throws Exception if there is not any course with the provided id
	* @return void
	*/
	public function update(){
		if (!isset($_REQUEST["id_course"])) {
			throw new Exception("A id is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Update a course requires login");
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
				// check if space exists in the database
				if(!$this->courseMapper->courseExists($_POST["name"], $_POST["type"])){
					//validate course object
					$course->ValidateCourse(); // if it fails, ValidationException

					//save the course object into the database
					$this->courseMapper->update($course);

					// POST-REDIRECT-GET
					// Everything OK, we will redirect the user to the list of posts
					// We want to see a message after redirection, so we establish
					// a "flash" message (which is simply a Session variable) to be
					// get in the view after redirection.
					$this->view->setFlash(sprintf(i18n("Course \"%s\" successfully updated."),$course ->getName()));

					// perform the redirection. More or less:
					// header("Location: index.php?controller=spaces&action=show")
					// die();
					$this->view->redirect("courses", "show");
				} else {
					$errors = array();
					$errors["name"] = "Course already exists";
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

	/**
	* Action to delete a course
	*
	* This action should only be called via HTTP POST
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>id: Id of the space (via HTTP POST)</li>
	* </ul>
	*
	* @throws Exception if no user is in session
	* @throws Exception if a user id is not provided
	* @throws Exception if the type is not admin
	* @throws Exception if there is not any course with the provided id
	* @return void
	*/
	public function delete() {

		if (!isset($_REQUEST["id_course"])) {
			throw new Exception("A id is mandatory");
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
				// header("Location: index.php?controller=courses&action=show")
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

	}

	/**
	* Action to list courses that match a search pattern
	*
	* This action should only be called via HTTP POST
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>name: Name of the course (via HTTP POST)</li>
	* <li>type: Type of the course (via HTTP POST)</li>
	* <li>id_space: Space id of the course (via HTTP POST)</li>
	* <li>id_trainer: Trainer id of the course (via HTTP POST)</li>
	* <li>days: Days of the course (via HTTP POST)</li>
	* <li>start_time: Start time of the course (via HTTP POST)</li>
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

		if($this->userMapper->findType() != "admin" && $this->userMapper->findType() != "trainer"){
			throw new Exception("You aren't an admin or a trainer. See all spaces requires be admin or trainer");
		}

		if (isset($_POST["submit"])) {
			$query = "";
			$flag = 0;

			if ($_POST["name"]){
				$query .= "name LIKE '%". $_POST["name"]."%'";
				$flag = 1;
			}

			if ($_POST["type"]){
				if ($flag){
					$query .= " AND ";
				}
				$query .= "type='". $_POST["type"]."'";
				$flag = 1;
			}

			if ($_POST["trainer"]){
				if ($flag){
					$query .= " AND ";
				}
				$query .= "id_trainer='". $_POST["trainer"]."'";
				$flag = 1;
			}

			if (isset($_POST["days"])){
				var_dump($_POST["days"]);
				$days = "";
				var_dump($days);
				foreach ($_POST["days"] as $day) {
					$days = $days.",".$day;
				}
				$days = substr($days, 1);
				var_dump($days);

				if ($flag){
					$query .= " AND ";
				}
				$query .= "days LIKE '%". $days ."%'";
				$flag = 1;
			}

			if ($_POST["start_time"]){
				if ($flag){
					$query .= " AND ";
				}
				$query .= "start_time='". $_POST["start_time"]."'";
				$flag = 1;
			}

			if ($_POST["end_time"]){
				if ($flag){
					$query .= " AND ";
				}
				$query .= "end_time='". $_POST["end_time"]."'";
				$flag = 1;
			}

			if ($_POST["space"]){
				if ($flag){
				$query .= " AND ";
				}
				$query .= "id_space LIKE '%". $_POST["space"] ."%'";
				$flag = 1;
			}

			if (empty($query)) {
				$courses = $this->courseMapper->show();
			} else {
				$courses = $this->courseMapper->search($query);
			}
			$this->view->setVariable("courses", $courses);
			$this->view->render("courses", "show");
		}else {
			//Get the id and name of the spaces
			$spaces = $this->courseMapper->getSpaces();

			// Put the space variable visible to the view
			$this->view->setVariable("spaces", $spaces);

			//Get the id and name of the trainers
			$trainers = $this->courseMapper->getTrainers();

			// Put the space variable visible to the view
			$this->view->setVariable("trainers", $trainers);
			// render the view (/view/users/add.php)
			$this->view->render("courses", "search");
		}
	}
}
