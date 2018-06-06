<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../model/Notification.php");
require_once(__DIR__."/../model/NotificationMapper.php");
require_once(__DIR__."/../model/UserMapper.php");

require_once(__DIR__."/../controller/BaseController.php");

/**
* Class NotificationsController
*
* Controller to notifications CRUD
*
* @author braisda <braisda@gmail.com>
*/
class NotificationsController extends BaseController {

	/**
	* Reference to the NotificationMapper to interact
	* with the database
	*
	* @var notificationMapper
	*/
	private $notificationMapper;
  private $userMapper;

	public function __construct() {
		parent::__construct();

		$this->notificationMapper = new NotificationMapper();
    $this->userMapper = new UserMapper();
	}

	/**
	* Action to list notifications
	*
	* Loads the received notifications from the database.
	* No HTTP parameters are needed.
	*
	*/
	public function show(){
		if(!isset($this->currentUser)){
			throw new Exception("Not in session. Show notifications requires login");
		}

		if($this->userMapper->findType() != "admin" && $this->userMapper->findType() != "trainer"
      && $this->userMapper->findType() != "pupil" && $this->userMapper->findType() != "competitor"){
			throw new Exception("You aren't an admin, a trainer, a pupil or a competitor. See all notifications requires be admin, trainer, pupil or competitor");
		}

    $users = $this->notificationMapper->getUsers();
    $id_user = $this->notificationMapper->getSender($this->currentUser->getUsername())["id_user"];

		$notifications = $this->notificationMapper->show($id_user);

		// put the notifications object to the view
		$this->view->setVariable("notifications", $notifications);

    // put the users object to the view
		$this->view->setVariable("users", $users);

		// render the view (/view/notifications/show.php)
		$this->view->render("notifications", "show");
	}

	/**
	* Action to view a provided notification
	*
	* This action should only be called via GET
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>id: Id of the notification (via HTTP GET)</li>
	* </ul>
	*
	* @throws Exception If no such notification of the provided id is found
	* @return void
	*
	*/
	public function view(){
		if (!isset($_GET["id_notification"])) {
			throw new Exception("id is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. View Notifications requires login");
		}

		if($this->userMapper->findType() != "admin" && $this->userMapper->findType() != "trainer"
      && $this->userMapper->findType() != "pupil" && $this->userMapper->findType() != "competitor"){
			throw new Exception("You aren't an admin, a trainer, a pupil or a competitor. See all notifications requires be admin, trainer, pupil or competitor");
		}

		$id_notification= $_GET["id_notification"];

		// find the Notification object in the database
		$notification = $this->notificationMapper->view($id_notification);
		$this->notificationMapper->setRead($id_notification);

		if ($notification == NULL) {
			throw new Exception("no such notification with id: ".$id_notification);
		}

		$senderName = $this->notificationMapper->getSenderName($notification->getSender());

		// put the notification object to the view
		$this->view->setVariable("senderName", $senderName);

		// put the notification object to the view
		$this->view->setVariable("notification", $notification);

		// render the view (/view/notifications/view.php)
		$this->view->render("notifications", "view");
	}

	/**
	* Action to add a new notification
	*
	* When called via GET, it shows the add form
	* When called via POST, it adds the notification to the database
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>name: Name of the notification (via HTTP POST)</li>
	* <li>capacity: Capacity of the notification (via HTTP POST)</li>
	* <li>imageType: Image type of the notification (via FILES POST)</li>
	* <li>imageName: Image name of the notification (via FILES POST)</li>
	* <li>imageSize: Image size of the notification (via FILES POST)</li>
	* </ul>
	*
	* @throws Exception if no user is in session
	* @throws Exception if the type is not admin
	* @return void
	*/
	public function add(){
		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding notifications requires login");
		}

		if($this->userMapper->findType() != "admin" && $this->userMapper->findType() != "trainer"
      && $this->userMapper->findType() != "pupil" && $this->userMapper->findType() != "competitor"){
			throw new Exception("You aren't an admin, a trainer, a pupil or a competitor. See all notifications requires be admin, trainer, pupil or competitor");
		}

		$notification = new Notification();

		if(isset($_POST["submit"])) { // reaching via HTTP notification...

			// populate the notification object with data form the form
			$notification->setTitle($_POST["title"]);
			$notification->setBody($_POST["body"]);
			$notification->setDate(date("Y"."-"."m"."-"."d"));
			$notification->setTime(date("H".":"."i".":"."s"));
			$notification->setIs_read(0);
			$id_sender = $this->notificationMapper->getId_user($this->currentUser->getUsername())->getId_user();
			$notification->setSender($id_sender);
			$id_receiver = $this->notificationMapper->getId_user($_POST["receiver"])->getId_user();
			$notification->setReceiver($id_receiver);


			try {
				//validate notification object
				$notification->validateNotification(); // if it fails, ValidationException

				//save the user object into the database
				$this->notificationMapper->add($notification);

				// POST-REDIRECT-GET
				// Everything OK, we will redirect the user to the list of posts
				// We want to see a message after redirection, so we establish
				// a "flash" message (which is simply a Session variable) to be
				// get in the view after redirection.
				$this->view->setFlash(sprintf(i18n("Notification \"%s\" successfully added."),$notification ->getTitle()));

				// perform the redirection. More or less:
				// header("Location: index.php?controller=notifications&action=show")
				// die();
				$this->view->redirect("notifications", "show");

			}catch(ValidationException $ex) {
				// Get the errors array inside the exepction...
				$errors = $ex->getErrors();
				// And put it to the view as "errors" variable
				$this->view->setVariable("errors", $errors);
			}
		}

		// Put the notification object visible to the view
		$this->view->setVariable("notification", $notification);
		// render the view (/view/notifications/add.php)
		$this->view->render("notifications", "add");
	}

	/**
	* Action to delete a notification
	*
	* This action should only be called via HTTP POST
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>id: Id of the notification (via HTTP POST and GET)</li>
	* </ul>
	*
	* @throws Exception if no user is in session
	* @throws Exception if a notification id is not provided
	* @throws Exception if the type is not admin
	* @throws Exception if there is not any notification with the provided id
	* @return void
	*/
	public function delete() {

		if (!isset($_REQUEST["id_notification"])) {
			throw new Exception("A id is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding notifications requires login");
		}

		if($this->userMapper->findType() != "admin" && $this->userMapper->findType() != "trainer"
      && $this->userMapper->findType() != "pupil" && $this->userMapper->findType() != "competitor"){
			throw new Exception("You aren't an admin, a trainer, a pupil or a competitor. See all notifications requires be admin, trainer, pupil or competitor");
		}

		// Get the Notification object from the database
		$id_notification = $_REQUEST["id_notification"];
		$notification = $this->notificationMapper->view($id_notification);

		// Does the notification exist?
		if ($notification == NULL) {
			throw new Exception("no such user with id: ".$id_notification);
		}

		$senderName = $this->notificationMapper->getSenderName($notification->getSender());

		if (isset($_POST["submit"])) {

			try {
				// Delete the Notification object from the database
				$this->notificationMapper->delete($notification);

				// POST-REDIRECT-GET
				// Everything OK, we will redirect the user to the list of posts
				// We want to see a message after redirection, so we establish
				// a "flash" message (which is simply a Session variable) to be
				// get in the view after redirection.
				$this->view->setFlash(sprintf(i18n("Notification \"%s\" successfully deleted."), $notification->getTitle()));

				// perform the redirection. More or less:
				// header("Location: index.php?controller=notifications&action=show")
				// die();
				$this->view->redirect("notifications", "show");

			}catch(ValidationException $ex) {
				// Get the errors array inside the exepction...
				$errors = $ex->getErrors();
				// And put it to the view as "errors" variable
				$this->view->setVariable("errors", $errors);
			}
		}

		// put the notification object to the view
		$this->view->setVariable("senderName", $senderName);

		// Put the user object visible to the view
		$this->view->setVariable("notification", $notification);
		// render the view (/view/users/add.php)
		$this->view->render("notifications", "delete");

	}

	/**
	* Action to list notifications that match a search pattern
	*
	* This action should only be called via HTTP POST
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>name: Name of the notification (via HTTP POST)</li>
	* </ul>
	*
	* @throws Exception if no user is in session
	* @throws Exception if the type is not admin
	* @return void
	*/
	public function search() {
		if(!isset($this->currentUser)){
			throw new Exception("Not in session. Show notifications requires login");
		}

		if($this->userMapper->findType() != "admin" && $this->userMapper->findType() != "trainer"
      && $this->userMapper->findType() != "pupil" && $this->userMapper->findType() != "competitor"){
			throw new Exception("You aren't an admin, a trainer, a pupil or a competitor. See all notifications requires be admin, trainer, pupil or competitor");
		}

		if(isset($_POST["submit"])) {
			$query = "";
			$flag = 0;

			if ($_POST["title"]){
				$query .= "title LIKE '%". $_POST["title"]."%'";
				$flag = 1;
			}

			if ($_POST["body"]){
				$query .= "body LIKE '%". $_POST["body"]."%'";
				$flag = 1;
			}

			if ($_POST["sender"]){
				$id_receiver = $this->notificationMapper->getId_user($_POST["sender"])->getId_user();
				$query .= "sender LIKE '%".$id_receiver."%'";
				$flag = 1;
			}

			if (empty($query)) {
				$id_user = $this->notificationMapper->getSender($this->currentUser->getUsername())["id_user"];
				$notifications = $this->notificationMapper->show($id_user);
				$users = $this->notificationMapper->getUsers();
				// put the users object to the view
				$this->view->setVariable("users", $users);
			} else {
				$notifications = $this->notificationMapper->search($query);
				$users = $this->notificationMapper->getUsers();
				// put the users object to the view
				$this->view->setVariable("users", $users);
			}
			$this->view->setVariable("notifications", $notifications);
			$this->view->render("notifications", "show");
		}else {
			// render the view (/view/notifications/search.php)
			$this->view->render("notifications", "search");
		}
	}
}
