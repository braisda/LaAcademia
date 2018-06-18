<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../model/Draw.php");
require_once(__DIR__."/../model/DrawMapper.php");
require_once(__DIR__."/../model/UserMapper.php");

require_once(__DIR__."/../controller/BaseController.php");

/**
* Class Draws
*
* Controller to draws CRUD
*
* @author braisda <braisda@gmail.com>
*/
class DrawsController extends BaseController {

	/**
	* Reference to the DrawMapper to interact
	* with the database
	*
	* @var DrawMapper
	*/
	private $drawMapper;
  private $userMapper;

	public function __construct() {
		parent::__construct();

		$this->drawMapper = new DrawMapper();
    $this->userMapper = new UserMapper();
	}

	/**
	* Action to list draws
	*
	* Loads all the draws from the database.
	* No HTTP parameters are needed.
	*
	*/
	public function show(){
    if (!isset($_REQUEST["id_tournament"])) {
			throw new Exception("tournament id is mandatory");
		}

		if(!isset($this->currentUser)){
			throw new Exception("Not in session. Show draws requires login");
		}

		if($this->userMapper->findType() == "pupil"){
			throw new Exception("You aren't an admin, trainer or competitor. See all draws requires be admin, trainer or competitor");
		}

		$draws = $this->drawMapper->show($_GET["id_tournament"]);

    // put the draws object to the view
		$this->view->setVariable("tournament", $_GET["id_tournament"]);

		// put the draws object to the view
		$this->view->setVariable("draws", $draws);

		// render the view (/view/draws/show.php)
		$this->view->render("draws", "show");
	}

	/**
	* Action to view a provided draw
	*
	* This action should only be called via GET
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>id: Id of the draw (via HTTP GET)</li>
	* </ul>
	*
	* @throws Exception If no such draw of the provided id is found
	* @return void
	*
	*/
	public function view(){
    if (!isset($_GET["id_tournament"])) {
			throw new Exception("tournament id is mandatory");
		}

		if (!isset($_GET["id_draw"])) {
			throw new Exception("draw id is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. View draws requires login");
		}

		if($this->userMapper->findType() == "pupil"){
			throw new Exception("You aren't an admin, trainer or competitor. See all draws requires be admin, trainer or competitor");
		}

		$id_draw = $_GET["id_draw"];

		// find the draw object in the database
		$draw = $this->drawMapper->view($id_draw);

		if ($draw == NULL) {
			throw new Exception("No such draw with id: ".$id_draw);
		}
    // put the draws object to the view
		$this->view->setVariable("tournament", $_GET["id_tournament"]);

		// put the draw object to the view
		$this->view->setVariable("draw", $draw);

		// render the view (/view/draws/view.php)
		$this->view->render("draws", "view");
	}

	/**
	* Action to add a new draw
	*
	* When called via GET, it shows the add form
	* When called via POST, it adds the draw to the database
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>name: Name of the draw (via HTTP POST)</li>
	* <li>desciption: Description of the draw (via HTTP POST)</li>
	* <li>start_adte: Start date of the draw (via FILES POST)</li>
	* <li>end_date: End date of the draw (via FILES POST)</li>
	* <li>price: Price of the draw (via FILES POST)</li>
	* </ul>
	*
	* @throws Exception if no user is in session
	* @throws Exception if the type is not admin
	* @return void
	*/
	public function add(){
    if (!isset($_REQUEST["id_tournament"])) {
			throw new Exception("tournament id is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding draws requires login");
		}

		if($this->userMapper->findType() != "admin"){
			throw new Exception("You aren't an admin. Adding an draw requires be admin");
		}

		$draw = new Draw();

		if(isset($_POST["submit"])) { // reaching via HTTP draw...

			// populate the draw object with data form the form
			$draw->setModality($_POST["modality"]);
			$draw->setGender($_POST["gender"]);
			$draw->setCategory($_POST["category"]);
			$draw->setType($_POST["type"]);
			$draw->setId_tournament($_POST["id_tournament"]);

			try {
				// check if draw exists in the database
				if(!$this->drawMapper->drawExists($_POST["modality"], $_POST["gender"], $_POST["category"], $_POST["type"])){
					// validate draw object
					$draw->validateDraw(); // if it fails, ValidationException

					$this->drawMapper->add($draw);

					// POST-REDIRECT-GET
					// Everything OK, we will redirect the user to the list of posts
					// We want to see a message after redirection, so we establish
					// a "flash" message (which is simply a Session variable) to be
					// get in the view after redirection.
					$this->view->setFlash(sprintf(i18n("Draw \"%s\" successfully added."), i18n($draw->getModality())));

					// perform the redirection. More or less:
					// header("Location: index.php?controller=draws&action=show")
					// die();
          // put the draws object to the view
					$this->view->redirect("draws", "show", "id_tournament=".$_REQUEST["id_tournament"]);
				} else {
					$errors = array();
					$errors["modality"] = "Draw already exists";
					$this->view->setVariable("errors", $errors);
				}
			}catch(ValidationException $ex) {
				// Get the errors array inside the exepction...
				$errors = $ex->getErrors();
				// And put it to the view as "errors" variable
				$this->view->setVariable("errors", $errors);
			}
		}

    // put the draws object to the view
		$this->view->setVariable("tournament", $_REQUEST["id_tournament"]);

		// Put the draw object visible to the view
		$this->view->setVariable("draw", $draw);
		// render the view (/view/draws/add.php)
		$this->view->render("draws", "add");
	}

	/**
	* Action to edit a draw
	*
	* When called via GET, it shows the add form
	* When called via POST, it modifies the draw in the database.
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>name: Name of the draw (via HTTP POST)</li>
	* <li>desciption: Description of the draw (via HTTP POST)</li>
	* <li>start_adte: Start date of the draw (via FILES POST)</li>
	* <li>end_date: End date of the draw (via FILES POST)</li>
	* <li>price: Price of the draw (via FILES POST)</li>
	* </ul>
	*
	* @throws Exception if no user is in session
	* @throws Exception if a draw id is not provided
	* @throws Exception if the type is not admin
	* @throws Exception if there is not any draw with the provided id
	* @return void
	*/
	public function update(){
    if (!isset($_REQUEST["id_tournament"])) {
			throw new Exception("tournament id is mandatory");
		}

		if (!isset($_REQUEST["id_draw"])) {
			throw new Exception("A draw id is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding users requires login");
		}

		if($this->userMapper->findType() != "admin"){
			throw new Exception("You aren't an admin. Adding an user requires be admin");
		}

		$id_draw = $_REQUEST["id_draw"];
		$draw = $this->drawMapper->view($id_draw);

		if ($draw == NULL) {
			throw new Exception("no such draw with id: ".$id_draw);
		}

		if(isset($_POST["submit"])) { // reaching via HTTP user...

			// populate the draw object with data form the form
      $draw->setModality($_POST["modality"]);
			$draw->setGender($_POST["gender"]);
			$draw->setCategory($_POST["category"]);
			$draw->setType($_POST["type"]);
			$draw->setId_tournament($_REQUEST["id_tournament"]);

			try {
				// check if draw exists in the database
				if(!$this->drawMapper->drawExists($_POST["modality"], $_POST["gender"], $_POST["category"], $_POST["type"])){
					// validate draw object
					$draw->validateDraw(); // if it fails, ValidationException

					$this->drawMapper->update($draw);

					// POST-REDIRECT-GET
					// Everything OK, we will redirect the user to the list of posts
					// We want to see a message after redirection, so we establish
					// a "flash" message (which is simply a Session variable) to be
					// get in the view after redirection.
					$this->view->setFlash(sprintf(i18n("Draw \"%s\" successfully updated."),i18n($draw ->getModality())));

					// perform the redirection. More or less:
					// header("Location: index.php?controller=draws&action=show")
					// die();
					$this->view->redirect("draws", "show", "id_tournament=".$_REQUEST["id_tournament"]);
				} else {
					$errors = array();
					$errors["modality"] = "Draw already exists";
					$this->view->setVariable("errors", $errors);
				}
			}catch(ValidationException $ex) {
				// Get the errors array inside the exepction...
				$errors = $ex->getErrors();
				// And put it to the view as "errors" variable
				$this->view->setVariable("errors", $errors);
			}
		}

    // put the draws object to the view
		$this->view->setVariable("tournament", $_REQUEST["id_tournament"]);

		// Put the user object visible to the view
		$this->view->setVariable("draw", $draw);
		// render the view (/view/users/add.php)
		$this->view->render("draws", "update");
	}

	/**
	* Action to delete a draw
	*
	* This action should only be called via HTTP POST
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>id: Id of the draw (via HTTP POST and GET)</li>
	* </ul>
	*
	* @throws Exception if no user is in session
	* @throws Exception if a draw id is not provided
	* @throws Exception if the type is not admin
	* @throws Exception if there is not any draw with the provided id
	* @return void
	*/
	public function delete() {

		if (!isset($_REQUEST["id_tournament"])) {
			throw new Exception("tournament id is mandatory");
		}

		if (!isset($_REQUEST["id_draw"])) {
			throw new Exception("A draw id is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding draws requires login");
		}

		if($this->userMapper->findType() != "admin"){
			throw new Exception("You aren't an admin. Adding a draw requires be admin");
		}

		// Get the Draw object from the database
		$id_draw = $_REQUEST["id_draw"];
		$draw = $this->drawMapper->view($id_draw);

		// Does the draw exist?
		if ($draw == NULL) {
			throw new Exception("no such draw with id_user: ".$id_draw);
		}

		if (isset($_POST["submit"])) {

			try {
				// Delete the Torunament object from the database
				$this->drawMapper->delete($draw);

				// POST-REDIRECT-GET
				// Everything OK, we will redirect the user to the list of posts
				// We want to see a message after redirection, so we establish
				// a "flash" message (which is simply a Session variable) to be
				// get in the view after redirection.
				$this->view->setFlash(sprintf(i18n("Draw \"%s\" successfully deleted."), $draw->getModality()));

				// perform the redirection. More or less:
				// header("Location: index.php?controller=posts&action=index")
				// die();
				$this->view->redirect("draws", "show", "id_tournament=".$_REQUEST["id_tournament"]);

			}catch(ValidationException $ex) {
				// Get the errors array inside the exepction...
				$errors = $ex->getErrors();
				// And put it to the view as "errors" variable
				$this->view->setVariable("errors", $errors);
			}
		}

		// put the draws object to the view
		$this->view->setVariable("tournament", $_REQUEST["id_tournament"]);

		// Put the user object visible to the view
		$this->view->setVariable("draw", $draw);
		// render the view (/view/users/add.php)
		$this->view->render("draws", "delete");
	}

	/**
	* Action to list draws that match a search pattern
	*
	* This action should only be called via HTTP POST
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>name: Name of the draw (via HTTP POST)</li>
	* <li>desciption: Description of the draw (via HTTP POST)</li>
	* <li>start_adte: Start date of the draw (via FILES POST)</li>
	* <li>end_date: End date of the draw (via FILES POST)</li>
	* <li>price: Price of the draw (via FILES POST)</li>
	* </ul>
	*
	* @throws Exception if no user is in session
	* @throws Exception if the type is not admin, trainer or competitor
	* @return void
	*/
	public function search() {
		if (!isset($_REQUEST["id_tournament"])) {
			throw new Exception("tournament id is mandatory");
		}

		if(!isset($this->currentUser)){
			throw new Exception("Not in session. Show draws requires login");
		}

		if($this->userMapper->findType() == "pupil"){
			throw new Exception("You aren't an admin, a trainer or a competitor. See all draws requires be admin, trainer or competitor");
		}

		if (isset($_POST["submit"])) {
			$query = "";
			$flag = 0;

			if ($_POST["modality"]){
				if ($flag){
					$query .= " AND ";
				}
				$query .= "modality='". $_POST["modality"]."'";
				$flag = 1;
			}

			if ($_POST["gender"]){
				if ($flag){
					$query .= " AND ";
				}
				$query .= "gender='". $_POST["gender"]."'";
				$flag = 1;
			}

			if ($_POST["category"]){
				if ($flag){
					$query .= " AND ";
				}
				$query .= "category='". $_POST["category"]."'";
				$flag = 1;
			}

			if ($_POST["type"]){
				if ($flag){
					$query .= " AND ";
				}
				$query .= "type='". $_POST["type"]."'";
				$flag = 1;
			}

			if(empty($query)) {
				$draws = $this->drawMapper->show();
			} else {
				$draws = $this->drawMapper->search($query);
			}
			$this->view->setVariable("draws", $draws);
			$this->view->setVariable("tournament", $_REQUEST["id_tournament"]);

			$this->view->render("draws", "show");

		}else {
			// put the draws object to the view
			$this->view->setVariable("tournament", $_REQUEST["id_tournament"]);

			// render the view (/view/draws/search.php)
			$this->view->render("draws", "search");
		}
	}
}
