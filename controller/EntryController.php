<?php
//file: controller/EntryController.php
require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");
require_once(__DIR__."/../model/UserMapper.php");

class EntryController extends BaseController {

	private $userMapper;

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		if (isset($_SESSION['currentuser'])){
			$this->view->render("entry","home");
		}else{
			$this->view->render("entry","login");
		}
	}

	public function login() {
		// render the view (/view/login/register.php)
		$this->view->render("entry", "login");
	}

	public function home(){
		if (isset($_SESSION["currentuser"])){
			$this->userMapper = new UserMapper();

			$_SESSION["admin"] = $this->userMapper->isAdmin();
			$_SESSION["trainer"] = $this->userMapper->isTrainer();
			$_SESSION["pupil"] = $this->userMapper->isPupil();
			$_SESSION["competitor"] = $this->userMapper->isCompetitor();

			$this->view->render("entry","home");
		}else{
			//throw new Exception("Not in session. Show menu requires login");
		}
	}
}
