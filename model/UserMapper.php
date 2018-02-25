<?php
// file: model/UserMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

/**
* Class UserMapper
*
* Database interface for User entities
*
* @author lipido <lipido@gmail.com>
*/
class UserMapper {

	/**
	* Reference to the PDO connection
	* @var PDO
	*/
	private $db;

	public function __construct() {
		$this->db = PDOConnection::getInstance();
	}

	/**
	* Saves a User into the database
	*
	* @param User $user The user to be saved
	* @throws PDOException if a database error occurs
	* @return void
	*/
	/*public function save($user) {
		$stmt = $this->db->prepare("INSERT INTO users values (?,?)");
		$stmt->execute(array($user->getUsername(), $user->getPasswd()));
	}*/

	/**
	* Checks if a given username is already in the database
	*
	* @param string $username the username to check
	* @return boolean true if the username exists, false otherwise
	*/
	public function usernameExists($username) {
		$stmt = $this->db->prepare("SELECT count(username) FROM users where username=?");
		$stmt->execute(array($username));

		if ($stmt->fetchColumn() > 0) {
			return true;
		}
	}

	/**
	* Checks if a given pair of username/password exists in the database
	*
	* @param string $username the username
	* @param string $passwd the password
	* @return boolean true the username/passwrod exists, false otherwise.
	*/
	public function isValidUser($username, $passwd) {
		$stmt = $this->db->prepare("SELECT count(email) FROM users where email=? and password=?");
		$stmt->execute(array($username, md5($passwd)));

		if ($stmt->fetchColumn() > 0) {
			return true;
		}
	}

	/**
	* Checks if the user is an admin user
	*/
	public function isAdmin() {
		$user = $_SESSION ["currentuser"];
		$stmt = $this->db->prepare ( "SELECT * FROM users WHERE email=?" );
		$stmt->execute (array($user));
		$array = $stmt->fetch ( PDO::FETCH_ASSOC );

		if ($array ["is_administrator"] == 1) {
			return true;
		} else {
			return false;
		}
	}

	/**
	* Checks if the user is a trainer user
	*/
	public function isTrainer() {
		$user = $_SESSION ["currentuser"];
		$stmt = $this->db->prepare ( "SELECT * FROM users WHERE email=?" );
		$stmt->execute (array($user));
		$array = $stmt->fetch ( PDO::FETCH_ASSOC );

		if ($array ["is_trainer"] == 1) {
			return true;
		} else {
			return false;
		}
	}

	/**
	* Checks if the user is an athlete user
	*/
	public function isAthlete() {
		$user = $_SESSION ["currentuser"];
		$stmt = $this->db->prepare ( "SELECT * FROM users WHERE email=?" );
		$stmt->execute (array($user));
		$array = $stmt->fetch ( PDO::FETCH_ASSOC );

		if ($array ["is_athlete"] == 1) {
			return true;
		} else {
			return false;
		}
	}

	public function findType() {
		$user = $_SESSION ["currentuser"];
		$stmt = $this->db->prepare ( "SELECT * FROM users WHERE email=?" );
		$stmt->execute ( array (
				$user
		) );
		$array = $stmt->fetch ( PDO::FETCH_ASSOC );

		if ($array ["is_administrator"] == 1) {
			return "admin";
		} else if ($array ["is_trainer"] == 1) {
			return "trainer";
		} else {
			return "athlete";
		}
	}

	public function showAllUsers() {
		$stmt = $this->db->query ( "SELECT * FROM users WHERE is_active = 1 ORDER BY surname" );

		$users_db = $stmt->fetchAll ( PDO::FETCH_ASSOC );

		$users = array ();
		// var_dump($users_db);

		foreach ( $users_db as $user ) {
			array_push ( $users, new User ( $user ["email"], $user ["id_user"], $user ["name"],
																			$user ["surname"], $user ["dni"], $user ["password"],
																			$user ["telephone"], $user ["birthdate"], $user ["is_active"],
																			$user ["is_administrator"], $user ["is_trainer"], $user ["is_pupil"],
																			$user ["is_competitor"]));
		}

		return $users;
	}

	public function getUser($id_user) {
		$stmt = $this->db->prepare("SELECT * FROM users WHERE id_user=?");
		$stmt->execute(array($id_user));

		$user = $stmt->fetch ( PDO::FETCH_ASSOC );

		if ($user != null) {
			return new User($user ["email"], $user ["id_user"], $user ["name"],
											$user ["surname"], $user ["dni"], $user ["password"],
											$user ["telephone"], $user ["birthdate"],
											$user ["is_active"], $user ["is_administrator"],
											$user ["is_trainer"], $user ["is_pupil"],
											$user ["is_competitor"]);
		} else {
			return NULL;
		}
	}

	public function add($user) {
		$stmt = $this->db->prepare("INSERT INTO users(name, surname, dni, email, password, telephone,
																									birthdate, is_administrator, is_trainer,
																									is_pupil, is_competitor)
																values (?,?,?,?,?,?,?,?,?,?,?)");

		$stmt->execute(array($user->getName(), $user->getSurname(), $user->getDni(),
												 $user->getUsername (), md5($user->getPassword()),
												 $user->getTelephone(), $user->getBirthdate(),
												 $user->getIs_administrator(), $user->getIs_trainer(),
												 $user->getIs_pupil(), $user->getIs_competitor()));
		return $this->db->lastInsertId();
	}

	public function update($user) {
		$stmt = $this->db->prepare("UPDATE users set name = ?, surname = ?, dni = ?, email = ?, password = ?,
																								 telephone = ?, birthdate = ?, is_administrator = ?,
																								 is_trainer = ?, is_pupil = ?, is_competitor = ? WHERE id_user = ?");

		$stmt->execute(array($user->getName(), $user->getSurname(), $user->getDni(),
												 $user->getUsername(), md5($user->getPassword()), $user->getTelephone(),
												 $user->getBirthdate(), $user->getIs_administrator(),
												 $user->getIs_trainer(), $user->getIs_pupil(),
												 $user->getIs_competitor(), $user->getId_user()));
		return $this->db->lastInsertId();
	}

	public function sendTotrash($user) {
		//Borrado físico
		/*$stmt = $this->db->prepare ( "DELETE from USUARIO WHERE DNI=?" );
		$stmt->execute ( array (
				$user->getUsername ()
		) );
		$stmt2 = $this->db->prepare ( "DELETE from TLF_USUARIO WHERE DNI=?" );
		$stmt2->execute ( array (
				$user->getUsername ()
		) );*/
		//Borrado lógico
		$stmt = $this->db->prepare("UPDATE users set is_active=? where id_user=?");
		$stmt->execute(array(0,	$user->getId_user()));
	}




}
