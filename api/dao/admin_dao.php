<?php
include_once "./../db/sql.php";
class AdminDao {
	private $sql = null;
	function __construct() {
		$this -> sql = new Sql();
	}

	public function findAdminByUserName($username) {
		$sql = "select * from `admin` where `username`='".trim($username)."'";
		$result = $this -> sql -> query($sql);
		return $result;
	}

}
?>