<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../model/Course.php");
require_once(__DIR__."/../model/CourseMapper.php");
require_once(__DIR__."/../model/UserMapper.php");

require_once(__DIR__."/../controller/BaseController.php");

/**
* Class UsersController
*
* Controller to login, logout and user registration
*
* @author lipido <lipido@gmail.com>
*/
class CoursesController extends BaseController {

	/**
	* Reference to the UserMapper to interact
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

	public function show(){
		if(!isset($this->currentUser)){
			throw new Exception("Not in session. Show courses requires login");
		}

		$courses = $this->courseMapper->show();

		// put the courses object to the view
		$this->view->setVariable("courses", $courses);

		// render the view (/view/courses/show.php)
		$this->view->render("courses", "show");
	}



	public function view(){
		if (!isset($_GET["id_course"])) {
			throw new Exception("id_course user is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. View Courses requires login");
		}

		$id_course = $_GET["id_course"];

		// find the User object in the database
		$course = $this->courseMapper->view($id_course);

		if ($course == NULL) {
			throw new Exception("no such user with id_course: ".$id_course);
		}

		// put the user object to the view
		$this->view->setVariable("course", $course);

		// render the view (/view/users/view.php)
		$this->view->render("courses", "view");
	}

	public function add(){

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding courses requires login");
		}

		if($this->userMapper->findType() != "admin"){
			throw new Exception("You aren't an admin. Adding an user requires be admin");
		}

		$course = new Course();

		if(isset($_POST["submit"])) { // reaching via HTTP user...

			// populate the user object with data form the form
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
					$this->courseMapper->add($course);
				//}

				$this->view->setFlash(sprintf(i18n("Course \"%s\" successfully added."),$course ->getName()));

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
		$this->view->render("courses", "add");
	}/*

	public function update(){
		if (!isset($_REQUEST["id_user"])) {
			throw new Exception("A id user is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding users requires login");
		}

		if($this->userMapper->findType() != "admin"){
			throw new Exception("You aren't an admin. Adding an user requires be admin");
		}

		$id_user = $_REQUEST["id_user"];
		$user = $this->userMapper->getUser($id_user);

		if ($user == NULL) {
			throw new Exception("no such user with id_user: ".$id_user);
		}

		if(isset($_POST["submit"])) { // reaching via HTTP user...

			// populate the user object with data form the form
			$user->setName($_POST["name"]);
			$user->setSurname($_POST["surname"]);
			$user->setDni($_POST["dni"]);
			$user->setUsername($_POST["username"]);
			$user->setPassword($_POST["password"]);
			$user->setPassword($_POST["repeatpassword"]);

			$user->setTelephone($_POST["telephone"]);
			$user->setBirthdate($_POST["birthdate"]);

			if(isset($_POST["isAdministrator"]) && $_POST["isAdministrator"] == "1"){
				$user->setIs_administrator(1);
			}else{
				$user->setIs_administrator(NULL);
			}
			if(isset($_POST["isTrainer"]) && $_POST["isTrainer"] == "1"){
				$user->setIs_trainer(1);
			}else{
				$user->setIs_trainer(NULL);
			}
			if(isset($_POST["isPupil"]) && $_POST["isPupil"] == "1"){
				$user->setIs_pupil(1);
			}else{
				$user->setIs_pupil(NULL);
			}
			if(isset($_POST["isCompetitor"]) && $_POST["isCompetitor"] == "1"){
				$user->setIs_competitor(1);
			}else{
				$user->setIs_competitor(NULL);
			}

			try {
				// validate user object
				//$user->ValidRegister($_POST["rpass"]); // if it fails, ValidationException

				//if(!$user->userMapper->is_valid_DNI($user->getUsername())){
				//	$this->userMapper->update($user);
				//}else{
					//save the user object into the database
					$this->userMapper->update($user);
				//}

				$this->view->setFlash(sprintf(i18n("User \"%s\" successfully updated."),$user ->getName()));

				$this->view->redirect("users", "show");

			}catch(ValidationException $ex) {
				// Get the errors array inside the exepction...
				$errors = $ex->getErrors();
				// And put it to the view as "errors" variable
				$this->view->setVariable("errors", $errors);
			}
		}

		// Put the user object visible to the view
		$this->view->setVariable("user", $user);
		// render the view (/view/users/add.php)
		$this->view->render("users", "update");
	}*/


	public function delete() {

		if (!isset($_REQUEST["id_course"])) {
			throw new Exception("A id_course is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding users requires login");
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
				$this->view->setFlash(sprintf(i18n("Course \"%s\" successfully deleted."),$course->getName()));

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

	}
}
