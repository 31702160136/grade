<?php
include_once "./../handler/handler.php";

include_once "./../dao/adminDao.php";
include_once "./../dao/groupDao.php";
include_once "./../dao/studentDao.php";
include_once "./../dao/studentScoreDao.php";
include_once "./../dao/taskDao.php";
include_once "./../dao/teacherDao.php";
class CreateService{
	private $student=null;
	private $teacher=null;
	private $task=null;
	function __construct(){
		$this->student=new StudentDao();
		$this->teacher=new TeacherDao();
		$this->task=new TaskDao();
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
}
?>