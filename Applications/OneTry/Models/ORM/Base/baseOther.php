<?php
/**
 * Generated by eXtal
 * Date: 04/08/13
 * Time: 04:59
 */

namespace Applications\OneTry\Models\ORM\Base;

use Applications\OneTry\Models\ORM\eOther;
use Library\Application;

class baseOther {

	// **********************
	// CONST DECLARATION
	// **********************
	const TABLE = 'other';

	const ID = 'id';
	const USER_ID = 'user_id';
	const OTHER = 'other';

	// **********************
	// ATTRIBUTE DECLARATION
	// **********************
	protected $id;
	protected $user_id;
	protected $other;

	// **********************
	// CONSTRUCTOR METHOD
	// **********************
	public function __construct($id = null, $user_id = null, $other = null){
		$this->id = $id;
		$this->user_id = $user_id;
		$this->other = $other;
	}

	// **********************
	// ACCESSOR METHODS
	// **********************
	public function id(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}
	public function user_id(){
		return $this->user_id;
	}

	public function setUser_id($user_id){
		$this->user_id = $user_id;
	}
	public function other(){
		return $this->other;
	}

	public function setOther($other){
		$this->other = $other;
	}

	// **********************
	// SELECT METHOD / LOAD ALL
	// **********************
	public static function doSelect($sql, $param = array()){
		$stmt = Application::instance()->pdo()->mysql()->prepare($sql);
		$stmt->execute($param);
		return $stmt->fetchAllObjectOfClass("eOther");
	}

	// **********************
	// RETRIEVE BY PRIMARY KEY
	// **********************
	/**
	 * @return eOther
	 */
	public static function retrieveByPk($id, $user_id){
		$stmt = Application::instance()->pdo()->mysql()->prepare("SELECT * FROM other WHERE id = ? AND user_id = ?");
		$stmt->execute(array($id, $user_id));
		return $stmt->fetchObjectOfClass("eOther");
	}

	// **********************
	// INSERT
	// **********************
	public function insert(){
		$stmt = Application::instance()->pdo()->mysql()->prepare("INSERT INTO other (id, user_id, other) VALUES (?, ?, ?);");
		$stmt->execute(array($this->id, $this->user_id, $this->other));
	}

	// **********************
	// UPDATE
	// **********************
	public function update(){
		$stmt = Application::instance()->pdo()->mysql()->prepare("UPDATE other SET other = ?  WHERE id = ? AND user_id = ?;");
		$stmt->execute(array($this->other, $this->id, $this->user_id));
	}

	// **********************
	// DELETE
	// **********************
	public function delete(){
		$stmt = Application::instance()->pdo()->mysql()->prepare("DELETE FROM other WHERE id = ? AND user_id = ?;");
		$stmt->execute(array($this->id, $this->user_id));
	}

}