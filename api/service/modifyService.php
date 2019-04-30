<?php
include_once "./../handler/handler.php";

include_once "./../dao/adminDao.php";
include_once "./../dao/groupDao.php";
include_once "./../dao/studentDao.php";
include_once "./../dao/studentScoreDao.php";
include_once "./../dao/taskDao.php";
include_once "./../dao/teacherDao.php";
class ModifyService {
	private $studentDao = null;
	private $teacherDao = null;
	function __construct() {
		$this->studentDao=new StudentDao();
		$this->teacherDao=new TeacherDao();
	}

	//修改学生信息
	public function modifyStudentInfo($data) {
		if (isset($data["id"])) {
			$id = $data["id"];
			unset($data["id"]);
			$data["modify_time"] = time();
			$result = $this -> studentDao -> modifyStudentInfo($data, $id);
			if ($result > 0) {
				return true;
			} else {
				return false;
			}
		} else {
			error("缺少必要信息");
		}
	}
	
	//修改教师信息
	public function modifyTeacherInfo($data) {
		if (isset($data["id"])) {
			$id = $data["id"];
			unset($data["id"]);
			$data["modify_time"] = time();
			$result = $this -> teacherDao -> modifyTeacherInfo($data, $id);
			if ($result > 0) {
				return true;
			} else {
				return false;
			}
		} else {
			error("缺少必要信息");
		}
	}

}
?>