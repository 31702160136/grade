<?php
include_once "./../db/sql.php";
class StudentScoreDao {
	private $sql = null;
	function __construct() {
		$this -> sql = new Sql();
	}

	function findStudentScores($data) {
		$lim="";
		$from_student_id="ss.`id`";
		$student_group_id="ss.`id`";
		if(isset($data["page"])&&isset($data["size"])){
			$lim=" limit ".trim($data["page"]).",".trim($data["size"]);
		}
		if(isset($data["from_student_id"])){
			$from_student_id="`from_student_id` = '".trim($data["from_student_id"])."' ";
		}
		if(isset($data["student_group_id"])){
			$student_group_id="`student_group_id` = '".trim($data["student_group_id"])."' ";
		}
		$sql="select ss.*,s.`name` as from_student 
				from student_score ss,student s 
					where ss.from_student_id=s.id 
						and $from_student_id 
						and $student_group_id 
						$lim";
		$result = $this -> sql -> query($sql);
		return $result;
	}

	function createStudentScore($data) {
		$array = array("table" => "student_score", "data" => $data);
		$result = $this -> sql -> insert($array);
		return $result;
	}
	//修改任务信息
	function modifyStudentScore($data, $id) {
		$array = array("id" => $id, "table" => "student_score", "data" => $data);
		$result = $this -> sql -> modify($array);
		return $result;
	}
	//删除任务
	function deleteStudentScore($data){
		$array=array(
			"table"=>"student_score",
			"fields"=>"id",
			"data"=>$data
		);
		$result=$this->sql->delete($array);
		return $result;
	}
}
?>