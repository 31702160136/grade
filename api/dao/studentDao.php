<?php
include_once "./../db/sql.php";
class StudentDao {
	private $sql = null;
	function __construct() {
		$this -> sql = new Sql();
	}

	public function findStudents($page,$size) {
		if(isset($page)&&isset($size)){
			$sql = "select * from `student` limit ".$page.",".$size;
		}else{
			$sql = "select * from `student`";
		}
		$result = $this -> sql -> query($sql);
		return $result;
	}
	
	function findStudentByUserName($username) {
		$sql = "select * from `student` where `username`='" . $username."'";
		$result = $this -> sql -> query($sql);
		return $result;
	}
	
	function findStudentByName($name) {
		$sql = "select * from `student` where `name`='" . $name."'";
		$result = $this -> sql -> query($sql);
		return $result;
	}
	
	function findStudentById($id) {
		$sql = "select * from `student` where `id`='" . $id."'";
		$result = $this -> sql -> query($sql);
		return $result;
	}
	
	function sreachStudent($data) {
		$sql = "select * from `student` where `".$data["key"]."` like '%" . $data["value"]."%'";
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