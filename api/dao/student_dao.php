<?php
include_once "./../db/sql.php";
class StudentDao {
	private $sql = null;
	function __construct() {
		$this -> sql = new Sql();
	}

	public function findStudents($data) {
		$lim="";
		$id="`id`";
		$name="`id`";
		$username="`id`";
		$username_s="`id`";
		$only_show_no_task_student="`id`";
		if(isset($data["page"])&&isset($data["size"])){
			$lim=" limit ".trim($data["page"]).",".trim($data["size"]);
		}
		if(isset($data["name"])){
			$name="`name` like '%".trim($data["name"])."%' ";
		}
		if(isset($data["username_s"])){
			$username_s="`username` like '%".trim($data["username_s"])."%' ";
		}
		if(isset($data["username"])){
			$username="`username`='".trim($data["username"])."' ";
		}
		if(isset($data["id"])){
			$id="`id`='".trim($data["id"])."' ";
		}
		$task_id = null;
		if(isset($data["task_id"])){
			$task_id=trim($data["task_id"]);
		}
		if(isset($data["only_show_no_task_student"])){
			$only_show_no_task_student="`class` = (select `class` from `group` as g,`student` as s where g.`task_id`= $task_id and g.`student_id`=s.`id` LIMIT 1 ) and NOT EXISTS (select 1 from `student_group` where EXISTS (SELECT `id` from `group` where `task_id`= $task_id and `student_group`.`group_id`=`group`.`id`) and `student`.`id` = `student_group`.`student_id`)";
		}
		
		$sql="select * from `student` 
				where $name 
				and $id 
				and $username 
				and $username_s 
				and $only_show_no_task_student 
				ORDER BY username 
				$lim ";
		$result = $this -> sql -> query($sql);
		return $result;
	}
	
	function createStudent($data) {
		$array = array(
			"table" => "student",
			"data" => $data
		);
		$result = $this -> sql -> insert($array);
		return $result;
	}

	//修改学生信息
	function modifyStudentInfo($data, $id) {
		$array = array("id" => $id, "table" => "student", "data" => $data);
		$result = $this -> sql -> modify($array);
		return $result;
	}
	//删除栏目
	function deleteStudentById($data){
		$array=array(
			"table"=>"student",
			"fields"=>"id",
			"data"=>$data
		);
		$result=$this->sql->delete($array);
		return $result;
	}

}
?>