<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../model/Space.php");
require_once(__DIR__."/../model/SpaceMapper.php");
require_once(__DIR__."/../model/UserMapper.php");

require_once(__DIR__."/../controller/BaseController.php");

/**
* Class SpacesController
*
* Controller to spaces CRUD
*
* @author braisda <braisda@gmail.com>
*/
class SpacesController extends BaseController {

	/**
	* Reference to the SpaceMapper to interact
	* with the database
	*
	* @var spaceMapper
	*/
	private $spaceMapper;
  private $userMapper;

	public function __construct() {
		parent::__construct();

		$this->spaceMapper = new SpaceMapper();
    $this->userMapper = new UserMapper();
	}

	/**
	* Action to list spaces
	*
	* Loads all the spaces from the database.
	* No HTTP parameters are needed.
	*
	*/
	public function show(){
		if(!isset($this->currentUser)){
			throw new Exception("Not in session. Show spaces requires login");
		}

		if($this->userMapper->findType() != "admin" && $this->userMapper->findType() != "trainer"){
			throw new Exception("You aren't an admin or a trainer. See all spaces requires be admin or trainer");
		}

		$spaces = $this->spaceMapper->show();

		// put the spaces object to the view
		$this->view->setVariable("spaces", $spaces);

		// render the view (/view/spaces/show.php)
		$this->view->render("spaces", "show");
	}

	/**
	* Action to view a provided space
	*
	* This action should only be called via GET
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>id: Id of the space (via HTTP GET)</li>
	* </ul>
	*
	* @throws Exception If no such space of the provided id is found
	* @return void
	*
	*/
	public function view(){
		if (!isset($_GET["id_space"])) {
			throw new Exception("id is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. View Spaces requires login");
		}

		if($this->userMapper->findType() != "admin" && $this->userMapper->findType() != "trainer"){
			throw new Exception("You aren't an admin or a trainer. See all spaces requires be admin or trainer");
		}

		$id_space= $_GET["id_space"];

		// find the Space object in the database
		$space = $this->spaceMapper->view($id_space);

		if ($space == NULL) {
			throw new Exception("no such space with id: ".$id_space);
		}

		// put the space object to the view
		$this->view->setVariable("space", $space);

		// render the view (/view/spaces/view.php)
		$this->view->render("spaces", "view");
	}

	/**
	* Action to add a new space
	*
	* When called via GET, it shows the add form
	* When called via POST, it adds the space to the database
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>name: Name of the space (via HTTP POST)</li>
	* <li>capacity: Capacity of the space (via HTTP POST)</li>
	* <li>imageType: Image type of the space (via FILES POST)</li>
	* <li>imageName: Image name of the space (via FILES POST)</li>
	* <li>imageSize: Image size of the space (via FILES POST)</li>
	* </ul>
	*
	* @throws Exception if no user is in session
	* @throws Exception if the type is not admin
	* @return void
	*/
	public function add(){

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding spaces requires login");
		}

		if($this->userMapper->findType() != "admin"){
			throw new Exception("You aren't an admin. Adding an space requires be admin");
		}

		$space = new Space();

		if(isset($_POST["submit"])) { // reaching via HTTP space...

			// populate the space object with data form the form
			$space->setName($_POST["name"]);
			$space->setCapacity($_POST["capacity"]);
			$directory = 'multimedia/images/';

			$imageType = $_FILES['image']['type'];
			$imageName = $_FILES['image']['name'];
			$imageSize = $_FILES['image']['size'];
			$space->setImage($directory.$_FILES['image']['name']);


			try {
			 	// check if space exists in the database
				if(!$this->spaceMapper->spaceExists($_POST["name"])){
					//validate space object
					$space->validateSpace($imageName, $imageType, $imageSize, true); // if it fails, ValidationException

					//up the image to the server
					move_uploaded_file($_FILES['image']['tmp_name'],$directory.$imageName);

					//save the user object into the database
					$this->spaceMapper->add($space);

					// POST-REDIRECT-GET
					// Everything OK, we will redirect the user to the list of posts
					// We want to see a message after redirection, so we establish
					// a "flash" message (which is simply a Session variable) to be
					// get in the view after redirection.
					$this->view->setFlash(sprintf(i18n("Space \"%s\" successfully added."),$space ->getName()));

					// perform the redirection. More or less:
					// header("Location: index.php?controller=spaces&action=show")
					// die();
					$this->view->redirect("spaces", "show");
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

		// Put the space object visible to the view
		$this->view->setVariable("space", $space);
		// render the view (/view/spaces/add.php)
		$this->view->render("spaces", "add");
	}

	/**
	* Action to edit a space
	*
	* When called via GET, it shows the add form
	* When called via POST, it modifies the space in the database.
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>id: Id of the space (via HTTP POST and GET)</li>
	* <li>name: Name of the space (via HTTP POST)</li>
	* <li>Capacity: Capacity of the space (via HTTP POST)</li>
	* <li>imageType: Image type of the space (via FILES POST)</li>
	* <li>imageName: Image name of the space (via FILES POST)</li>
	* <li>imageSize: Image size of the space (via FILES POST)</li>
	* </ul>
	*
	* @throws Exception if no user is in session
	* @throws Exception if a space id is not provided
	* @throws Exception if the type is not admin
	* @throws Exception if there is not any space with the provided id
	* @return void
	*/
	public function update(){
		if (!isset($_REQUEST["id_space"])) {
			throw new Exception("A id space is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding users requires login");
		}

		if($this->userMapper->findType() != "admin"){
			throw new Exception("You aren't an admin. Adding an user requires be admin");
		}

		$id_space = $_REQUEST["id_space"];
		$space = $this->spaceMapper->view($id_space);

		if ($space == NULL) {
			throw new Exception("no such space with id: ".$id_space);
		}

		if(isset($_POST["submit"])) { // reaching via HTTP user...

			// populate the space object with data form the form
			$space->setName($_POST["name"]);
			$space->setCapacity($_POST["capacity"]);
			$directory = 'multimedia/images/';
			$imageType = $_FILES['image']['type'];
			$imageName = $_FILES['image']['name'];
			$imageSize = $_FILES['image']['size'];
			if($_FILES['image']['name'] != NULL){
				$space->setImage($directory.$_FILES['image']['name']);
				$checkImage = true;
			}else{
				$checkImage = false;
			}


			try {
				// check if space exists in the database
				if(!$this->spaceMapper->spaceExists($_POST["name"])){
					// validate space object
					$space->validateSpace($imageName, $imageType, $imageSize, $checkImage); // if it fails, ValidationException

					//up the image to the server
					move_uploaded_file($_FILES['image']['tmp_name'],$directory.$imageName);

					//save the space object into the database
					$this->spaceMapper->update($space);

					// POST-REDIRECT-GET
					// Everything OK, we will redirect the user to the list of posts
					// We want to see a message after redirection, so we establish
					// a "flash" message (which is simply a Session variable) to be
					// get in the view after redirection.
					$this->view->setFlash(sprintf(i18n("Space \"%s\" successfully updated."),$space ->getName()));

					// perform the redirection. More or less:
					// header("Location: index.php?controller=spaces&action=show")
					// die();
					$this->view->redirect("spaces", "show");
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

		// Put the user object visible to the view
		$this->view->setVariable("space", $space);
		// render the view (/view/users/add.php)
		$this->view->render("spaces", "update");
	}

	/**
	* Action to delete a space
	*
	* This action should only be called via HTTP POST
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>id: Id of the space (via HTTP POST and GET)</li>
	* </ul>
	*
	* @throws Exception if no user is in session
	* @throws Exception if a space id is not provided
	* @throws Exception if the type is not admin
	* @throws Exception if there is not any space with the provided id
	* @return void
	*/
	public function delete() {

		if (!isset($_REQUEST["id_space"])) {
			throw new Exception("A id is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding spaces requires login");
		}

		if($this->userMapper->findType() != "admin"){
			throw new Exception("You aren't an admin. Adding a space requires be admin");
		}

		// Get the Space object from the database
		$id_space = $_REQUEST["id_space"];
		$space = $this->spaceMapper->view($id_space);

		// Does the space exist?
		if ($space == NULL) {
			throw new Exception("no such user with id: ".$id_space);
		}

		if (isset($_POST["submit"])) {

			try {
				// Delete the Space object from the database
				$this->spaceMapper->delete($space);

				// POST-REDIRECT-GET
				// Everything OK, we will redirect the user to the list of posts
				// We want to see a message after redirection, so we establish
				// a "flash" message (which is simply a Session variable) to be
				// get in the view after redirection.
				$this->view->setFlash(sprintf(i18n("Space \"%s\" successfully deleted."), $space->getName()));

				// perform the redirection. More or less:
				// header("Location: index.php?controller=spaces&action=show")
				// die();
				$this->view->redirect("spaces", "show");

			}catch(ValidationException $ex) {
				// Get the errors array inside the exepction...
				$errors = $ex->getErrors();
				// And put it to the view as "errors" variable
				$this->view->setVariable("errors", $errors);
			}
		}

		// Put the user object visible to the view
		$this->view->setVariable("space", $space);
		// render the view (/view/users/add.php)
		$this->view->render("spaces", "delete");

	}

	/**
	* Action to list spaces that match a search pattern
	*
	* This action should only be called via HTTP POST
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>name: Name of the space (via HTTP POST)</li>
	* </ul>
	*
	* @throws Exception if no user is in session
	* @throws Exception if the type is not admin
	* @return void
	*/
	public function search() {
		if(!isset($this->currentUser)){
			throw new Exception("Not in session. Show spaces requires login");
		}

		if($this->userMapper->findType() != "admin" && $this->userMapper->findType() != "trainer"){
			throw new Exception("You aren't an admin or a trainer. See all spaces requires be admin or trainer");
		}

		if(isset($_POST["submit"])) {
			$query = "";
			$flag = 0;

			if ($_POST["name"]){
				$query .= "name LIKE '%". $_POST["name"]."%'";
				$flag = 1;
			}

			if (empty($query)) {
				$spaces = $this->spaceMapper->show();
			} else {
				$spaces = $this->spaceMapper->search($query);
			}
			$this->view->setVariable("spaces", $spaces);
			$this->view->render("spaces", "show");
		}else {
			// render the view (/view/spaces/search.php)
			$this->view->render("spaces", "search");
		}
	}
}
