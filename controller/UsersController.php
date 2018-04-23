<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/UserMapper.php");

require_once(__DIR__."/../controller/BaseController.php");

/**
* Class UsersController
*
* Controller to login, logout and user CRUD
*
* @author lipido <braisda@gmail.com>
*/
class UsersController extends BaseController {

	/**
	* Reference to the UserMapper to interact
	* with the database
	*
	* @var UserMapper
	*/
	private $userMapper;

	public function __construct() {
		parent::__construct();

		$this->userMapper = new UserMapper();

		// Users controller operates in a "welcome" layout
		// different to the "default" layout where the internal
		// menu is displayed
		//$this->view->setLayout("welcome");
	}

	/**
	* Action to login
	*
	* Logins a user checking its creedentials agains
	* the database
	*
	* When called via GET, it shows the login form
	* When called via POST, it tries to login
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>login: The username (via HTTP POST)</li>
	* <li>passwd: The password (via HTTP POST)</li>
	* </ul>
	*
	* The views are:
	* <ul>
	* <li>posts/login: If this action is reached via HTTP GET (via include)</li>
	* <li>posts/index: If login succeds (via redirect)</li>
	* <li>users/login: If validation fails (via include). Includes these view variables:</li>
	* <ul>
	*	<li>errors: Array including validation errors</li>
	* </ul>
	* </ul>
	*
	* @return void
	*/
	public function login() {
		if (isset($_POST["username"])){ // reaching via HTTP Post...
			//process login form
			if ($this->userMapper->isValidUser($_POST["username"], $_POST["passwd"])) {

				$_SESSION["currentuser"]=$_POST["username"];

				// send user to the restricted area (HTTP 302 code)
				$this->view->redirect("entry", "home");

			}else{
				$errors = array();
				$errors["general"] = "Username is not valid";
				$this->view->setVariable("errors", $errors);
			}
		}

		// render the view (/view/entry/login.php)
		$this->view->render("entry", "login");
	}

	/**
	* Action to logout
	*
	* This action should be called via GET
	*
	* No HTTP parameters are needed.
	*
	* The views are:
	* <ul>
	* <li>users/login (via redirect)</li>
	* </ul>
	*
	* @return void
	*/
	public function logout() {
		session_destroy();

		// perform a redirection. More or less:
		// header("Location: index.php?controller=entry&action=index")
		// die();
		$this->view->redirect("entry", "index");

	}

	public function show(){
		if(!isset($this->currentUser)){
			throw new Exception("Not in session. Show users requires login");
		}

		if($this->userMapper->findType() != "admin" && $this->userMapper->findType() != "trainer"){
			throw new Exception("You aren't an admin or a trainer. See all users requires be admin or trainer");
		}

		$users = $this->userMapper->showAllUsers();

		// put the users object to the view
		$this->view->setVariable("users", $users);

		// render the view (/view/users/show.php)
		$this->view->render("users", "show");
	}

	public function view(){
		if (!isset($_GET["id_user"])) {
			throw new Exception("id user is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. View Users requires login");
		}

		if($this->userMapper->findType() == "athlete"){
			throw new Exception("You aren't an admin or a trainer. View an user requires be admin or trainer");
		}

		$id_user = $_GET["id_user"];

		// find the User object in the database
		$user = $this->userMapper->getUser($id_user);

		if ($user == NULL) {
			throw new Exception("no such user with id: ".$id_user);
		}

		// put the user object to the view
		$this->view->setVariable("user", $user);

		// render the view (/view/users/view.php)
		$this->view->render("users", "view");
	}

	public function add(){

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding users requires login");
		}

		if($this->userMapper->findType() != "admin"){
			throw new Exception("You aren't an admin. Adding an user requires be admin");
		}

		$user = new User();

		if(isset($_POST["submit"])) { // reaching via HTTP user...

			// populate the user object with data form the form
			$user->setName($_POST["name"]);
			$user->setSurname($_POST["surname"]);
			$user->setDni($_POST["dni"]);
			$user->setUsername($_POST["username"]);
			$user->setPassword($_POST["password"]);
			$user->setTelephone($_POST["telephone"]);
			$user->setBirthdate($_POST["birthdate"]);

			$directory = 'multimedia/images/users/';
			$imageType = $_FILES['image']['type'];
			$imageName = $_FILES['image']['name'];
			$imageSize = $_FILES['image']['size'];
			$user->setImage($directory.$_FILES['image']['name']);

			if(isset($_POST["isAdministrator"]) && $_POST["isAdministrator"] == "1"){
				$user->setIs_administrator(1);
			}
			if(isset($_POST["isTrainer"]) && $_POST["isTrainer"] == "1"){
				$user->setIs_trainer(1);
			}
			if(isset($_POST["isPupil"]) && $_POST["isPupil"] == "1"){
				$user->setIs_pupil(1);
			}
			if(isset($_POST["isCompetitor"]) && $_POST["isCompetitor"] == "1"){
				$user->setIs_competitor(1);
			}

			try {
				// check if user exists in the database
				if(!$this->userMapper->usernameExists($_POST["username"])){
					// validate user object
					$user->validateUser($_POST["password"], $_POST["repeatpassword"], $imageType, $imageType, $imageSize, true, true); // if it fails, ValidationException

					//up the image to the server
					move_uploaded_file($_FILES['image']['tmp_name'],$directory.$imageName);

					//save the user object into the database
					$this->userMapper->add($user);

					// POST-REDIRECT-GET
					// Everything OK, we will redirect the user to the list of posts
					// We want to see a message after redirection, so we establish
					// a "flash" message (which is simply a Session variable) to be
					// get in the view after redirection.
					$this->view->setFlash(sprintf(i18n("User \"%s\" successfully added."),$user ->getName()));

					// perform the redirection. More or less:
					// header("Location: index.php?controller=users&action=show")
					// die();
					$this->view->redirect("users", "show");
				} else {
					$errors = array();
					$errors["email"] = "Username already exists";
					$this->view->setVariable("errors", $errors);
				}
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
		$this->view->render("users", "add");
	}

	public function update(){
		if (!isset($_REQUEST["id_user"])) {
			throw new Exception("A id user is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Update users requires login");
		}

		if($this->userMapper->findType() != "admin"){
			throw new Exception("You aren't an admin. Update an user requires be admin");
		}

		$id_user = $_REQUEST["id_user"];
		$user = $this->userMapper->getUser($id_user);

		if ($user == NULL) {
			throw new Exception("no such user with id: ".$id_user);
		}

		if(isset($_POST["submit"])) { // reaching via HTTP user...

			// populate the user object with data form the form
			$user->setName($_POST["name"]);
			$user->setSurname($_POST["surname"]);
			$user->setDni($_POST["dni"]);
			$user->setUsername($_POST["username"]);
			if(isset($_POST["password"]) && $_POST["password"] != ""){
				$user->setPassword(md5($_POST["password"]));
				$checkPassword = true;
			}else{
				$checkPassword = false;
			}

			$user->setTelephone($_POST["telephone"]);
			$user->setBirthdate($_POST["birthdate"]);
			$directory = 'multimedia/images/users/';

			$imageType = $_FILES['image']['type'];
			$imageName = $_FILES['image']['name'];
			$imageSize = $_FILES['image']['size'];
			if($_FILES['image']['name'] != NULL){
				$user->setImage($directory.$_FILES['image']['name']);
				$checkImage = true;
			}else{
				$checkImage = false;
			}

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
					$user->validateUser($_POST["password"], $_POST["repeatpassword"], $imageName, $imageType, $imageSize, $checkPassword, $checkImage); // if it fails, ValidationException

					//up the image to the server
					move_uploaded_file($_FILES['image']['tmp_name'],$directory.$imageName);

					//save the user object into the database
					$this->userMapper->update($user);

					// POST-REDIRECT-GET
					// Everything OK, we will redirect the user to the list of posts
					// We want to see a message after redirection, so we establish
					// a "flash" message (which is simply a Session variable) to be
					// get in the view after redirection.
					$this->view->setFlash(sprintf(i18n("User \"%s\" successfully updated."),$user ->getName()));

					// perform the redirection. More or less:
					// header("Location: index.php?controller=users&action=show")
					// die();
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
	}


	public function delete() {

		if (!isset($_REQUEST["id_user"])) {
			throw new Exception("A id_user is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding users requires login");
		}

		if($this->userMapper->findType() != "admin"){
			throw new Exception("You aren't an admin. Adding an user requires be admin");
		}

		// Get the User object from the database
		$id_user = $_REQUEST["id_user"];
		$user = $this->userMapper->getUser($id_user);

		// Does the user exist?
		if ($user == NULL) {
			throw new Exception("no such user with id: ".$id_user);
		}

		if (isset($_POST["submit"])) {

			try {
				// Delete the User object from the database
				$this->userMapper->delete($user);

				// POST-REDIRECT-GET
				// Everything OK, we will redirect the user to the list of posts
				// We want to see a message after redirection, so we establish
				// a "flash" message (which is simply a Session variable) to be
				// get in the view after redirection.
				$this->view->setFlash(sprintf(i18n("User \"%s\" successfully deleted."),$user->getName()));

				// perform the redirection. More or less:
				// header("Location: index.php?controller=users&action=index")
				// die();
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
		$this->view->render("users", "delete");

	}

	public function search() {
		if(!isset($this->currentUser)){
			throw new Exception("Not in session. Show users requires login");
		}

		if($this->userMapper->findType() != "admin" && $this->userMapper->findType() != "trainer"){
			throw new Exception("You aren't an admin or a trainer. See all users requires be admin or trainer");
		}

		if (isset($_POST["submit"])) {
			$query = "";
			$flag = 0;

			if ($_POST["name"]){
				$query .= "name='". $_POST["name"]."'";
				$flag = 1;
			}

			if ($_POST["surname"]){
				if ($flag){
				$query .= " AND ";
				}
				$query .= "surname LIKE '%". $_POST["surname"] ."%'";
				$flag = 1;
			}

			if ($_POST["dni"]){
				if ($flag){
					$query .= " AND ";
				}
				$query .= "dni='". $_POST["dni"]."'";
				$flag = 1;
			}

			if ($_POST["username"]){
				if ($flag){
					$query .= " AND ";
				}
				$query .= "username LIKE '%". $_POST["username"] ."%'";
				$flag = 1;
			}

			if ($_POST["telephone"]){
				if ($flag){
					$query .= " AND ";
				}
				$query .= "telephone LIKE '%". $_POST["telephone"] ."%'";
				$flag = 1;
			}

			if ($_POST["birthdate"]){
				if ($flag){
					$query .= " AND ";
				}
				$query .= "birthdate LIKE '%". $_POST["birthdate"] ."%'";
				$flag = 1;
			}

			if (isset($_POST["isAdministrator"])){
				if ($flag){
					$query .= " AND ";
				}
				$query .= "is_administrator='". $_POST["isAdministrator"] ."'";
				$flag = 1;
			}

			if (isset($_POST["isTrainer"])){
				if ($flag){
					$query .= " AND ";
					}
				$query .= "is_trainer='". $_POST["isTrainer"] ."'";
				$flag = 1;
			}

			if (isset($_POST["isPupil"])){
				if ($flag){
					$query .= " AND ";
				}
				$query .= "is_pupil='". $_POST["isPupil"] ."'";
				$flag = 1;
			}

			if (isset($_POST["isCompetitor"])){
				if ($flag){
					$query .= " AND ";
				}
				$query .= "is_competitor='". $_POST["isCompetitor"] ."'";
				$flag = 1;
			}

			if (empty($query)) {
				$users = $this->userMapper->showAllUsers();
			} else {
				$users = $this->userMapper->search($query);
			}
			$this->view->setVariable("users", $users);
			$this->view->render("users", "show");
		}else {
			// render the view (/view/users/add.php)
			$this->view->render("users", "search");
		}
	}
}
