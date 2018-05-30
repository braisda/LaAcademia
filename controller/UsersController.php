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
* @author braisda <braisda@gmail.com>
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

		// Users controller operates in a "default" layout
		// You can change the layout:
		//$this->view->setLayout("otherLayout");
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
				$this->view->redirect("users", "home");

			}else{
				$errors = array();
				$errors["general"] = "Username or password are not valid";
				$this->view->setVariable("errors", $errors);
			}
		}

		// render the view (/view/users/login.php)
		$this->view->render("users", "login");
	}

	/**
	* Action to choose the default view
	*
	* If the user is in session (after login), render the home view
	* If the user is not in session (after logout), render the login view
	*
	*/
	public function index() {
		if (isset($_SESSION['currentuser'])){
			$this->view->render("users","home");
		}else{
			$this->view->render("users","login");
		}
	}

	/**
	* Action to access to the restricted area
	*
	* If the user is in session (after login), the user type is especified
	*
	*/
	public function home(){
		if (isset($_SESSION["currentuser"])){
			$this->userMapper = new UserMapper();

			$_SESSION["admin"] = $this->userMapper->isAdmin();
			$_SESSION["trainer"] = $this->userMapper->isTrainer();
			$_SESSION["pupil"] = $this->userMapper->isPupil();
			$_SESSION["competitor"] = $this->userMapper->isCompetitor();
			$_SESSION["pupil_competitor"] = $this->userMapper->isPupilCompetitor();

			$this->view->render("users","home");
		}else{
			//throw new Exception("Not in session. Show menu requires login");
		}
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
		// header("Location: index.php?controller=users&action=index")
		// die();
		$this->view->redirect("users", "index");

	}

	/**
	* Action to list users
	*
	* Loads all the users from the database.
	* No HTTP parameters are needed.
	*
	*/
	public function show(){
		if(!isset($this->currentUser)){
			throw new Exception("Not in session. Show users requires login");
		}

		if($this->userMapper->findType() != "admin" && $this->userMapper->findType() != "trainer"){
			throw new Exception("You aren't an admin or a trainer. See all users requires be admin or trainer");
		}

		$users = $this->userMapper->show();

		// put the users object to the view
		$this->view->setVariable("users", $users);

		// render the view (/view/users/show.php)
		$this->view->render("users", "show");
	}

	/**
	* Action to view a provided user
	*
	* This action should only be called via GET
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>id: Id of the user (via HTTP GET)</li>
	* </ul>
	*
	* @throws Exception If no such user of the provided id is found
	* @return void
	*
	*/
	public function view(){
		if (!isset($_GET["id_user"])) {
			throw new Exception("id user is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. View Users requires login");
		}

		if($this->userMapper->findType() == "pupil" || $this->userMapper->findType() == "competitor"){
			throw new Exception("You aren't an admin or a trainer. View an user requires be admin or trainer");
		}

		$id_user = $_GET["id_user"];

		// find the User object in the database
		$user = $this->userMapper->view($id_user);

		if ($user == NULL) {
			throw new Exception("no such user with id: ".$id_user);
		}

		// put the user object to the view
		$this->view->setVariable("user", $user);

		// render the view (/view/users/view.php)
		$this->view->render("users", "view");
	}

	/**
	* Action to view a provided user
	*
	* This action should only be called via GET
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>username: Username of the user (via HTTP GET)</li>
	* </ul>
	*
	* @throws Exception If no such user of the provided username is found
	* @return void
	*
	*/
	public function viewProfile(){
		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. View Users requires login");
		}

		$username = $this->currentUser->getUsername();

		// find the User object in the database
		$user = $this->userMapper->getProfile($username);

		if ($user == NULL) {
			throw new Exception("no such user with username: ".$username);
		}

		// put the user object to the view
		$this->view->setVariable("user", $user);

		// render the view (/view/users/view.php)
		$this->view->render("users", "view");
	}

	/**
	* Action to add a new user
	*
	* When called via GET, it shows the add form
	* When called via POST, it adds the user to the database
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>name: Name of the user (via HTTP POST)</li>
	* <li>surname: Surnme of the user (via HTTP POST)</li>
	* <li>dni: Dni of the user (via HTTP POST)</li>
	* <li>username: Email of the user (via HTTP POST)</li>
	* <li>password: Password of the user (via HTTP POST)</li>
	* <li>telephone: Telephone of the user (via HTTP POST)</li>
	* <li>birthdate: Birthdate of the user (via HTTP POST)</li>
	* <li>imageType: Image type of the user (via FILES POST)</li>
	* <li>imageName: Image name of the user (via FILES POST)</li>
	* <li>imageSize: Image size of the user (via FILES POST)</li>
	* <li>isAdministrator: Type of the user (administrator) (via HTTP POST)</li>
	* <li>isTrainer: Type of the user (trainer) (via HTTP POST)</li>
	* <li>isPupil: Type of the user (pupil) (via HTTP POST)</li>
	* <li>isCompetitor: Type of the user (competitor) (via HTTP POST)</li>
	* </ul>
	*
	* @throws Exception if no user is in session
	* @throws Exception if the type is not admin
	* @return void
	*/
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

	/**
	* Action to edit an user
	*
	* When called via GET, it shows the add form
	* When called via POST, it modifies the user in the database.
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>id: Id of the user (via HTTP POST and GET)</li>
	* <li>name: Name of the user (via HTTP POST)</li>
	* <li>surname: Surnme of the user (via HTTP POST)</li>
	* <li>dni: Dni of the user (via HTTP POST)</li>
	* <li>username: Email of the user (via HTTP POST)</li>
	* <li>password: Password of the user (via HTTP POST)</li>
	* <li>telephone: Telephone of the user (via HTTP POST)</li>
	* <li>birthdate: Birthdate of the user (via HTTP POST)</li>
	* <li>imageType: Image type of the user (via FILES POST)</li>
	* <li>imageName: Image name of the user (via FILES POST)</li>
	* <li>imageSize: Image size of the user (via FILES POST)</li>
	* <li>isAdministrator: Type of the user (administrator) (via HTTP POST)</li>
	* <li>isTrainer: Type of the user (trainer) (via HTTP POST)</li>
	* <li>isPupil: Type of the user (pupil) (via HTTP POST)</li>
	* <li>isCompetitor: Type of the user (competitor) (via HTTP POST)</li>
	* </ul>
	*
	* @throws Exception if no user is in session
	* @throws Exception if a user id is not provided
	* @throws Exception if the type is not admin
	* @throws Exception if there is not any user with the provided id
	* @return void
	*/
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
		$user = $this->userMapper->view($id_user);

		if ($user == NULL) {
			throw new Exception("no such user with id: ".$id_user);
		}

		if(isset($_POST["submit"])) { // reaching via HTTP user...

			// populate the user object with data form the form
			$user->setName($_POST["name"]);
			$user->setSurname($_POST["surname"]);
			$user->setDni($_POST["dni"]);

			// put the flag to true if the current user wants to change his own email
			$flag = false;
			$flagCurrent = false;
			$oldUsername = $user->getUsername();
			if($user->getUsername() != $_POST["username"]){
				$oldUsername = $user->getUsername();
				$flag = true;
				if($this->currentUser->getUsername() == $user->getUsername()){
					$flagCurrent = true;
				}
			}
			$user->setUsername($_POST["username"]);

			// if the password was chenged put the flag to true
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
			// if the image was chenged put the flag to true
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
				if(!$flag){
					echo "No cambia username ";
					echo " viejo: ".$oldUsername;
					echo " nuevo: ".$_POST["username"];
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
					$this->view->setFlash(sprintf(i18n("User \"%s\" successfully updated."),$user->getName()));

					// perform the redirection. More or less:
					// header("Location: index.php?controller=users&action=show")
					// die();
					$this->view->redirect("users", "show");
				}else if ($flag) {
					echo "Cambia username";
					echo " viejo: ".$oldUsername;
					echo " nuevo: ".$_POST["username"];
					// validate user object
					if(!$flagCurrent && !$this->userMapper->usernameExists($_POST["username"])){
						echo " No es el mio y SÍ compruebo si existe";
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
						$this->view->setFlash(sprintf(i18n("User \"%s\" successfully updated."),$user->getName()));

						// perform the redirection. More or less:
						// header("Location: index.php?controller=users&action=show")
						// die();
						$this->view->redirect("users", "show");
					}else if($flagCurrent) {
						echo " Es el mio y NO compruebo si existe";
						$user->validateUser($_POST["password"], $_POST["repeatpassword"], $imageName, $imageType, $imageSize, $checkPassword, $checkImage); // if it fails, ValidationException

						//up the image to the server
						move_uploaded_file($_FILES['image']['tmp_name'],$directory.$imageName);

						//save the user object into the database
						$this->userMapper->update($user);

						$_SESSION["currentuser"]=$_POST["username"];

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
						}else {
							$errors = array();
							$errors["email"] = "Username already exists";
							$this->view->setVariable("errors", $errors);
						}
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
		$this->view->render("users", "update");
	}

	/**
	* Action to delete a user
	*
	* This action should only be called via HTTP POST
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>id: Id of the user (via HTTP POST)</li>
	* </ul>
	*
	* @throws Exception if no user is in session
	* @throws Exception if a user id is not provided
	* @throws Exception if the type is not admin
	* @throws Exception if there is not any user with the provided id
	* @return void
	*/
	public function delete() {

		if (!isset($_REQUEST["id_user"])) {
			throw new Exception("A id is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding users requires login");
		}

		if($this->userMapper->findType() != "admin"){
			throw new Exception("You aren't an admin. Adding an user requires be admin");
		}

		// Get the User object from the database
		$id_user = $_REQUEST["id_user"];
		$user = $this->userMapper->view($id_user);

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
		$this->view->render("users", "delete");

	}

	/**
	* Action to list users that match a search pattern
	*
	* This action should only be called via HTTP POST
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>name: Name of the user (via HTTP POST)</li>
	* <li>surname: Surnme of the user (via HTTP POST)</li>
	* <li>dni: Dni of the user (via HTTP POST)</li>
	* <li>username: Email of the user (via HTTP POST)</li>
	* <li>password: Password of the user (via HTTP POST)</li>
	* <li>telephone: Telephone of the user (via HTTP POST)</li>
	* <li>birthdate: Birthdate of the user (via HTTP POST)</li>
	* <li>imageType: Image type of the user (via FILES POST)</li>
	* <li>imageName: Image name of the user (via FILES POST)</li>
	* <li>imageSize: Image size of the user (via FILES POST)</li>
	* <li>isAdministrator: Type of the user (administrator) (via HTTP POST)</li>
	* <li>isTrainer: Type of the user (trainer) (via HTTP POST)</li>
	* <li>isPupil: Type of the user (pupil) (via HTTP POST)</li>
	* <li>isCompetitor: Type of the user (competitor) (via HTTP POST)</li>
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
			throw new Exception("You aren't an admin or a trainer. See all users requires be admin or trainer");
		}

		if (isset($_POST["submit"])) {
			$query = "";
			$flag = 0;

			if ($_POST["name"]){
				$query .= "name LIKE '%". $_POST["name"]."%'";
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
				$users = $this->userMapper->show();
			} else {
				$users = $this->userMapper->search($query);
			}
			$this->view->setVariable("users", $users);
			$this->view->render("users", "show");
		}else {
			// render the view (/view/users/search.php)
			$this->view->render("users", "search");
		}
	}
}
