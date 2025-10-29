<?php

namespace Models;

use Exception;
use PDO;

class User extends Database
{
	private $id;
	private $firstname;
	private $lastname;
	private $email;
	private $password;


	public function setFirstname($value)
	{
		if (empty($value)) throw new Exception('Le prénom est obligatoire');
		if (strlen($value) > 50) throw new Exception('Le prénom doit faire 50 max');
		$this->firstname = htmlspecialchars($value);
	}

	public function getFirstname()
	{
		return $this->firstname;
	}

	public function setLastname($value)
	{
		if (empty($value)) throw new Exception('Le nom de famille est obligatoire');
		if (strlen($value) > 50) throw new Exception('Le nom de famille doit faire 50 max');
		$this->lastname = htmlspecialchars($value);
	}

	public function getLastname()
	{
		return $this->lastname;
	}

	public function setEmail($value)
	{
		if (empty($value)) throw new Exception('L email est obligatoire');
		if (strlen($value) > 255) throw new Exception('L email doit faire 255 max');
		if (!filter_var($value, FILTER_VALIDATE_EMAIL)) throw new Exception('Email invalide');
		$this->email = htmlspecialchars($value);
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function setPassword($value)
	{
		if (empty($value)) throw new Exception('Le mot de passe est obligatoire');
		if (strlen($value) <= 3) throw new Exception('Le mot de passe doit faire 3 min');
		$this->password = password_hash($value, PASSWORD_DEFAULT);
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function checkConfirmPassword($value)
	{
		if (empty($value) || empty($this->password)) throw new Exception('Le mot de passe et la confirmation de mot de passe est obligatoire');
		if (password_verify($value, $this->password)) throw new Exception('La confirmation de mot de passe ne correspond pas');
		return true;
	}

	/**
	 * Get user by id
	 * @param int $id - id of the user to get
	 * @return object|bool - user or false
	 */
	public function getUser($id)
	{

		$sql = "SELECT * FROM users WHERE `id` :id";
		$queryExecute = $this->db->prepare($sql);
		$queryExecute->bindValue(':id', $id, PDO::PARAM_INT);

		$queryExecute->execute();
		return $queryExecute->fetch(PDO::FETCH_OBJ);
	}

	/**
	 * get user by email
	 * @param string $email - email of the user to get
	 * @return object|bool - user or false
	 */
	public function getUserByEmail()
	{
		$sql = "SELECT * FROM users WHERE `email` = :email";
		$queryExecute = $this->db->prepare($sql);
		$queryExecute->bindValue(':email', $this->email, PDO::PARAM_STR);

		$queryExecute->execute();
		return $queryExecute->fetch(PDO::FETCH_OBJ);
	}

	/**
	 * Create user
	 * @param string $firstname
	 * @param string $lastname
	 * @param string $email
	 * @param string $password
	 * @return bool
	 */
	public function createUser()
	{
		if ($this->getUserByEmail()) throw new Exception('Email déjà utilisé');

		$sql = "INSERT INTO users (firstname, lastname, email, password) VALUES (:firstname, :lastname, :email, :password)";
		$queryExecute = $this->db->prepare($sql);
		$queryExecute->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
		$queryExecute->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
		$queryExecute->bindValue(':email', $this->email, PDO::PARAM_STR);
		$queryExecute->bindValue(':password', $this->password, PDO::PARAM_STR);

		return $queryExecute->execute();
	}

	/**
	 * Delete user
	 * @param int $id - id of the user to delete
	 * @return bool
	 */
	public function deleteUser($id)
	{
		$sql = "DELETE FROM users WHERE `id` = :id";
		$queryExecute = $this->db->prepare($sql);
		$queryExecute->bindValue(':id', $id, PDO::PARAM_INT);

		return $queryExecute->execute();
	}
}
