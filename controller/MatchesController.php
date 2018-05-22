<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../model/Match.php");
require_once(__DIR__."/../model/MatchMapper.php");
require_once(__DIR__."/../model/UserMapper.php");

require_once(__DIR__."/../controller/BaseController.php");

/**
* Class Matches
*
* Controller to matches CRUD
*
* @author braisda <braisda@gmail.com>
*/
class MatchesController extends BaseController {

	/**
	* Reference to the MatchMapper to interact
	* with the database
	*
	* @var MatchMapper
	*/
	private $matchMapper;
  private $userMapper;

	public function __construct() {
		parent::__construct();

		$this->matchMapper = new MatchMapper();
    $this->userMapper = new UserMapper();
	}

	/**
	* Action to list matches
	*
	* Loads all the matches from the database.
	* No HTTP parameters are needed.
	*
	*/
	public function show(){
    if (!isset($_REQUEST["id_tournament"])) {
			throw new Exception("tournament id is mandatory");
		}

    if (!isset($_REQUEST["id_draw"])) {
			throw new Exception("draw id is mandatory");
		}

		if(!isset($this->currentUser)){
			throw new Exception("Not in session. Show matches requires login");
		}

		if($this->userMapper->findType() == "pupil"){
			throw new Exception("You aren't an admin, trainer or competitor. See all matches requires be admin, trainer or competitor");
		}

		$matches = $this->matchMapper->show($_GET["id_tournament"]);
		$competitors = $this->matchMapper->getCompetitors();

		// put the competitors object to the view
		$this->view->setVariable("competitors", $competitors);

    // put the matches object to the view
		$this->view->setVariable("draw", $_GET["id_draw"]);

    // put the matches object to the view
		$this->view->setVariable("tournament", $_GET["id_tournament"]);

		// put the matches object to the view
		$this->view->setVariable("matches", $matches);

		// render the view (/view/matches/show.php)
		$this->view->render("matches", "show");
	}

	/**
	* Action to view a provided match
	*
	* This action should only be called via GET
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>id: Id of the match (via HTTP GET)</li>
	* </ul>
	*
	* @throws Exception If no such match of the provided id is found
	* @return void
	*
	*/
	public function view(){
    if (!isset($_GET["id_tournament"])) {
			throw new Exception("tournament id is mandatory");
		}

		if (!isset($_GET["id_match"])) {
			throw new Exception("match id is mandatory");
		}



		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. View matches requires login");
		}

		if($this->userMapper->findType() == "pupil"){
			throw new Exception("You aren't an admin, trainer or competitor. See all matches requires be admin, trainer or competitor");
		}

		$id_match = $_GET["id_match"];

		// find the match object in the database
		$match = $this->matchMapper->view($id_match);

		if ($match == NULL) {
			throw new Exception("No such match with id: ".$id_match);
		}
    // put the matches object to the view
		$this->view->setVariable("tournament", $_GET["id_tournament"]);

		// put the match object to the view
		$this->view->setVariable("match", $match);

		// render the view (/view/matches/view.php)
		$this->view->render("matches", "view");
	}

	/**
	* Action to add a new match
	*
	* When called via GET, it shows the add form
	* When called via POST, it adds the match to the database
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>name: Name of the match (via HTTP POST)</li>
	* <li>desciption: Description of the match (via HTTP POST)</li>
	* <li>start_adte: Start date of the match (via FILES POST)</li>
	* <li>end_date: End date of the match (via FILES POST)</li>
	* <li>price: Price of the match (via FILES POST)</li>
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
			throw new Exception("Not in session. Adding matches requires login");
		}

		if($this->userMapper->findType() != "admin"){
			throw new Exception("You aren't an admin. Adding an match requires be admin");
		}

		$match = new Match();

		if(isset($_POST["submit"])) { // reaching via HTTP match...

			// populate the match object with data form the form
			$match->setModality($_POST["modality"]);
			$match->setGender($_POST["gender"]);
			$match->setCategory($_POST["category"]);
			$match->setType($_POST["type"]);
			$match->setId_tournament($_POST["id_tournament"]);

			try {
				// check if match exists in the database
				if(!$this->matchMapper->matchExists($_POST["rival1a"], $_POST["rival1b"], $_POST["rival2a"], $_POST["rival2b"])){
					// validate match object
					$match->validateMatch(); // if it fails, ValidationException

					$this->matchMapper->add($match);

					// POST-REDIRECT-GET
					// Everything OK, we will redirect the user to the list of posts
					// We want to see a message after redirection, so we establish
					// a "flash" message (which is simply a Session variable) to be
					// get in the view after redirection.
					$this->view->setFlash(sprintf(i18n("Match \"%s\" successfully added."), i18n($match->getModality())));

					// perform the redirection. More or less:
					// header("Location: index.php?controller=matches&action=show")
					// die();
          // put the matches object to the view
					$this->view->redirect("matches", "show", "id_tournament=".$_REQUEST["id_tournament"]);
				} else {
					$errors = array();
					$errors["modality"] = "Match already exists";
					$this->view->setVariable("errors", $errors);
				}
			}catch(ValidationException $ex) {
				// Get the errors array inside the exepction...
				$errors = $ex->getErrors();
				// And put it to the view as "errors" variable
				$this->view->setVariable("errors", $errors);
			}
		}

    // put the matches object to the view
		$this->view->setVariable("tournament", $_REQUEST["id_tournament"]);

		// Put the match object visible to the view
		$this->view->setVariable("match", $match);
		// render the view (/view/matches/add.php)
		$this->view->render("matches", "add");
	}

	/**
	* Action to edit a match
	*
	* When called via GET, it shows the add form
	* When called via POST, it modifies the match in the database.
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>name: Name of the match (via HTTP POST)</li>
	* <li>desciption: Description of the match (via HTTP POST)</li>
	* <li>start_adte: Start date of the match (via FILES POST)</li>
	* <li>end_date: End date of the match (via FILES POST)</li>
	* <li>price: Price of the match (via FILES POST)</li>
	* </ul>
	*
	* @throws Exception if no user is in session
	* @throws Exception if a match id is not provided
	* @throws Exception if the type is not admin
	* @throws Exception if there is not any match with the provided id
	* @return void
	*/
	public function update(){
    if (!isset($_REQUEST["id_tournament"])) {
			throw new Exception("tournament id is mandatory");
		}

		if (!isset($_REQUEST["id_match"])) {
			throw new Exception("A match id is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding users requires login");
		}

		if($this->userMapper->findType() != "admin"){
			throw new Exception("You aren't an admin. Adding an user requires be admin");
		}

		$id_match = $_REQUEST["id_match"];
		$match = $this->matchMapper->view($id_match);

		if ($match == NULL) {
			throw new Exception("no such match with id: ".$id_match);
		}

		if(isset($_POST["submit"])) { // reaching via HTTP user...

			// populate the match object with data form the form
      $match->setModality($_POST["modality"]);
			$match->setGender($_POST["gender"]);
			$match->setCategory($_POST["category"]);
			$match->setType($_POST["type"]);
			$match->setId_tournament($_REQUEST["id_tournament"]);

			try {
				// check if match exists in the database
				if(!$this->matchMapper->matchExists($_POST["rival1a"], $_POST["rival1b"], $_POST["rival2a"], $_POST["rival2b"])){
					// validate match object
					$match->validateMatch(); // if it fails, ValidationException

					$this->matchMapper->update($match);

					// POST-REDIRECT-GET
					// Everything OK, we will redirect the user to the list of posts
					// We want to see a message after redirection, so we establish
					// a "flash" message (which is simply a Session variable) to be
					// get in the view after redirection.
					$this->view->setFlash(sprintf(i18n("Match \"%s\" successfully updated."),i18n($match ->getModality())));

					// perform the redirection. More or less:
					// header("Location: index.php?controller=matches&action=show")
					// die();
					$this->view->redirect("matches", "show", "id_tournament=".$_REQUEST["id_tournament"]);
				} else {
					$errors = array();
					$errors["modality"] = "Match already exists";
					$this->view->setVariable("errors", $errors);
				}
			}catch(ValidationException $ex) {
				// Get the errors array inside the exepction...
				$errors = $ex->getErrors();
				// And put it to the view as "errors" variable
				$this->view->setVariable("errors", $errors);
			}
		}

    // put the matches object to the view
		$this->view->setVariable("tournament", $_REQUEST["id_tournament"]);

		// Put the user object visible to the view
		$this->view->setVariable("match", $match);
		// render the view (/view/users/add.php)
		$this->view->render("matches", "update");
	}

	/**
	* Action to delete a match
	*
	* This action should only be called via HTTP POST
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>id: Id of the match (via HTTP POST and GET)</li>
	* </ul>
	*
	* @throws Exception if no user is in session
	* @throws Exception if a match id is not provided
	* @throws Exception if the type is not admin
	* @throws Exception if there is not any match with the provided id
	* @return void
	*/
	public function delete() {

		if (!isset($_REQUEST["id_tournament"])) {
			throw new Exception("tournament id is mandatory");
		}

		if (!isset($_REQUEST["id_match"])) {
			throw new Exception("A match id is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding matches requires login");
		}

		if($this->userMapper->findType() != "admin"){
			throw new Exception("You aren't an admin. Adding a match requires be admin");
		}

		// Get the Match object from the database
		$id_match = $_REQUEST["id_match"];
		$match = $this->matchMapper->view($id_match);

		// Does the match exist?
		if ($match == NULL) {
			throw new Exception("no such match with id_user: ".$id_match);
		}

		if (isset($_POST["submit"])) {

			try {
				// Delete the Torunament object from the database
				$this->matchMapper->delete($match);

				// POST-REDIRECT-GET
				// Everything OK, we will redirect the user to the list of posts
				// We want to see a message after redirection, so we establish
				// a "flash" message (which is simply a Session variable) to be
				// get in the view after redirection.
				$this->view->setFlash(sprintf(i18n("Match \"%s\" successfully deleted."), $match->getModality()));

				// perform the redirection. More or less:
				// header("Location: index.php?controller=posts&action=index")
				// die();
				$this->view->redirect("matches", "show", "id_tournament=".$_REQUEST["id_tournament"]);

			}catch(ValidationException $ex) {
				// Get the errors array inside the exepction...
				$errors = $ex->getErrors();
				// And put it to the view as "errors" variable
				$this->view->setVariable("errors", $errors);
			}
		}

		// put the matches object to the view
		$this->view->setVariable("tournament", $_REQUEST["id_tournament"]);

		// Put the user object visible to the view
		$this->view->setVariable("match", $match);
		// render the view (/view/users/add.php)
		$this->view->render("matches", "delete");
	}

	/**
	* Action to list matches that match a search pattern
	*
	* This action should only be called via HTTP POST
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>name: Name of the match (via HTTP POST)</li>
	* <li>desciption: Description of the match (via HTTP POST)</li>
	* <li>start_adte: Start date of the match (via FILES POST)</li>
	* <li>end_date: End date of the match (via FILES POST)</li>
	* <li>price: Price of the match (via FILES POST)</li>
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
			throw new Exception("Not in session. Show matches requires login");
		}

		if($this->userMapper->findType() == "pupil"){
			throw new Exception("You aren't an admin, a trainer or a competitor. See all matches requires be admin, trainer or competitor");
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
				$matches = $this->matchMapper->show();
			} else {
				$matches = $this->matchMapper->search($query);
			}
			$this->view->setVariable("matches", $matches);
			$this->view->setVariable("tournament", $_REQUEST["id_tournament"]);

			$this->view->render("matches", "show");

		}else {
			// put the matches object to the view
			$this->view->setVariable("tournament", $_REQUEST["id_tournament"]);

			// render the view (/view/matches/search.php)
			$this->view->render("matches", "search");
		}
	}
}
