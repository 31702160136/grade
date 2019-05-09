<?php
include_once "./../db/sql.php";
class GroupScoreDao {
	private $sql = null;
	function __construct() {
		$this -> sql = new Sql();
	}

	function findGroupScoreByGroupId($GroupId,$page=null,$size=null) {
		if(isset($page)&&isset($size)){
			$sql = "select * from `group_score` where `group_id`='" . $GroupId."' limit ".$page.",".$size;
		}else{
			$sql = "select * from `group_score` where `group_id`='" . $GroupId."'";
		}
		$result = $this -> sql -> query($sql);
		return $result;
	}
	
	function findGroupScoreByGroupIdAndFromGroupId($data) {
		$sql = "select * from `group_score` where `group_id`='" . $data["group_id"]."' and `from_group_id`='".$data["from_group_id"]."'";
		$result = $this -> sql -> query($sql);
		return $result;
	}

	function createGroupScore($data) {
		$array = array("table" => "group_score", "data" => $data);
		$result = $this -> sql -> insert($array);
		return $result;
	}

}
?>