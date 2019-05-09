<?php
include_once "./../handler/handler.php";

include_once "./../dao/adminDao.php";
include_once "./../dao/groupDao.php";
include_once "./../dao/studentDao.php";
include_once "./../dao/studentScoreDao.php";
include_once "./../dao/taskDao.php";
include_once "./../dao/teacherDao.php";
include_once "./../dao/studentGroupDao.php";
include_once "./../dao/groupScoreDao.php";
include_once "./../dao/studentScoreDao.php";
class CreateService{
	private $student=null;
	private $teacher=null;
	private $task=null;
	private $group=null;
	private $studentGroup=null;
	private $studentScore=null;
	private $groupScore=null;
	function __construct(){
		$this->student=new StudentDao();
		$this->teacher=new TeacherDao();
		$this->task=new TaskDao();
		$this->group=new GroupDao();
		$this->studentGroup=new StudentGroupDao();
		$this->studentScore=new StudentScoreDao();
		$this->groupScore=new GroupScoreDao();
	}
	//创建学生
	public function createStudent($data){
		if(isset($data["username"])&&isset($data["password"])&&isset($data["name"])){
			$result=$this->student->findStudentByUserName($data["username"]);
			if(!(count($result)>0)){
				$data["role"]="student";
				$data["creation_time"]=time();
				$data["modify_time"]=time();
				$result=$this->student->createStudent($data);
				if($result>0){
					return true;
				}else{
					error("创建学生失败");
				}
			}else{
				error("该学生已存在");
			}
		}else{
			error("缺少必要信息");
		}
	}
	//创建教师
	public function createTeacher($data){
		if(isset($data["username"])&&isset($data["password"])&&isset($data["name"])){
			$result=$this->teacher->findTeacherByUserName($data["username"]);
			if(!(count($result)>0)){
				$data["role"]="teacher";
				$data["creation_time"]=time();
				$data["modify_time"]=time();
				$result=$this->teacher->createTeacher($data);
				if($result>0){
					return true;
				}else{
					error("创建教师失败");
				}
			}else{
				error("该教师已存在");
			}
		}else{
			error("缺少必要信息");
		}
	}
	//创建任务
	public function createTask($data){
		if(isset($data["curriculum"])&&isset($data["semester"])&&isset($data["class"])&&isset($data["teacher_id"])){
			$result=$this->task->findTaskByClass($data["class"]);
			if(count($result)>0){
				for($i=0;$i<count($result);$i++){
					if($result[$i]["curriculum"]==$data["curriculum"]&&$result[$i]["class"]==$data["class"]){
						error("当前班级的课程已存在");
					}
				}
			}
			$data["creation_time"]=time();
			$data["modify_time"]=time();
			$result=$this->task->createTask($data);
			if($result>0){
				return true;
			}else{
				error("创建任务失败");
			}
		}else{
			error("缺少必要信息");
		}
	}
	//创建小组
	public function createGroup($data){
		if(isset($data["name"])&&isset($data["task_id"])){
			$result=$this->group->findGroupByTaskId($data["task_id"]);
			for($i=0;$i<count($result);$i++){
				if($result[$i]["name"]==$data["name"]){
					error("添加小组失败：小组已存在");
				}
			}
			if(!isset($data["student_id"])){
				$data["student_id"]=-1;
			}
			$data["teacher_by_score"]=-1;
			$data["creation_time"]=time();
			$data["modify_time"]=time();
			$result=$this->group->createGroup($data);
			if($result>0){
				return true;
			}else{
				error("创建小组失败");
			}
		}else{
			error("缺少必要信息");
		}
	}
	//添加成员
	public function createStudentGroup($data){
		if(isset($data["student_id"])&&isset($data["group_id"])){
			$result=$this->studentGroup->findMemberByGroupId($data["group_id"]);
			for($i=0;$i<count($result);$i++){
				if($result[$i]["student_id"]==$data["student_id"]){
					return false;
				}
			}
			$data["creation_time"]=time();
			$data["modify_time"]=time();
			$result=$this->studentGroup->createMember($data);
			if($result>0){
				return true;
			}else{
				return false;
			}
		}else{
			error("缺少必要信息");
		}
	}
	//添加成员成绩
	public function createStudentScore($data){
		if(isset($data["from_student_id"])&&isset($data["student_group_id"])&&isset($data["score"])){
			if(!is_numeric($data["score"])){
				error("请输入正确的成绩");
			}
			$result_stuGro=$this->studentGroup->findMemberById($data["student_group_id"]);
			$result_stuStu=$this->studentGroup->findMemberByStudentId($data["from_student_id"]);
			if($result_stuGro[0]["student_id"]==$data["from_student_id"]){
				error("不能对自己评分");
			}
			$is_member=false;
			for($i=0;$i<count($result_stuStu);$i++){
				if($result_stuGro[0]["group_id"]==$result_stuStu[$i]["group_id"]){
					$is_member=true;
				}
			}
			if(!$is_member){
				error("您不是此小组成员");
			}
			
			$result=$this->studentScore->findStudentScoreByStuGroupIdAndFromStuId($data);
			if(!(count($result)>0)){
				$data["creation_time"]=time();
				$data["modify_time"]=time();
				$result=$this->studentScore->createStudentScore($data);
				if($result>0){
					return true;
				}else{
					error("添加成员成绩失败");
				}
			}else{
				error("已评分");
			}
		}else{
			error("缺少必要信息");
		}
	}
	//组内互评成绩
	public function createGroupInScore($data){
		if(isset($data["from_group_id"])&&isset($data["group_id"])&&isset($data["score"])){
			if(!is_numeric($data["score"])){
				error("请输入正确的成绩");
			}
			if($data["from_group_id"]==$data["group_id"]){
				error("不能对自己组评分");
			}
			$result=$this->groupScore->findGroupScoreByGroupIdAndFromGroupId($data);
			if(!(count($result)>0)){
				$data["creation_time"]=time();
				$data["modify_time"]=time();
				$result=$this->groupScore->createGroupScore($data);
				if($result>0){
					return true;
				}else{
					error("评分失败");
				}
			}else{
				error("已评分");
			}
		}else{
			error("缺少必要信息");
		}
	}
}
?>