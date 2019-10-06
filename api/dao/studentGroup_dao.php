<?php
include_once "./../db/sql.php";
class StudentGroupDao {
	private $sql = null;
	function __construct() {
		$this -> sql = new Sql();
	}

	function findMember($data) {
		$lim="";
		$id="sg.`id`";
		$name_s="sg.`id`";
		$username="sg.`id`";
		$username_s="sg.`id`";
		$student_id="sg.`id`";
		$group_id="sg.`id`";
		$task_id="sg.`id`";
		if(isset($data["page"])&&isset($data["size"])){
			$lim=" limit ".trim($data["page"]).",".trim($data["size"]);
		}
		if(isset($data["id"])){
			$id="sg.`id` = '".trim($data["id"])."' ";
		}
		if(isset($data["name_s"])){
			$name_s="s.`name` like '%".trim($data["name_s"])."%' ";
		}
		if(isset($data["username_s"])){
			$username_s="s.`username` like '%".trim($data["username_s"])."%' ";
		}
		if(isset($data["username"])){
			$username="s.`username`='".trim($data["username"])."' ";
		}
		if(isset($data["student_id"])){
			$student_id="sg.`student_id`='".trim($data["student_id"])."' ";
		}
		if(isset($data["group_id"])&&!empty($data["group_id"])){
			$group_id="sg.`group_id`='".trim($data["group_id"])."' ";
		}
		if(isset($data["task_id"])&&!empty($data["task_id"])){
			$task_id="g.task_id='".trim($data["task_id"])."' ";
		}
		$sql = "select sg.*,s.`name`,s.username 
					from student_group sg,student s,`group` g,`task` t 
						where $group_id 
						and t.id=g.task_id 
						and t.is_archive='0' 
						and $id 
						and sg.group_id=g.id 
						and sg.student_id=s.id 
						and $task_id
						and $student_id
						and $name_s 
						and $username 
						and $username_s 
						ORDER BY s.username 
						$lim";
		$result = $this -> sql -> query($sql);
		return $result;
	}
	
	function createMember($data) {
		$array = array("table" => "student_group", "data" => $data);
		$result = $this -> sql -> insert($array);
		return $result;
	}
	
	//删除成员
	function deleteMemberById($data){
		$array=array(
			"table"=>"student_group",
			"fields"=>"id",
			"data"=>$data
		);
		$result=$this->sql->delete($array);
		return $result;
	}
	//退出小组
	function deleteStuGroupByStuIdAndGroupId($data){
		$array=array(
			"table"=>"student_group",
			"data"=>$data
		);
		$result=$this->sql->deleteOne($array);
		return $result;
	}

}
?>