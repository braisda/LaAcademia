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
* @author lipido <lipido@gmail.com>
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

	public function show(){
		if(!isset($this->currentUser)){
			throw new Exception("Not in session. Show spaces requires login");
		}

		$spaces = $this->spaceMapper->show();

		// put the spaces object to the view
		$this->view->setVariable("spaces", $spaces);

		// render the view (/view/spaces/show.php)
		$this->view->render("spaces", "show");
	}

	public function view(){
		if (!isset($_GET["id_space"])) {
			throw new Exception("id_space is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. View Spaces requires login");
		}

		$id_space= $_GET["id_space"];

		// find the Space object in the database
		$space = $this->spaceMapper->view($id_space);

		if ($space == NULL) {
			throw new Exception("no such space with id_space: ".$id_space);
		}

		// put the space object to the view
		$this->view->setVariable("space", $space);

		// render the view (/view/spaces/view.php)
		$this->view->render("spaces", "view");
	}

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
			$space->setImage($directory.$_FILES['image']['name']);
			move_uploaded_file($_FILES['image']['tmp_name'],$directory.$_FILES['image']['name']);

			try {
				// validate space object
				//$user->ValidRegister($_POST["rpass"]); // if it fails, ValidationException

				//if(!$user->userMapper->is_valid_DNI($user->getUsername())){
				//	$this->userMapper->update($user);
				//}else{
					//save the user object into the database
					$this->spaceMapper->add($space);
				//}

				$this->view->setFlash(sprintf(i18n("Space \"%s\" successfully added."),$space ->getName()));

				$this->view->redirect("spaces", "show");

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

	public function update(){
		if (!isset($_REQUEST["id_space"])) {
			throw new Exception("A id_space is mandatory");
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
			throw new Exception("no such space with id_space: ".$id_space);
		}

		if(isset($_POST["submit"])) { // reaching via HTTP user...

			// populate the space object with data form the form
			$space->setName($_POST["name"]);
			$space->setCapacity($_POST["capacity"]);
			$directory = 'multimedia/images/';
			if($_FILES['image']['name'] != NULL){
				$space->setImage($directory.$_FILES['image']['name']);
				move_uploaded_file($_FILES['image']['tmp_name'],$directory.$_FILES['image']['name']);
			}


			try {
				// validate user object
				//$user->ValidRegister($_POST["rpass"]); // if it fails, ValidationException

				//if(!$user->userMapper->is_valid_DNI($user->getUsername())){
				//	$this->userMapper->update($user);
				//}else{
					//save the user object into the database
					$this->spaceMapper->update($space);
				//}

				$this->view->setFlash(sprintf(i18n("Space \"%s\" successfully updated."),$space ->getName()));

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
		$this->view->render("spaces", "update");
	}

	public function delete() {

		if (!isset($_REQUEST["id_space"])) {
			throw new Exception("A id_space is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding spaces requires login");
		}

		if($this->userMapper->findType() != "admin"){
			throw new Exception("You aren't an admin. Adding a space requires be admin");
		}

		// Get the User object from the database
		$id_space = $_REQUEST["id_space"];
		$space = $this->spaceMapper->view($id_space);

		// Does the space exist?
		if ($space == NULL) {
			throw new Exception("no such user with id_user: ".$id_space);
		}

		if (isset($_POST["submit"])) {

			try {
				// Delete the Post object from the database
				$this->spaceMapper->delete($space);

				// POST-REDIRECT-GET
				// Everything OK, we will redirect the user to the list of posts
				// We want to see a message after redirection, so we establish
				// a "flash" message (which is simply a Session variable) to be
				// get in the view after redirection.
				$this->view->setFlash(sprintf(i18n("Space \"%s\" successfully deleted."), $space->getName()));

				// perform the redirection. More or less:
				// header("Location: index.php?controller=posts&action=index")
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
}
