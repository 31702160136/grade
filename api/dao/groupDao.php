<?php
include_once "./../db/sql.php";
class GroupDao {
	private $sql = null;
	function __construct() {
		$this -> sql = new Sql();
	}

	public function findGroups($page,$size) {
		if(isset($page)&&isset($size)){
			$sql = "select * from `group` limit ".$page.",".$size;
		}else{
			$sql = "select * from `group`";
		}
		$result = $this -> sql -> query($sql);
		return $result;
	}
	function sreachGroup($data) {
		$sql = "select * from `group` where `task_id`='".$data["task_id"]."' and `".$data["key"]."` like '%" . $data["value"]."%'";
		$result = $this -> sql -> query($sql);
		return $result;
	}
	function findGroupByTaskId($taskId,$page=null,$size=null) {
		if(isset($page)&&isset($size)){
			$sql = "select * from `group` where `task_id`='" . $taskId."' limit ".$page.",".$size;
		}else{
			$sql = "select * from `group` where `task_id`='" . $taskId."'";
		}
		$result = $this -> sql -> query($sql);
		return $result;
	}

	function findGroupByName($name) {
		$sql = "select * from `group` where `name`='" . $name . "'";
		$result = $this -> sql -> query($sql);
		return $result;
	}
	
	function findGroupById($id) {
		$sql = "select * from `group` where `id`='" . $id . "'";
		$result = $this -> sql -> query($sql);
		return $result;
	}

	function createGroup($data) {
		$array = array("table" => "group", "data" => $data);
		$result = $this -> sql -> insert($array);
		return $result;
	}

	//修改小组
	function modifyGroup($data, $id) {
		$array = array("id" => $id, "table" => "group", "data" => $data);
		$result = $this -> sql -> modify($array);
		return $result;
	}
	
	//删除小组
	function deleteGroupById($data){
		$array=array(
			"table"=>"group",
			"fields"=>"id",
			"data"=>$data
		);
		$result=$this->sql->delete($array);
		return $result;
	}

}
?>