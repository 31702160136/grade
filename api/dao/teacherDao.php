<?php
class TeacherDao {
	private $sql = null;
	function __construct() {
		$this -> sql = new Sql();
	}
//	查询教师
	public function findTeachers($page,$size) {
		if(isset($page)&&isset($size)){
			$sql = "select * from `teacher` limit ".$page.",".$size;
		}else{
			$sql = "select * from `teacher`";
		}
		$result = $this -> sql -> query($sql);
		return $result;
	}
//	通过账号查询教师
	function findTeacherByUserName($username) {
		$sql = "select * from `teacher` where `username`='" . $username."'";
		$result = $this -> sql -> query($sql);
		return $result;
	}
	//通过姓名查询教师
	function findTeacherByName($name) {
		$sql = "select * from `teacher` where `name`='" . $name."'";
		$result = $this -> sql -> query($sql);
		return $result;
	}
	//搜索教师
	function sreachTeacher($data) {
		$sql = "select * from `teacher` where `".$data["key"]."` like '%" . $data["value"]."%'";
		$result = $this -> sql -> query($sql);
		return $result;
	}
	//创建教师
	function createTeacher($data) {
		$array = array(
			"table" => "teacher",
			"data" => $data
		);
		$result = $this -> sql -> insert($array);
		return $result;
	}

	//修改教师信息
	function modifyTeacherInfo($data, $id) {
		$array = array(
			"id" => $id,
			"table" => "teacher", 
			"data" => $data
		);
		$result = $this -> sql -> modify($array);
		return $result;
	}
	//删除教师
	function deleteTeacherById($data){
		$array=array(
			"table"=>"teacher",
			"fields"=>"id",
			"data"=>$data
		);
		$result=$this->sql->delete($array);
		return $result;
	}
}
?>