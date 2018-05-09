<?php
// file: model/UserMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

/**
* Class UserMapper
*
* Database interface for User entities
*
* @author braisda <braisda@gmail.com>
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
	* Checks if a given username is already in the database
	*
	* @param string $username the username to check
	* @return boolean true if the username exists, false otherwise
	*/
	public function usernameExists($username) {
		$stmt = $this->db->prepare("SELECT count(email) FROM users where email=?");
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
	* Checcks if the current user is a admin user
	*
	* @throws PDOException if a database error occurs
	* @return boolean true if the user is admin, false otherwise.
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
	* Checcks if the current user is a trainer user
	*
	* @throws PDOException if a database error occurs
	* @return boolean true if the user is trainer, false otherwise.
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
	* Checcks if the current user is a pupil user
	*
	* @throws PDOException if a database error occurs
	* @return boolean true if the user is pupil, false otherwise.
	*/
	public function isPupil() {
		$user = $_SESSION ["currentuser"];
		$stmt = $this->db->prepare ( "SELECT * FROM users WHERE email=?" );
		$stmt->execute (array($user));
		$array = $stmt->fetch ( PDO::FETCH_ASSOC );

		if ($array ["is_pupil"] == 1 && $array ["is_competitor"] == 0) {
			return true;
		} else {
			return false;
		}
	}

	/**
	* Checcks if the current user is a competitor user
	*
	* @throws PDOException if a database error occurs
	* @return boolean true if the user is competitor, false otherwise.
	*/
	public function isCompetitor() {
		$user = $_SESSION ["currentuser"];
		$stmt = $this->db->prepare ( "SELECT * FROM users WHERE email=?" );
		$stmt->execute (array($user));
		$array = $stmt->fetch ( PDO::FETCH_ASSOC );

		if ($array ["is_competitor"] == 1 && $array ["is_pupil"] == 0) {
			return true;
		} else {
			return false;
		}
	}

	/**
	* Checcks if the current user is a pupil and competitor user
	*
	* @throws PDOException if a database error occurs
	* @return boolean true if the user is pupil and competitor, false otherwise.
	*/
	public function isPupilCompetitor() {
		$user = $_SESSION ["currentuser"];
		$stmt = $this->db->prepare ( "SELECT * FROM users WHERE email=?" );
		$stmt->execute (array($user));
		$array = $stmt->fetch ( PDO::FETCH_ASSOC );

		if ($array ["is_pupil"] == 1 && $array ["is_competitor"] == 1) {
			return true;
		} else {
			return false;
		}
	}

	/**
	* Finds the type of the current user
	*
	* @throws PDOException if a database error occurs
	* @return string the type of the current user
	*/
	public function findType() {
		$user = $_SESSION ["currentuser"];
		$stmt = $this->db->prepare ( "SELECT * FROM users WHERE email=?" );
		$stmt->execute(array($user));
		$array = $stmt->fetch ( PDO::FETCH_ASSOC );

		if ($array ["is_administrator"] == 1) {
			return "admin";
		} else if ($array ["is_trainer"] == 1) {
			return "trainer";
		} else if ($array ["is_pupil"] == 1) {
			return "pupil";
		} else {
			return "competitor";
		}
	}

	/**
	* Retrieves all users
	*
	* @throws PDOException if a database error occurs
	* @return mixed Array of User instances
	*/
	public function show() {
		$stmt = $this->db->query ( "SELECT * FROM users WHERE is_active = 1 ORDER BY surname" );

		$users_db = $stmt->fetchAll ( PDO::FETCH_ASSOC );

		$users = array ();

		foreach ( $users_db as $user ) {
			array_push ( $users, new User ( $user ["email"], $user ["id_user"], $user ["name"],
																			$user ["surname"], $user ["dni"], $user ["password"],
																			$user ["telephone"], $user ["birthdate"], $user ["image"],
																			$user ["is_active"], $user ["is_administrator"], $user ["is_trainer"],
																			$user ["is_pupil"], $user ["is_competitor"]));
		}

		return $users;
	}

	/**
	* Loads a User from the database given its id
	*
	* @param string $id_user The id of the user
	* @throws PDOException if a database error occurs
	* @return User The User instances. NULL if the Post is not found
	*
	*/
	public function getUser($id_user) {
		$stmt = $this->db->prepare("SELECT * FROM users WHERE id_user=?");
		$stmt->execute(array($id_user));

		$user = $stmt->fetch ( PDO::FETCH_ASSOC );

		if ($user != null) {
			return new User($user ["email"], $user ["id_user"], $user ["name"],
											$user ["surname"], $user ["dni"], $user ["password"],
											$user ["telephone"], $user ["birthdate"], $user ["image"],
											$user ["is_active"], $user ["is_administrator"],
											$user ["is_trainer"], $user ["is_pupil"],
											$user ["is_competitor"]);
		} else {
			return NULL;
		}
	}

	/**
	* Loads a User from the database given its id
	*
	* @param string $username The username of the user
	* @throws PDOException if a database error occurs
	* @return User The User instances. NULL if the Post is not found
	*
	*/
	public function getProfile($username) {
		$stmt = $this->db->prepare("SELECT * FROM users WHERE email=?");
		$stmt->execute(array($username));

		$user = $stmt->fetch ( PDO::FETCH_ASSOC );

		if ($user != null) {
			return new User($user ["email"], $user ["id_user"], $user ["name"],
											$user ["surname"], $user ["dni"], $user ["password"],
											$user ["telephone"], $user ["birthdate"], $user ["image"],
											$user ["is_active"], $user ["is_administrator"],
											$user ["is_trainer"], $user ["is_pupil"],
											$user ["is_competitor"]);
		} else {
			return NULL;
		}
	}

	/**
	* Saves a User into the database
	*
	* @param User $user The user to be saved
	* @throws PDOException if a database error occurs
	* @return int The new user id
	*/
	public function add($user) {
		$stmt = $this->db->prepare("INSERT INTO users(name, surname, dni, email, password, telephone,
																									birthdate, image, is_administrator, is_trainer,
																									is_pupil, is_competitor)
																values (?,?,?,?,?,?,?,?,?,?,?,?)");

		$stmt->execute(array($user->getName(), $user->getSurname(), $user->getDni(),
												 $user->getUsername (), md5($user->getPassword()),
												 $user->getTelephone(), $user->getBirthdate(), $user->getImage(),
												 $user->getIs_administrator(), $user->getIs_trainer(),
												 $user->getIs_pupil(), $user->getIs_competitor()));
		return $this->db->lastInsertId();
	}

	/**
	* Updates a User in the database
	*
	* @param User $user The user to be saved
	* @throws PDOException if a database error occurs
	* @return int The modified id user
	*/
	public function update($user) {
		$stmt = $this->db->prepare("UPDATE users set name = ?, surname = ?, dni = ?, email = ?, password = ?,
																								 telephone = ?, birthdate = ?, image = ?, is_administrator = ?,
																								 is_trainer = ?, is_pupil = ?, is_competitor = ? WHERE id_user = ?");

		$stmt->execute(array($user->getName(), $user->getSurname(), $user->getDni(),
												 $user->getUsername(), $user->getPassword(), $user->getTelephone(),
												 $user->getBirthdate(), $user->getImage(), $user->getIs_administrator(),
												 $user->getIs_trainer(), $user->getIs_pupil(),
												 $user->getIs_competitor(), $user->getId_user()));
		return $this->db->lastInsertId();
	}

	/**
	* Deletes a User into the database
	*
	* @param User $post The user to be deleted
	* @throws PDOException if a database error occurs
	* @return void
	*/
	public function delete($user) {
		//Borrado lógico
		$stmt = $this->db->prepare("UPDATE users set is_active=? where id_user=?");
		$stmt->execute(array(0,	$user->getId_user()));
	}

	/**
	* Searhs a User into the database
	*
	* @param string $query The user to be searched
	* @throws PDOException if a database error occurs
	* @return mixed Array of User instances that match the search parameter
	*/
	public function search($query) {
        $search_query = "SELECT * FROM users WHERE ". $query." AND is_active = 1 ORDER BY surname";
        $stmt = $this->db->prepare($search_query);
        $stmt->execute();
        $users_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $users = array();

        foreach ($users_db as $user) {
            array_push($users, new User($user ["email"], $user ["id_user"], $user ["name"],
																				$user ["surname"], $user ["dni"], $user ["password"],
																				$user ["telephone"], $user ["birthdate"], $user ["image"],
																				$user ["is_active"], $user ["is_administrator"], $user ["is_trainer"],
																				$user ["is_pupil"], $user ["is_competitor"]));
        }

        return $users;
    }
}
