<?php
class TeacherDao {
	private $sql = null;
	function __construct() {
		$this -> sql = new Sql();
	}
//	查询教师
	public function findTeachers($data) {
		$lim="";
		$name="`id`";
		$username="`id`";
		$username_s="`id`";
		if(isset($data["page"])&&isset($data["size"])){
			$lim=" limit ".$data["page"].",".$data["size"];
		}
		if(isset($data["name"])){
			$name="`name` like '%".$data["name"]."%' ";
		}
		if(isset($data["username"])){
			$username="`username`='".$data["username"]."' ";
		}
		if(isset($data["username_s"])){
			$username_s="`username` like '%".$data["username_s"]."%' ";
		}
		$sql = "select * from `teacher` where $name and $username and $username_s $lim";
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