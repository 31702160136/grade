<?php
include_once "./../handler/handler.php";

include_once "./../dao/adminDao.php";
include_once "./../dao/groupDao.php";
include_once "./../dao/studentDao.php";
include_once "./../dao/studentScoreDao.php";
include_once "./../dao/taskDao.php";
include_once "./../dao/teacherDao.php";
include_once "./../dao/studentGroupDao.php";
class DeleteService {
	private $student=null;
	private $adminDao=null;
	private $teacher=null;
	private $task=null;
	private $group=null;
	private $studentGroup=null;
	function __construct(){
		$this->adminDao=new AdminDao();
		$this->student=new StudentDao();
		$this->teacher=new TeacherDao();
		$this->task=new TaskDao();
		$this->group=new GroupDao();
		$this->studentGroup=new StudentGroupDao();
	}
	//通过id删除学生
	function delStudentById($data) {
		if (isset($data)) {
			$result = $this -> adminDao ->findAdminByUserName(getSessionUserName());
			if (count($result)>0) {
				$result = $this -> student ->deleteStudentById($data);
				//判断是否修改成功
				if ($result > 0) {
					return true;
				} else {
					return false;
				}
			} else {
				error("权限不足");
			}
		}else{
			error("缺少参数");
		}
	}
	//通过id删除教师
	function delTeacherById($data) {
		if (isset($data)) {
			$result = $this -> adminDao ->findAdminByUserName(getSessionUserName());
			if (count($result)>0) {
				$result = $this -> teacher ->deleteTeacherById($data);
				//判断是否修改成功
				if ($result > 0) {
					return true;
				} else {
					return false;
				}
			} else {
				error("权限不足");
			}
		}else{
			error("缺少参数");
		}
	}
	//通过id删除任务
	function delTaskById($data) {
		if (isset($data)&&is_array($data)) {
			$result = $this -> adminDao ->findAdminByUserName(getSessionUserName());
			if (count($result)>0) {
				$result = $this -> task ->deleteTaskById($data);
				//判断是否修改成功
				if ($result > 0) {
					return true;
				} else {
					return false;
				}
			} else {
				error("权限不足");
			}
		}else{
			error("缺少参数");
		}
	}
	//通过id删除小组
	function delGroupById($data) {
		if (isset($data)&&is_array($data)) {
			$result = $this -> group ->deleteGroupById($data);
			//判断是否修改成功
			if ($result > 0) {
				return true;
			} else {
				return false;
			}
		}else{
			error("缺少参数");
		}
	}
	
	//通过学生id与小组id退出小组
	function delStuGroupByStuIdAndGroupId($data) {
		if (isset($data["student_id"])&&isset($data["group_id"])) {
			$result = $this -> studentGroup ->deleteStuGroupByStuIdAndGroupId($data);
			//判断是否删除成功
			if ($result > 0) {
				return true;
			} else {
				return false;
			}
		}else{
			error("缺少参数");
		}
	}
	
	//通过id删除组成员
	function delStudentGroupById($data) {
		if (isset($data)&&is_array($data)) {
			$result = $this -> studentGroup ->deleteMemberById($data);
			//判断是否修改成功
			if ($result > 0) {
				return true;
			} else {
				return false;
			}
		}else{
			error("缺少参数");
		}
	}

}
?>