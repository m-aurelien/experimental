<?php
/**
 * Generated by eXtal
 * Date: 04/08/13
 * Time: 01:03
 */

namespace Application\OneTry\Models\DAO\Base;

class baseUsers {

	// **********************
	// CONST DECLARATION
	// **********************
	const ID = 'id';
	const FIRSTNAME = 'firstname';
	const LASTNAME = 'lastname';
	const USERNAME = 'username';
	const PASSWORD = 'password';

	// **********************
	// ATTRIBUTE DECLARATION
	// **********************
	protected $_id;
	protected $_firstname;
	protected $_lastname;
	protected $_username;
	protected $_password;

	// **********************
	// CONSTRUCTOR METHOD
	// **********************
	public function __construct(){
		// TODO: Implement toString() method.
	}

	// **********************
	// ACCESSOR METHODS
	// **********************
	public function id(){
		return $this->_id;
	}

	public function setId($id){
		$this->_id = $id;
	}

	public function firstname(){
		return $this->_firstname;
	}

	public function setFirstname($firstname){
		$this->_firstname = $firstname;
	}

	public function lastname(){
		return $this->_lastname;
	}

	public function setLastname($lastname){
		$this->_lastname = $lastname;
	}

	public function username(){
		return $this->_username;
	}

	public function setUsername($username){
		$this->_username = $username;
	}

	public function password(){
		return $this->_password;
	}

	public function setPassword($password){
		$this->_password = $password;
	}


	// **********************
	// TO STRING METHOD
	// **********************
	public function toString(){
		// TODO: Implement toString() method.
	}

	// **********************
	// SELECT METHOD / LOAD ALL
	// **********************
	public static function doSelect($sql){
		// TODO: Implement toString() method.
	}

	// **********************
	// RETRIEVE BY PRIMARY KEY
	// **********************
	public static function retrieveByPk($id){
		// TODO: Implement toString() method.
	}

	// **********************
	// SAVE
	// **********************
	public function save(){
		// TODO: Implement toString() method.
	}

	// **********************
	// DELETE
	// **********************
	public function delete(){
		// TODO: Implement toString() method.
	}

}