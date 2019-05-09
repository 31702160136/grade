<?php
include_once "./../db/sql.php";
class StudentScoreDao {
	private $sql = null;
	function __construct() {
		$this -> sql = new Sql();
	}

	function findStudentScoreByStuGroupId($studentGroupId,$page=null,$size=null) {
		if(isset($page)&&isset($size)){
			$sql = "select * from `student_score` where `student_group_id`='" . $studentGroupId."' limit ".$page.",".$size;
		}else{
			$sql = "select * from `student_score` where `student_group_id`='" . $studentGroupId."'";
		}
		$result = $this -> sql -> query($sql);
		return $result;
	}
	
	function findStudentScoreByFromStudentId($fromStudentId,$page=null,$size=null) {
		if(isset($page)&&isset($size)){
			$sql = "select ss.* from `student_score` ss,`student_group` sg where ss.`from_student_id`='".$fromStudentId."' and ss.`student_group_id`=sg.`id` limit ".$page.",".$size;
		}else{
			$sql = "select ss.* from `student_score` ss,`student_group` sg where ss.`from_student_id`='".$fromStudentId."' and ss.`student_group_id`=sg.`id` limit ". 0 .",". 10;
		}
		$result = $this -> sql -> query($sql);
		return $result;
	}
	
	function findStudentScoreByStuGroupIdAndFromStuId($data,$page=null,$size=null) {
		if(isset($page)&&isset($size)){
			$sql = "select * from `student_score` where `student_group_id`='" . $data["student_group_id"]."' and `from_student_id`='".$data["from_student_id"]."' limit ".$page.",".$size;
		}else{
			$sql = "select * from `student_score` where `student_group_id`='" . $data["student_group_id"]."' and `from_student_id`='".$data["from_student_id"]."'";
		}
		$result = $this -> sql -> query($sql);
		return $result;
	}

	function createStudentScore($data) {
		$array = array("table" => "student_score", "data" => $data);
		$result = $this -> sql -> insert($array);
		return $result;
	}

}
?>