<?php
include_once "./../db/sql.php";
class GroupDao {
	private $sql = null;
	function __construct() {
		$this -> sql = new Sql();
	}

	public function findGroups($page,$size) {
		if(isset($page)&&isset($size)){
			$sql = "select * from `group` limit ".$page.",".$size;
		}else{
			$sql = "select * from `group`";
		}
		$result = $this -> sql -> query($sql);
		return $result;
	}

	function findColumnById($id) {
		$sql = "select * from `column` where `id`=" . $id;
		$result = $this -> sql -> query($sql);
		return $result;
	}

	function findColumnByTitle($title) {
		$sql = "select * from `column` where title='" . $title . "'";
		$result = $this -> sql -> query($sql);
		return $result;
	}

	function createColumn($data) {
		$array = array("table" => "column", "data" => $data);
		$result = $this -> sql -> insert($array);
		return $result;
	}

	//修改栏目
	function modifyColumn($data, $id) {
		$array = array("id" => $id, "table" => "column", "data" => $data);
		$result = $this -> sql -> modify($array);
		return $result;
	}
	//删除栏目
	function deleteColumnById($data){
		$array=array(
			"table"=>"column",
			"fields"=>"id",
			"data"=>$data
		);
		$result=$this->sql->delete($array);
		return $result;
	}

}
?>