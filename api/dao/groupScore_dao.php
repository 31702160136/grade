<?php
include_once "./../db/sql.php";
class GroupScoreDao {
	private $sql = null;
	function __construct() {
		$this -> sql = new Sql();
	}

	function findGroupScores($data) {
		$lim="";
		$group_id="gs.`id`";
		$from_group_id="gs.`id`";
		if(isset($data["size"])&& !empty(trim($data["size"]))){
			$lim=" limit ".$data["page"].",".$data["size"];
		}
		if(isset($data["group_id"])&& !empty(trim($data["group_id"]))){
			$group_id="gs.group_id='".$data["group_id"]."' ";
		}
		if(isset($data["from_group_id"])&& !empty(trim($data["from_group_id"]))){
			$from_group_id="gs.from_group_id='".$data["from_group_id"]."' ";
		}
		$sql = "select gs.*,g.name as `name` from group_score gs,`group` g 
					where gs.from_group_id=g.id 
					and $group_id 
					and $from_group_id 
					$lim ";
		$result = $this -> sql -> query($sql);
		return $result;
	}

	function createGroupScore($data) {
		$array = array("table" => "group_score", "data" => $data);
		$result = $this -> sql -> insert($array);
		return $result;
	}
	//修改
	function modifyGroupScore($data, $id) {
		$array = array("id" => $id, "table" => "group_score", "data" => $data);
		$result = $this -> sql -> modify($array);
		return $result;
	}
}
?>