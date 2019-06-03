<?php
include_once "./../db/sql.php";
class GroupDao {
	private $sql = null;
	function __construct() {
		$this -> sql = new Sql();
	}

	public function findGroups($data) {
		$lim="";
		$name="g.`id`";
		$name_s="g.`id`";
		$task_id="g.`id`";
		$group_id="g.`id`";
		$student_id="g.`id`";
		if(isset($data["size"])&& !empty(trim($data["size"]))){
			$lim=" limit ".$data["page"].",".$data["size"];
		}
		if(isset($data["name"])&& !empty(trim($data["name"]))){
			$name="g.`name`='".$data["name"]."' ";
		}
		if(isset($data["name_s"])&& !empty(trim($data["name_s"]))){
			$name="g.`name` like '%".$data["name_s"]."%' ";
		}
		if(isset($data["student_id"])&& !empty(trim($data["student_id"]))){
			$student_id="g.`student_id` = '".$data["student_id"]."' ";
		}
		if(isset($data["task_id"])&& !empty(trim($data["task_id"]))){
			$task_id="g.`task_id` = '".$data["task_id"]."' ";
		}
		if(isset($data["group_id"])&& !empty(trim($data["group_id"]))){
			$group_id="g.`id` = '".$data["group_id"]."' ";
		}
		$sql = "select g.*,s.`name` as student from `group` g,`student` s 
					where g.student_id=s.id 
					and $task_id 
					and $group_id 
					and $name  
					and $name_s 
					and $student_id 
					$lim";
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