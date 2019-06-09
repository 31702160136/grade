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
class SelectService {
	private $student = null;
	private $admin = null;
	private $teacher = null;
	private $task = null;
	private $group=null;
	private $studentGroup=null;
	private $studentScore=null;
	private $groupScore=null;
	function __construct() {
		$this -> admin = new AdminDao();
		$this -> student = new StudentDao();
		$this -> teacher = new TeacherDao();
		$this -> task = new TaskDao();
		$this->group=new GroupDao();
		$this->studentGroup=new StudentGroupDao();
		$this->studentScore=new StudentScoreDao();
		$this->groupScore=new GroupScoreDao();
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
	//查询教师
	function getTeachers($data) {
		if(@$data["page"]>0){
			$data["page"]--;
			$data["page"]*=$data["size"];
		}
		$result = $this -> teacher -> findTeachers($data);
		return $result;
	}
	//查询学生
	function getStudents($data) {
		if(@$data["page"]>0){
			$data["page"]--;
			$data["page"]*=$data["size"];
		}
		$result = $this -> student -> findStudents($data);
		return $result;
	}
	//查询任务
	function getTasks($data){
		if(@$data["page"]>0){
			$data["page"]--;
			$data["page"]*=$data["size"];
		}
		$result=$this->task->findTasks($data);
		for($i=0;$i<count($result);$i++){
			$data2=array(
				"id"=>$result[$i]["id"]
			);
			$res_count=$this->task->findTaskMemberCount($data2);
			if(count($res_count)>0){
				$result[$i]["count"]=$res_count[0]["count"];
			}else{
				$result[$i]["count"]=0;
			}
		}
		return $result;
	}
	//查询小组
	function getGroups($data){
		if(@$data["page"]>0){
			$data["page"]--;
			$data["page"]*=$data["size"];
		}
		$result=$this->group->findGroups($data);
		for($i=0;$i<count($result);$i++){
			if($result[$i]["teacher_by_score"]==-1){
				$result[$i]["teacher_by_score"]="未评分";
			}
		}
		return $result;
	}
	//查询成员
	function getMember($data){
		if(@$data["page"]>0){
			$data["page"]--;
			$data["page"]*=$data["size"];
		}
		$result=$this->studentGroup->findMember($data);
		return $result;
	}
	//查询成员成绩
	function getMemberScore($data){
		if(@$data["page"]>0){
			$data["page"]--;
			$data["page"]*=$data["size"];
		}
		$result=$this->studentScore->findStudentScores($data);
		return $result;
	}
	//查询组互评成绩
	function getGroupScore($data){
		if(@$data["page"]>0){
			$data["page"]--;
			$data["page"]*=$data["size"];
		}
		$result=$this->groupScore->findGroupScores($data);
		return $result;
	}
	//查询成绩总汇
	function getTaskScoreSylloge($data){
		if(@$data["page"]>0){
			$data["page"]--;
			$data["page"]*=$data["size"];
		}
		//查询主体
		$result1=$this->task->findMainGroup($data);
		//查询组成绩
		$result2=$this->task->findGroupScoreSylloge($data);
		//查询学生成绩
		$result3=$this->task->findStudentScoreSylloge($data);
		for($i=0;$i<count($result1);$i++){
			for($k=0;$k<count($result2);$k++){
				if($result1[$i]["id"]==$result2[$k]["id"]){
					$result1[$i]["group_score"]=$result2[$k]["score"];
					break;
				}else{
					$result1[$i]["group_score"]=0;
				}
			}
			for($j=0;$j<count($result3);$j++){
				if($result1[$i]["student_id"]==$result3[$j]["id"]){
					$result1[$i]["student_score"]=$result3[$j]["score"];
					break;
				}else{
					$result1[$i]["student_score"]=0;
				}
			}
			if($result1[$i]["teacher_score"]==-1){
				$result1[$i]["teacher_score"]=0;
			}
		}
		return $result1;
	}
}
?>