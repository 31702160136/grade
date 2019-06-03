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
		if(isset($data["page"])&&isset($data["size"])){
			$lim=" limit ".$data["page"].",".$data["size"];
		}
		if(isset($data["name"])){
			$name="`name` like '%".$data["name"]."%' ";
		}
		if(isset($data["username_s"])){
			$username_s="`username` like '%".$data["username_s"]."%' ";
		}
		if(isset($data["username"])){
			$username="`username`='".$data["username"]."' ";
		}
		if(isset($data["id"])){
			$id="`id`='".$data["id"]."' ";
		}
		$sql="select * from `student` 
				where $name 
				and $id 
				and $username 
				and $username_s 
				$lim";
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