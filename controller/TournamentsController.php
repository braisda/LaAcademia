<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../model/Tournament.php");
require_once(__DIR__."/../model/TournamentMapper.php");
require_once(__DIR__."/../model/UserMapper.php");

require_once(__DIR__."/../controller/BaseController.php");

/**
* Class TournamentController
*
* Controller to tournaments CRUD
*
* @author braisda <braisda@gmail.com>
*/
class TournamentsController extends BaseController {

	/**
	* Reference to the TournamentMapper to interact
	* with the database
	*
	* @var TournamentMapper
	*/
	private $tournamentMapper;
  private $userMapper;

	public function __construct() {
		parent::__construct();

		$this->tournamentMapper = new TournamentMapper();
    $this->userMapper = new UserMapper();
	}

	/**
	* Action to list tournaments
	*
	* Loads all the tournaments from the database.
	* No HTTP parameters are needed.
	*
	*/
	public function show(){
		if(!isset($this->currentUser)){
			throw new Exception("Not in session. Show tournaments requires login");
		}

		if($this->userMapper->findType() == "pupil"){
			throw new Exception("You aren't an admin, trainer or competitor. See all tournaments requires be admin, trainer or competitor");
		}

		$tournaments = $this->tournamentMapper->show();

		// put the tournaments object to the view
		$this->view->setVariable("tournaments", $tournaments);

		// render the view (/view/tournaments/show.php)
		$this->view->render("tournaments", "show");
	}

	/**
	* Action to view a provided tournament
	*
	* This action should only be called via GET
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>id: Id of the tournament (via HTTP GET)</li>
	* </ul>
	*
	* @throws Exception If no such tournament of the provided id is found
	* @return void
	*
	*/
	public function view(){
		if (!isset($_GET["id_tournament"])) {
			throw new Exception("tournament id is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. View tournaments requires login");
		}

		if($this->userMapper->findType() == "pupil"){
			throw new Exception("You aren't an admin, trainer or competitor. See all tournaments requires be admin, trainer or competitor");
		}

		$id_tournament = $_GET["id_tournament"];

		// find the tournament object in the database
		$tournament = $this->tournamentMapper->view($id_tournament);

		if ($tournament == NULL) {
			throw new Exception("No such tournament with id: ".$id_tournament);
		}

		// put the tournament object to the view
		$this->view->setVariable("tournament", $tournament);

		// render the view (/view/tournaments/view.php)
		$this->view->render("tournaments", "view");
	}

	/**
	* Action to add a new tournament
	*
	* When called via GET, it shows the add form
	* When called via POST, it adds the tournament to the database
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>name: Name of the tournament (via HTTP POST)</li>
	* <li>desciption: Description of the tournament (via HTTP POST)</li>
	* <li>start_adte: Start date of the tournament (via FILES POST)</li>
	* <li>end_date: End date of the tournament (via FILES POST)</li>
	* <li>price: Price of the tournament (via FILES POST)</li>
	* </ul>
	*
	* @throws Exception if no user is in session
	* @throws Exception if the type is not admin
	* @return void
	*/
	public function add(){

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding tournaments requires login");
		}

		if($this->userMapper->findType() != "admin"){
			throw new Exception("You aren't an admin. Adding an tournament requires be admin");
		}

		$tournament = new Tournament();

		if(isset($_POST["submit"])) { // reaching via HTTP tournament...

			// populate the tournament object with data form the form
			$tournament->setName($_POST["name"]);
			$tournament->setDescription($_POST["description"]);
			$tournament->setStart_date($_POST["start_date"]);
			$tournament->setEnd_date($_POST["end_date"]);
			$tournament->setPrice($_POST["price"]);

			try {
				// check if tournament exists in the database
				if(!$this->tournamentMapper->tournamentExists($_POST["name"])){
					// validate tournament object
					$tournament->validateTournament(); // if it fails, ValidationException

					$this->tournamentMapper->add($tournament);

					// POST-REDIRECT-GET
					// Everything OK, we will redirect the user to the list of posts
					// We want to see a message after redirection, so we establish
					// a "flash" message (which is simply a Session variable) to be
					// get in the view after redirection.
					$this->view->setFlash(sprintf(i18n("Tournament \"%s\" successfully added."),$tournament ->getName()));

					// perform the redirection. More or less:
					// header("Location: index.php?controller=tournaments&action=show")
					// die();
					$this->view->redirect("tournaments", "show");
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

		// Put the tournament object visible to the view
		$this->view->setVariable("tournament", $tournament);
		// render the view (/view/tournaments/add.php)
		$this->view->render("tournaments", "add");
	}

	/**
	* Action to edit a tournament
	*
	* When called via GET, it shows the add form
	* When called via POST, it modifies the tournament in the database.
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>name: Name of the tournament (via HTTP POST)</li>
	* <li>desciption: Description of the tournament (via HTTP POST)</li>
	* <li>start_adte: Start date of the tournament (via FILES POST)</li>
	* <li>end_date: End date of the tournament (via FILES POST)</li>
	* <li>price: Price of the tournament (via FILES POST)</li>
	* </ul>
	*
	* @throws Exception if no user is in session
	* @throws Exception if a tournament id is not provided
	* @throws Exception if the type is not admin
	* @throws Exception if there is not any tournament with the provided id
	* @return void
	*/
	public function update(){
		if (!isset($_REQUEST["id_tournament"])) {
			throw new Exception("A tournament id is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding users requires login");
		}

		if($this->userMapper->findType() != "admin"){
			throw new Exception("You aren't an admin. Adding an user requires be admin");
		}

		$id_tournament = $_REQUEST["id_tournament"];
		$tournament = $this->tournamentMapper->view($id_tournament);

		if ($tournament == NULL) {
			throw new Exception("no such tournament with id: ".$id_tournament);
		}

		if(isset($_POST["submit"])) { // reaching via HTTP user...

			// populate the tournament object with data form the form
			$tournament->setName($_POST["name"]);
			$tournament->setDescription($_POST["description"]);
			$tournament->setStart_date($_POST["start_date"]);
			$tournament->setEnd_date($_POST["end_date"]);
			$tournament->setPrice($_POST["price"]);

			try {
				// check if tournament exists in the database
				if(!$this->tournamentMapper->tournamentExists($_POST["name"])){
					// validate tournament object
					$tournament->validatetournament(); // if it fails, ValidationException

					$this->tournamentMapper->update($tournament);

					// POST-REDIRECT-GET
					// Everything OK, we will redirect the user to the list of posts
					// We want to see a message after redirection, so we establish
					// a "flash" message (which is simply a Session variable) to be
					// get in the view after redirection.
					$this->view->setFlash(sprintf(i18n("Tournament \"%s\" successfully updated."),$tournament ->getName()));

					// perform the redirection. More or less:
					// header("Location: index.php?controller=tournaments&action=show")
					// die();
					$this->view->redirect("tournaments", "show");
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
		$this->view->setVariable("tournament", $tournament);
		// render the view (/view/users/add.php)
		$this->view->render("tournaments", "update");
	}

	/**
	* Action to delete a tournament
	*
	* This action should only be called via HTTP POST
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>id: Id of the tournament (via HTTP POST and GET)</li>
	* </ul>
	*
	* @throws Exception if no user is in session
	* @throws Exception if a tournament id is not provided
	* @throws Exception if the type is not admin
	* @throws Exception if there is not any tournament with the provided id
	* @return void
	*/
	public function delete() {

		if (!isset($_REQUEST["id_tournament"])) {
			throw new Exception("A tournament id is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding tournaments requires login");
		}

		if($this->userMapper->findType() != "admin"){
			throw new Exception("You aren't an admin. Adding a tournament requires be admin");
		}

		// Get the Tournament object from the database
		$id_tournament = $_REQUEST["id_tournament"];
		$tournament = $this->tournamentMapper->view($id_tournament);

		// Does the tournament exist?
		if ($tournament == NULL) {
			throw new Exception("no such user with id_user: ".$id_tournament);
		}

		if (isset($_POST["submit"])) {

			try {
				// Delete the Torunament object from the database
				$this->tournamentMapper->delete($tournament);

				// POST-REDIRECT-GET
				// Everything OK, we will redirect the user to the list of posts
				// We want to see a message after redirection, so we establish
				// a "flash" message (which is simply a Session variable) to be
				// get in the view after redirection.
				$this->view->setFlash(sprintf(i18n("Tournament \"%s\" successfully deleted."), $tournament->getName()));

				// perform the redirection. More or less:
				// header("Location: index.php?controller=posts&action=index")
				// die();
				$this->view->redirect("tournaments", "show");

			}catch(ValidationException $ex) {
				// Get the errors array inside the exepction...
				$errors = $ex->getErrors();
				// And put it to the view as "errors" variable
				$this->view->setVariable("errors", $errors);
			}
		}

		// Put the user object visible to the view
		$this->view->setVariable("tournament", $tournament);
		// render the view (/view/users/add.php)
		$this->view->render("tournaments", "delete");
	}

	/**
	* Action to list tournaments that match a search pattern
	*
	* This action should only be called via HTTP POST
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>name: Name of the tournament (via HTTP POST)</li>
	* <li>desciption: Description of the tournament (via HTTP POST)</li>
	* <li>start_adte: Start date of the tournament (via FILES POST)</li>
	* <li>end_date: End date of the tournament (via FILES POST)</li>
	* <li>price: Price of the tournament (via FILES POST)</li>
	* </ul>
	*
	* @throws Exception if no user is in session
	* @throws Exception if the type is not admin, trainer or competitor
	* @return void
	*/
	public function search() {
		if(!isset($this->currentUser)){
			throw new Exception("Not in session. Show tournaments requires login");
		}

		if($this->userMapper->findType() == "pupil"){
			throw new Exception("You aren't an admin, a trainer or a competitor. See all tournaments requires be admin, trainer or competitor");
		}

		if (isset($_POST["submit"])) {
			$query = "";
			$flag = 0;

			if ($_POST["name"]){
				$query .= "name LIKE '%". $_POST["name"]."%'";
				$flag = 1;
			}

			if ($_POST["description"]){
				$query .= "description LIKE '%". $_POST["description"]."%'";
				$flag = 1;
			}

			if ($_POST["start_date"]){
				if ($flag){
					$query .= " AND ";
				}
				$query .= "start_date='". $_POST["start_date"]."'";
				$flag = 1;
			}

			if ($_POST["end_date"]){
				if ($flag){
					$query .= " AND ";
				}
				$query .= "end_date='". $_POST["end_date"]."'";
				$flag = 1;
			}

			if ($_POST["price"]){
				if ($flag){
					$query .= " AND ";
				}
				$query .= "price='". $_POST["price"]."'";
				$flag = 1;
			}

			if(empty($query)) {
				$tournaments = $this->tournamentMapper->show();
			} else {
				$tournaments = $this->tournamentMapper->search($query);
			}
			$this->view->setVariable("tournaments", $tournaments);
			$this->view->render("tournaments", "show");
		}else {
			// render the view (/view/tournaments/search.php)
			$this->view->render("tournaments", "search");
		}
	}
}
