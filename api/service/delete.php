<?php
include_once "./../handler/handler.php";

include_once "./../dao/admin_dao.php";
include_once "./../dao/group_dao.php";
include_once "./../dao/student_dao.php";
include_once "./../dao/studentScore_dao.php";
include_once "./../dao/task_dao.php";
include_once "./../dao/teacher_dao.php";
include_once "./../dao/studentGroup_dao.php";
class DeleteService {
	private $student=null;
	private $adminDao=null;
	private $teacher=null;
	private $task=null;
	private $group=null;
	private $studentGroup=null;
	private $studentScore=null;
	function __construct(){
		$this->adminDao=new AdminDao();
		$this->student=new StudentDao();
		$this->teacher=new TeacherDao();
		$this->task=new TaskDao();
		$this->group=new GroupDao();
		$this->studentGroup=new StudentGroupDao();
		$this->studentScore=new StudentScoreDao();
	}
	//通过id删除学生
	function delStudentById($data) {
		if (isset($data)&&is_array($data)) {
			$result = $this -> student ->deleteStudentById($data);
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
	//通过id删除教师
	function delTeacherById($data) {
		if (isset($data)) {
			$result = $this -> teacher ->deleteTeacherById($data);
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
	//通过id删除任务
	function delTaskById($data) {
		if (isset($data)&&is_array($data)) {
			$result = $this -> task ->deleteTaskById($data);
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
			$data_del_sc=array();
			$res_mem=$this->studentGroup->findMember($data);
			//找到成员后，使用字段里的学生id根据评分人字段(from_student_id)找到成绩信息
			$data_sc=array(
				"from_student_id"=>$res_mem[0]["student_id"]
			);
			$res_sc=$this->studentScore->findStudentScores($data_sc);
			//找到成绩信息后进行循环
			for($k=0;$k<count($res_sc);$k++){
			//使用成员id找到成员信息
				$data_mem2=array(
					"id"=>$res_sc[$k]["student_group_id"]
				);
				$res_mem2=$this->studentGroup->findMember($data_mem2);
				//对比第一次查找成员与第二次查找成员的组id(group_id)是否一致,如果是则删除该成绩
				if($res_mem[0]["group_id"]==$res_mem2[0]["group_id"]){
					array_push($data_del_sc,$res_sc[$k]["id"]);
				}
			}
			$res_del_sc=$this->studentScore->deleteStudentScore($data_del_sc);
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
			//数据库设计不合理造成的繁琐操作
			$data_del_sc=array();
			//把传递过来的成员id进行循环找到成绩信息
			for($i=0;$i<count($data);$i++){
				//通过成员id找到成员
				$data_mem=array(
					"id"=>$data[$i]
				);
				$res_mem=$this->studentGroup->findMember($data_mem);
				//找到成员后，使用字段里的学生id根据评分人字段(from_student_id)找到成绩信息
				$data_sc=array(
					"from_student_id"=>$res_mem[0]["student_id"]
				);
				$res_sc=$this->studentScore->findStudentScores($data_sc);
				//找到成绩信息后进行循环
				for($k=0;$k<count($res_sc);$k++){
				//使用成员id找到成员信息
					$data_mem2=array(
						"id"=>$res_sc[$k]["student_group_id"]
					);
					$res_mem2=$this->studentGroup->findMember($data_mem2);
					//对比第一次查找成员与第二次查找成员的组id(group_id)是否一致,如果是则删除该成绩
					if($res_mem[0]["group_id"]==$res_mem2[0]["group_id"]){
						array_push($data_del_sc,$res_sc[$k]["id"]);
					}
				}
				
			}
			$res_del_sc=$this->studentScore->deleteStudentScore($data_del_sc);
			$result = $this -> studentGroup ->deleteMemberById($data);
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

}
?>