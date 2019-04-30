<?php
include_once "./../handler/handler.php";

include_once "./../dao/adminDao.php";
include_once "./../dao/groupDao.php";
include_once "./../dao/studentDao.php";
include_once "./../dao/studentScoreDao.php";
include_once "./../dao/taskDao.php";
include_once "./../dao/teacherDao.php";
class SelectService {
	private $student = null;
	private $admin = null;
	private $teacher = null;
	private $task = null;
	function __construct() {
		$this -> admin = new AdminDao();
		$this -> student = new StudentDao();
		$this -> teacher = new TeacherDao();
		$this -> task = new TaskDao();
	}
	//	通过管理员账号查询管理员
	function getAdminByUserName($data) {
		if (isset($data["username"])) {
			$result = $this -> admin -> findAdminByUserName($data["username"]);
			if (count($result) > 0) {
				return $result[0];
			} else {
				error("账号不存在");
			}
		} else {
			error("请输入账号");
		}
	}
	
	//	通过账号查询学生
	function getStudentByUserName($data) {
		if (isset($data["username"])) {
			$result = $this -> student -> findStudentByUserName($data["username"]);
			if (count($result) > 0) {
				return $result[0];
			} else {
				error("账号不存在");
			}
		} else {
			error("请输入账号");
		}
	}
	//	通过姓名查询学生
	function getStudentByName($data) {
		if (isset($data["name"])) {
			$result = $this -> student -> findStudentByName($data["name"]);
			if (count($result) > 0) {
				return $result[0];
			} else {
				error("信息不存在");
			}
		} else {
			error("请输入姓名");
		}
	}
	//	查询学生列表
	public function getStudents($data) {
		$page = null;
		$size = null;
		if (isset($data["page"]) && isset($data["size"])) {
			if ($data["page"] <= 0) {
				$data["page"] = 1;
			}
			$page = ($data["page"] - 1) * $data["size"];
			$size = $data["size"];
		}
		$result = $this -> student -> findStudents($page, $size);
		return $result;
	}
	//	搜索查询学生
	public function sreachStudent($data) {
		if (isset($data["key"])) {
			if ($data["value"] == "") {
				$result = $this -> student -> findStudents(0, 10);
			}else{
				$result = $this -> student -> sreachStudent($data);
			}
			return  $result;
		}else{
			error("缺少必要信息");
		}
	}

	//	通过账号查询教师
	function getTeacherByUserName($data) {
		if (isset($data["username"])) {
			$result = $this -> teacher ->findTeacherByUserName($data["username"]);
			if (count($result) > 0) {
				return $result[0];
			} else {
				error("账号不存在");
			}
		} else {
			error("请输入账号");
		}
	}
	//	通过姓名查询教师
	function getTeacherByName($data) {
		if (isset($data["name"])) {
			$result = $this -> teacher -> findTeacherByName($data["name"]);
			if (count($result) > 0) {
				return $result[0];
			} else {
				error("信息不存在");
			}
		} else {
			error("请输入姓名");
		}
	}
	//	查询教师列表
	public function getTeachers($data) {
		$page = null;
		$size = null;
		if (isset($data["page"]) && isset($data["size"])) {
			if ($data["page"] <= 0) {
				$data["page"] = 1;
			}
			$page = ($data["page"] - 1) * $data["size"];
			$size = $data["size"];
		}
		$result = $this -> teacher ->findTeachers($page, $size);
		return $result;
	}
	//	搜索查询教师
	public function sreachTeacher($data) {
		if (isset($data["key"])) {
			if ($data["value"] == "") {
				$result = $this -> teacher -> findTeachers(0, 10);
			}else{
				$result = $this -> teacher -> sreachTeacher($data);
			}
			return  $result;
		}else{
			error("缺少必要信息");
		}
	}
	//查询任务列表
	public function getTasks($data) {
		$page = null;
		$size = null;
		if (isset($data["page"]) && isset($data["size"])) {
			if ($data["page"] <= 0) {
				$data["page"] = 1;
			}
			$page = ($data["page"] - 1) * $data["size"];
			$size = $data["size"];
		}
		$result = $this -> task -> findTasks($page, $size);
		return $result;
	}
	//根据教师id查询任务列表
	public function getTasksByTeacherId($data) {
		$page = null;
		$size = null;
		if(isset($data["teacher_id"])){
			if (isset($data["page"]) && isset($data["size"])) {
				if ($data["page"] <= 0) {
					$data["page"] = 1;
				}
				$page = ($data["page"] - 1) * $data["size"];
				$size = $data["size"];
			}
			$result = $this -> task -> findTaskByTeacherId($data["teacher_id"],$page, $size);
			return $result;
		}else{
			error("缺少参数");
		}
	}
	//根据教师id与班级查询任务列表
	public function getTasksByTeacherIdAndClass($data) {
		$page = null;
		$size = null;
		if(isset($data["class"])){
			if (isset($data["page"]) && isset($data["size"])) {
				if ($data["page"] <= 0) {
					$data["page"] = 1;
				}
				$page = ($data["page"] - 1) * $data["size"];
				$size = $data["size"];
			}
			$result = $this -> task -> findTaskByClass($page, $size);
			return $result;
		}else{
			error("缺少参数");
		}
	}
	//	搜索查询任务
	public function sreachTask($data) {
		if (isset($data["key"])) {
			if ($data["value"] == "") {
				$result = $this -> task -> findTasks(0, 10);
			}else{
				$result = $this -> task -> sreachTask($data);
			}
			return  $result;
		}else{
			error("缺少必要信息");
		}
	}
}
?>