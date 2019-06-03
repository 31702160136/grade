<?php
include_once "./../handler/handler.php";

include_once "./../dao/admin_dao.php";
include_once "./../dao/group_dao.php";
include_once "./../dao/student_dao.php";
include_once "./../dao/studentScore_dao.php";
include_once "./../dao/task_dao.php";
include_once "./../dao/teacher_dao.php";
include_once "./../dao/studentGroup_dao.php";
include_once "./../dao/groupScore_dao.php";
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
			$inspect=array(
				"username"=>$data["username"]
			);
			$result=$this->student->findStudents($inspect);
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
			error("缺少必要信息：createStudent");
		}
	}
	//创建教师
	public function createTeacher($data){
		if(isset($data["username"])&&isset($data["password"])&&isset($data["name"])){
			$inspect=array(
				"username"=>$data["username"]
			);
			$result=$this->teacher->findTeachers($inspect);
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
		if(isset($data["curriculum"])&&
				isset($data["semester"])&&
				isset($data["class"])&&
				isset($data["teacher_id"])&&
				isset($data["weight_teacher"])&&
				isset($data["weight_group"])&&
				isset($data["weight_group_in"])){
			$data["is_archive"]=0;
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
		if(isset($data["name"])&&isset($data["task_id"])&&isset($data["student_id"])){
			$inspect=array(
				"name"=>$data["name"],
				"task_id"=>$data["task_id"]
			);
			$result=$this->group->findGroups($inspect);
			if(count($result)>0){
				error("此小组已存在");
			}
			$inspect=array(
				"student_id"=>$data["student_id"],
				"task_id"=>$data["task_id"]
			);
			$result=$this->studentGroup->findMember($inspect);
			if(count($result)>0){
				error("已加入其他队伍");
			}
			$data["teacher_by_score"]=-1;
			$data["creation_time"]=time();
			$data["modify_time"]=time();
			$result=$this->group->createGroup($data);
			if($result>0){
				$output=$this->group->findGroups($inspect);
				$data_menber=array(
					"group_id"=>$output[0]["id"],
					"student_id"=>$data["student_id"],
					"creation_time"=>time(),
					"modify_time"=>time()
				);
				$result=$this->studentGroup->createMember($data_menber);
				if($result>0){
					return true;
				}else{
					return false;
				}
			}else{
				error("创建小组失败");
			}
		}else{
			error("缺少必要信息");
		}
	}
	//添加成员
	public function createStudentGroup($data){
		if(isset($data["student_id"])&&isset($data["group_id"])&&isset($data["task_id"])){
			$inspect=array(
				"student_id"=>$data["student_id"],
				"task_id"=>$data["task_id"]
			);
			$result=$this->studentGroup->findMember($inspect);
			if(count($result)>0){
				return false;
			}
			unset($data["task_id"]);
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
			$inspect=array(
				"id"=>$data["student_group_id"]
			);
			//通过成员id搜索成员
			$inspect_member=$this->studentGroup->findMember($inspect);
			if(@$inspect_member[0]["student_id"]==$data["from_student_id"]){
				error("不能对自己评分");
			}
			$inspect=array(
				"student_id"=>$data["from_student_id"]
			);
			//通过学生id搜索成员
			$inspect_member2=$this->studentGroup->findMember($inspect);
			//把搜索到的成员与$inspect_member查询到的成员进行比对，如果他们的group_id相同则为同一个组
			foreach($inspect_member2 as $value){
				if($value["group_id"]==@$inspect_member[0]["group_id"]){
					$data["creation_time"]=time();
					$data["modify_time"]=time();
					$result=$this->studentScore->createStudentScore($data);
					if($result>0){
						return true;
					}
				}
			}
			error("您不是此组成员");
		}else{
			error("缺少必要信息");
		}
	}
	//组内互评成绩
	public function createGroupScore($data){
		if(isset($data["from_group_id"])&&isset($data["group_id"])&&isset($data["score"])){
			if(!is_numeric($data["score"])){
				error("请输入正确的成绩");
			}
			if($data["from_group_id"]==$data["group_id"]){
				error("不能对自己组评分");
			}
			$res_sc=$this->groupScore->findGroupScores($data);
			if(!(count($res_sc)>0)){
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