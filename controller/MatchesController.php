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

		if (!isset($_REQUEST["id_draw"])) {
			throw new Exception("draw id is mandatory");
		}

		if (!isset($_GET["id_match"])) {
			throw new Exception("match id is mandatory");
		}

		if (!isset($_REQUEST["cell"])) {
			throw new Exception("cell id is mandatory");
		}

		if (!isset($_REQUEST["round"])) {
			throw new Exception("round id is mandatory");
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

		// put the matches object to the view
		$this->view->setVariable("draw", $_GET["id_draw"]);

		// put the match object to the view
		$this->view->setVariable("match", $match);

		// Put the cell visible to the view
		$this->view->setVariable("cell", $_REQUEST["cell"]);

		// Put the round visible to the view
		$this->view->setVariable("round", $_REQUEST["round"]);

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

		if (!isset($_REQUEST["id_draw"])) {
			throw new Exception("draw id is mandatory");
		}

		if (!isset($_REQUEST["cell"])) {
			throw new Exception("cell id is mandatory");
		}

		if (!isset($_REQUEST["round"])) {
			throw new Exception("round id is mandatory");
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
			$match->setRival1a($_POST["rival1a"]);
			$match->setRival1b($_POST["rival1b"]);
			$match->setRival2a($_POST["rival2a"]);
			$match->setRival2b($_POST["rival2b"]);
			$match->setDate($_POST["date"]);
			$match->setTime($_POST["time"]);
			$match->setId_space($_POST["space"]);
			$match->setRound($_POST["round"]);
			$match->setCell($_POST["cell"]);
			$match->setSet1a($_POST["set1a"]);
			$match->setSet1b($_POST["set1b"]);
			$match->setSet2a($_POST["set2a"]);
			$match->setSet2b($_POST["set2b"]);
			$match->setSet3a($_POST["set3a"]);
			$match->setSet3b($_POST["set3b"]);
			$match->setSet4a($_POST["set4a"]);
			$match->setSet4b($_POST["set4b"]);
			$match->setSet5a($_POST["set5a"]);
			$match->setSet5b($_POST["set5b"]);
			$match->setId_draw($_POST["id_draw"]);

			try {
				// check if match exists in the database
				if(!$this->matchMapper->matchExists($_POST["rival1a"], $_POST["rival1b"], $_POST["rival2a"], $_POST["rival2b"],
																						$_REQUEST["id_draw"])){
					// validate match object
					$match->validateMatch(); // if it fails, ValidationException

					$this->matchMapper->add($match);

					// POST-REDIRECT-GET
					// Everything OK, we will redirect the user to the list of posts
					// We want to see a message after redirection, so we establish
					// a "flash" message (which is simply a Session variable) to be
					// get in the view after redirection.
					$this->view->setFlash(sprintf(i18n("Match \"%s\" successfully added."), i18n($match->getDate())));

					// perform the redirection. More or less:
					// header("Location: index.php?controller=matches&action=show")
					// die();
          // put the matches object to the view
					$this->view->redirect("matches", "show", "id_tournament=".$_REQUEST["id_tournament"], "id_draw=".$_REQUEST["id_draw"]);
				} else {
					$errors = array();
					$errors["rival"] = "Match already exists";
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
		$spaces = $this->matchMapper->getSpaces();
		// Put the space variable visible to the view
		$this->view->setVariable("spaces", $spaces);

		//Get the id and name of the competitors
		$competitors = $this->matchMapper->getCompetitors();

		// Put the space variable visible to the view
		$this->view->setVariable("competitors", $competitors);

    // put the tournament id visible to the view
		$this->view->setVariable("tournament", $_REQUEST["id_tournament"]);

		// put the draw id visible to the view
		$this->view->setVariable("draw", $_REQUEST["id_draw"]);

		// Put the match object visible to the view
		$this->view->setVariable("match", $match);

		// Put the cell visible to the view
		$this->view->setVariable("cell", $_REQUEST["cell"]);

		// Put the round visible to the view
		$this->view->setVariable("round", $_REQUEST["round"]);

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

		if (!isset($_REQUEST["id_draw"])) {
			throw new Exception("draw id is mandatory");
		}

		if (!isset($_REQUEST["cell"])) {
			throw new Exception("cell id is mandatory");
		}

		if (!isset($_REQUEST["round"])) {
			throw new Exception("round id is mandatory");
		}

		if (!isset($_REQUEST["id_match"])) {
			throw new Exception("A match id is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding users requires login");
		}

		if($this->userMapper->findType() != "admin" && $this->userMapper->findType() != "trainer"){
			throw new Exception("You aren't an admin or trainer. Adding an user requires be admin or trainer");
		}

		$id_match = $_REQUEST["id_match"];
		$match = $this->matchMapper->view($id_match);

		if ($match == NULL) {
			throw new Exception("no such match with id: ".$id_match);
		}

		if(isset($_POST["submit"])) { // reaching via HTTP user...

			// populate the match object with data form the form

			// put the flag to true if the user changes the space name
			$flag = false;
			if($match->getRival1a() != $_POST["rival1a"] ||
				 $match->getRival1b() != $_POST["rival1b"] ||
			 	 $match->getRival2a() != $_POST["rival2a"] ||
			 	 $match->getRival2b() != $_POST["rival2b"]){
				$flag = true;
			}

			$match->setRival1a($_POST["rival1a"]);
			$match->setRival1b($_POST["rival1b"]);
			$match->setRival2a($_POST["rival2a"]);
			$match->setRival2b($_POST["rival2b"]);
			$match->setDate($_POST["date"]);
			$match->setTime($_POST["time"]);
			$match->setId_space($_POST["space"]);
			$match->setRound($_POST["round"]);
			$match->setCell($_POST["cell"]);
			$match->setSet1a($_POST["set1a"]);
			$match->setSet1b($_POST["set1b"]);
			$match->setSet2a($_POST["set2a"]);
			$match->setSet2b($_POST["set2b"]);
			$match->setSet3a($_POST["set3a"]);
			$match->setSet3b($_POST["set3b"]);
			$match->setSet4a($_POST["set4a"]);
			$match->setSet4b($_POST["set4b"]);
			$match->setSet5a($_POST["set5a"]);
			$match->setSet5b($_POST["set5b"]);
			$match->setId_draw($_POST["id_draw"]);

			try {
				// check if match exists in the database
				if(!$flag){
					// validate match object
					$match->validateMatch(); // if it fails, ValidationException

					$this->matchMapper->update($match);

					// POST-REDIRECT-GET
					// Everything OK, we will redirect the user to the list of posts
					// We want to see a message after redirection, so we establish
					// a "flash" message (which is simply a Session variable) to be
					// get in the view after redirection.
					$this->view->setFlash(sprintf(i18n("Match \"%s\" successfully updated."),i18n($match ->getDate())));

					// perform the redirection. More or less:
					// header("Location: index.php?controller=matches&action=show")
					// die();
					$this->view->redirect("matches", "show", "id_tournament=".$_REQUEST["id_tournament"], "id_draw=".$_REQUEST["id_draw"]);
				} else if($flag && !$this->matchMapper->matchExists($_POST["rival1a"], $_POST["rival1b"], $_POST["rival2a"], $_POST["rival2b"],
																						$_REQUEST["id_draw"])) {
					// validate match object
					$match->validateMatch(); // if it fails, ValidationException

					$this->matchMapper->update($match);

					// POST-REDIRECT-GET
					// Everything OK, we will redirect the user to the list of posts
					// We want to see a message after redirection, so we establish
					// a "flash" message (which is simply a Session variable) to be
					// get in the view after redirection.
					$this->view->setFlash(sprintf(i18n("Match \"%s\" successfully updated."),i18n($match ->getDate())));

					// perform the redirection. More or less:
					// header("Location: index.php?controller=matches&action=show")
					// die();
					$this->view->redirect("matches", "show", "id_tournament=".$_REQUEST["id_tournament"], "id_draw=".$_REQUEST["id_draw"]);
				}else {
					$errors = array();
					$errors["rival"] = "Match already exists";
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
		$spaces = $this->matchMapper->getSpaces();
		// Put the space variable visible to the view
		$this->view->setVariable("spaces", $spaces);

		//Get the id and name of the competitors
		$competitors = $this->matchMapper->getCompetitors();

		// Put the space variable visible to the view
		$this->view->setVariable("competitors", $competitors);

    // put the tournament id visible to the view
		$this->view->setVariable("tournament", $_REQUEST["id_tournament"]);

		// put the draw id visible to the view
		$this->view->setVariable("draw", $_REQUEST["id_draw"]);

		// Put the match object visible to the view
		$this->view->setVariable("match", $match);

		// Put the cell visible to the view
		$this->view->setVariable("cell", $_REQUEST["cell"]);

		// Put the round visible to the view
		$this->view->setVariable("round", $_REQUEST["round"]);

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

		if (!isset($_REQUEST["id_draw"])) {
			throw new Exception("draw id is mandatory");
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
				$this->view->setFlash(sprintf(i18n("Match \"%s\" successfully deleted."), $match->getDate()));

				// perform the redirection. More or less:
				// header("Location: index.php?controller=matches&action=show")
				// die();
				$this->view->redirect("matches", "show", "id_tournament=".$_REQUEST["id_tournament"], "id_draw=".$_REQUEST["id_draw"]);

			}catch(ValidationException $ex) {
				// Get the errors array inside the exepction...
				$errors = $ex->getErrors();
				// And put it to the view as "errors" variable
				$this->view->setVariable("errors", $errors);
			}
		}

		// put the matches object to the view
		$this->view->setVariable("tournament", $_REQUEST["id_tournament"]);

		// put the matches object to the view
		$this->view->setVariable("draw", $_GET["id_draw"]);

		// Put the user object visible to the view
		$this->view->setVariable("match", $match);
		// render the view (/view/users/add.php)
		$this->view->render("matches", "delete");
	}
}
