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
	* Loads all the notifications from the database.
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

		if($this->userMapper->findType() != "admin" && $this->userMapper->findType() != "trainer"){
			throw new Exception("You aren't an admin or a trainer. See all notifications requires be admin or trainer");
		}

		$id_notification= $_GET["id_notification"];

		// find the Notification object in the database
		$notification = $this->notificationMapper->view($id_notification);

		if ($notification == NULL) {
			throw new Exception("no such notification with id: ".$id_notification);
		}

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

		if($this->userMapper->findType() != "admin"){
			throw new Exception("You aren't an admin. Adding an notification requires be admin");
		}

		$notification = new Notification();

		if(isset($_POST["submit"])) { // reaching via HTTP notification...

			// populate the notification object with data form the form
			$notification->setName($_POST["name"]);
			$notification->setCapacity($_POST["capacity"]);
			$directory = 'multimedia/images/';

			$imageType = $_FILES['image']['type'];
			$imageName = $_FILES['image']['name'];
			$imageSize = $_FILES['image']['size'];
			$notification->setImage($directory.$_FILES['image']['name']);


			try {
			 	// check if notification exists in the database
				if(!$this->notificationMapper->notificationExists($_POST["name"])){
					//validate notification object
					$notification->validateNotification($imageName, $imageType, $imageSize, true); // if it fails, ValidationException

					//up the image to the server
					move_uploaded_file($_FILES['image']['tmp_name'],$directory.$imageName);

					//save the user object into the database
					$this->notificationMapper->add($notification);

					// POST-REDIRECT-GET
					// Everything OK, we will redirect the user to the list of posts
					// We want to see a message after redirection, so we establish
					// a "flash" message (which is simply a Session variable) to be
					// get in the view after redirection.
					$this->view->setFlash(sprintf(i18n("Notification \"%s\" successfully added."),$notification ->getName()));

					// perform the redirection. More or less:
					// header("Location: index.php?controller=notifications&action=show")
					// die();
					$this->view->redirect("notifications", "show");
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

		// Put the notification object visible to the view
		$this->view->setVariable("notification", $notification);
		// render the view (/view/notifications/add.php)
		$this->view->render("notifications", "add");
	}

	/**
	* Action to edit a notification
	*
	* When called via GET, it shows the add form
	* When called via POST, it modifies the notification in the database.
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>id: Id of the notification (via HTTP POST and GET)</li>
	* <li>name: Name of the notification (via HTTP POST)</li>
	* <li>Capacity: Capacity of the notification (via HTTP POST)</li>
	* <li>imageType: Image type of the notification (via FILES POST)</li>
	* <li>imageName: Image name of the notification (via FILES POST)</li>
	* <li>imageSize: Image size of the notification (via FILES POST)</li>
	* </ul>
	*
	* @throws Exception if no user is in session
	* @throws Exception if a notification id is not provided
	* @throws Exception if the type is not admin
	* @throws Exception if there is not any notification with the provided id
	* @return void
	*/
	public function update(){
		if (!isset($_REQUEST["id_notification"])) {
			throw new Exception("A id notification is mandatory");
		}

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding users requires login");
		}

		if($this->userMapper->findType() != "admin"){
			throw new Exception("You aren't an admin. Adding an user requires be admin");
		}

		$id_notification = $_REQUEST["id_notification"];
		$notification = $this->notificationMapper->view($id_notification);

		if ($notification == NULL) {
			throw new Exception("no such notification with id: ".$id_notification);
		}

		if(isset($_POST["submit"])) { // reaching via HTTP user...

			// populate the notification object with data form the form

			// put the flag to true if the user changes the notification name
			$flag = false;
			if($notification->getName() != $_POST["name"]){
				$flag = true;
			}

			$notification->setName($_POST["name"]);

			$notification->setCapacity($_POST["capacity"]);
			$directory = 'multimedia/images/';
			$imageType = $_FILES['image']['type'];
			$imageName = $_FILES['image']['name'];
			$imageSize = $_FILES['image']['size'];
			if($_FILES['image']['name'] != NULL){
				$notification->setImage($directory.$_FILES['image']['name']);
				$checkImage = true;
			}else{
				$checkImage = false;
			}
			try {
				// check if notification exists in the database
				if(!$flag){
					// validate notification object
					$notification->validateNotification($imageName, $imageType, $imageSize, $checkImage); // if it fails, ValidationException

					//up the image to the server
					move_uploaded_file($_FILES['image']['tmp_name'],$directory.$imageName);

					//save the notification object into the database
					$this->notificationMapper->update($notification);

					// POST-REDIRECT-GET
					// Everything OK, we will redirect the user to the list of posts
					// We want to see a message after redirection, so we establish
					// a "flash" message (which is simply a Session variable) to be
					// get in the view after redirection.
					$this->view->setFlash(sprintf(i18n("Notification \"%s\" successfully updated."),$notification ->getName()));

					// perform the redirection. More or less:
					// header("Location: index.php?controller=notifications&action=show")
					// die();
					$this->view->redirect("notifications", "show");
				} else if($flag && !$this->notificationMapper->notificationExists($_POST["name"])){
					// validate notification object
					$notification->validateNotification($imageName, $imageType, $imageSize, $checkImage); // if it fails, ValidationException

					//up the image to the server
					move_uploaded_file($_FILES['image']['tmp_name'],$directory.$imageName);

					//save the notification object into the database
					$this->notificationMapper->update($notification);

					// POST-REDIRECT-GET
					// Everything OK, we will redirect the user to the list of posts
					// We want to see a message after redirection, so we establish
					// a "flash" message (which is simply a Session variable) to be
					// get in the view after redirection.
					$this->view->setFlash(sprintf(i18n("Notification \"%s\" successfully updated."),$notification ->getName()));

					// perform the redirection. More or less:
					// header("Location: index.php?controller=notifications&action=show")
					// die();
					$this->view->redirect("notifications", "show");
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
		$this->view->setVariable("notification", $notification);
		// render the view (/view/users/add.php)
		$this->view->render("notifications", "update");
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

		if($this->userMapper->findType() != "admin"){
			throw new Exception("You aren't an admin. Adding a notification requires be admin");
		}

		// Get the Notification object from the database
		$id_notification = $_REQUEST["id_notification"];
		$notification = $this->notificationMapper->view($id_notification);

		// Does the notification exist?
		if ($notification == NULL) {
			throw new Exception("no such user with id: ".$id_notification);
		}

		if (isset($_POST["submit"])) {

			try {
				// Delete the Notification object from the database
				$this->notificationMapper->delete($notification);

				// POST-REDIRECT-GET
				// Everything OK, we will redirect the user to the list of posts
				// We want to see a message after redirection, so we establish
				// a "flash" message (which is simply a Session variable) to be
				// get in the view after redirection.
				$this->view->setFlash(sprintf(i18n("Notification \"%s\" successfully deleted."), $notification->getName()));

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

		if($this->userMapper->findType() != "admin" && $this->userMapper->findType() != "trainer"){
			throw new Exception("You aren't an admin or a trainer. See all notifications requires be admin or trainer");
		}

		if(isset($_POST["submit"])) {
			$query = "";
			$flag = 0;

			if ($_POST["name"]){
				$query .= "name LIKE '%". $_POST["name"]."%'";
				$flag = 1;
			}

			if (empty($query)) {
				$notifications = $this->notificationMapper->show();
			} else {
				$notifications = $this->notificationMapper->search($query);
			}
			$this->view->setVariable("notifications", $notifications);
			$this->view->render("notifications", "show");
		}else {
			// render the view (/view/notifications/search.php)
			$this->view->render("notifications", "search");
		}
	}
}
