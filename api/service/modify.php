<?php
include_once "./../handler/handler.php";

include_once "./../dao/admin_dao.php";
include_once "./../dao/group_dao.php";
include_once "./../dao/student_dao.php";
include_once "./../dao/studentScore_dao.php";
include_once "./../dao/groupScore_dao.php";
include_once "./../dao/task_dao.php";
include_once "./../dao/teacher_dao.php";
class ModifyService {
	private $studentDao = null;
	private $teacherDao = null;
	private $group=null;
	private $studentScoreDao=null;
	private $groupScoreDao=null;
	private $taskDao=null;
	function __construct() {
		$this->studentDao=new StudentDao();
		$this->teacherDao=new TeacherDao();
		$this->group=new GroupDao();
		$this->studentScoreDao=new StudentScoreDao();
		$this->groupScoreDao=new GroupScoreDao();
		$this->taskDao=new TaskDao();
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
	
	//修改任务信息
	public function modifyTaskInfo($data) {
		if (isset($data["id"])) {
			$id = $data["id"];
			unset($data["id"]);
			$data["modify_time"] = time();
			$result = $this -> taskDao -> modifyTaskInfo($data, $id);
			if ($result > 0) {
				return true;
			} else {
				return false;
			}
		} else {
			error("缺少必要信息");
		}
	}
	
	//修改小组信息
	public function modifyGroupInfo($data) {
		if (isset($data["id"])) {
			$id = $data["id"];
			unset($data["id"]);
			$data["modify_time"] = time();
			$result = $this -> group -> modifyGroup($data, $id);
			if ($result > 0) {
				return true;
			} else {
				return false;
			}
		} else {
			error("缺少必要信息");
		}
	}
	//修改成员成绩
	public function modifyStudentScore($data) {
		if (isset($data["id"])) {
			$id = $data["id"];
			unset($data["id"]);
			$data["modify_time"] = time();
			$result = $this -> studentScoreDao ->modifyStudentScore($data, $id);
			if ($result > 0) {
				return true;
			} else {
				return false;
			}
		} else {
			error("缺少必要信息");
		}
	}
	//修改小组互评成绩
	public function modifyGroupScore($data) {
		if (isset($data["id"])) {
			$id = $data["id"];
			unset($data["id"]);
			$data["modify_time"] = time();
			$result = $this -> groupScoreDao ->modifyGroupScore($data, $id);
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