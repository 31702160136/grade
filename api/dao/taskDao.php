<?php
include_once "./../db/sql.php";
class TaskDao {
	private $sql = null;
	function __construct() {
		$this -> sql = new Sql();
	}

	public function findTasks($page,$size) {
		if(isset($page)&&isset($size)){
			$sql = "select * from `task` limit ".$page.",".$size;
		}else{
			$sql = "select * from `task`";
		}
		$result = $this -> sql -> query($sql);
		return $result;
	}
	
	function findTaskByTeacherId($teacherId,$page=null,$size=null) {
		if(isset($page)&&isset($size)){
			$sql = "select * from `task` where `teacher_id`='" . $teacherId."' limit ".$page.",".$size;
		}else{
			$sql = "select * from `task` where `teacher_id`='" . $teacherId."'";
		}
		$result = $this -> sql -> query($sql);
		return $result;
	}
	
	function findTaskByClass($class,$page=null,$size=null) {
		if(isset($page)&&isset($size)){
			$sql = "select * from `task` where `class`='" . $class."' limit ".$page.",".$size;
		}else{
			$sql = "select * from `task` where `class`='" . $class."'";
		}
		$result = $this -> sql -> query($sql);
		return $result;
	}
	
	function sreachTask($data) {
		$sql = "select * from `task` where `".$data["key"]."` like '%" . $data["value"]."%'";
		$result = $this -> sql -> query($sql);
		return $result;
	}
	
	function createTask($data) {
		$array = array(
			"table" => "task",
			"data" => $data
		);
		$result = $this -> sql -> insert($array);
		return $result;
	}

	//修改任务信息
	function modifyTaskInfo($data, $id) {
		$array = array("id" => $id, "table" => "task", "data" => $data);
		$result = $this -> sql -> modify($array);
		return $result;
	}
	//删除任务
	function deleteTaskById($data){
		$array=array(
			"table"=>"task",
			"fields"=>"id",
			"data"=>$data
		);
		$result=$this->sql->delete($array);
		return $result;
	}

}
?>