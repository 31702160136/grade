<?php
include_once "./../db/sql.php";
class StudentGroupDao {
	private $sql = null;
	function __construct() {
		$this -> sql = new Sql();
	}

	function findMemberByGroupIdAndStuId($data) {
		$sql = "select sg.`id`, sg.`student_id` , sg.`group_id`, s.`username`,s.`name` 
			from student s, student_group sg 
					where s.`id`=sg.`student_id` and sg.`group_id`='".$data["group_id"]."' and `student_id`='" . $data["student_id"]."'";
		$result = $this -> sql -> query($sql);
		return $result;
	}
	function findMemberByGroupId($groupId,$page=null,$size=null) {
		if(isset($page)&&isset($size)){
			$sql = "select sg.`id`, sg.`student_id` , sg.`group_id`, s.`username`,s.`name` 
			from student s, student_group sg 
					where s.`id`=sg.`student_id` and sg.`group_id`='".$groupId."' limit ".$page.",".$size;
		}else{
			$sql = "select sg.`id`, sg.`student_id` , sg.`group_id`, s.`username`,s.`name` 
			from student s, student_group sg 
					where s.`id`=sg.`student_id` and sg.`group_id`='".$groupId."'";
		}
		$result = $this -> sql -> query($sql);
		return $result;
	}
	
	function findMemberById($id) {
		$sql = "select * from student_group where `id`='".$id."'";
		$result = $this -> sql -> query($sql);
		return $result;
	}

	function findMemberByStudentId($studentId) {
		$sql = "select * from student_group where `student_id`='".$studentId."'";
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