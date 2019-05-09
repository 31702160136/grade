<?php
include_once "./../handler/handler.php";

include_once "./../dao/adminDao.php";
include_once "./../dao/groupDao.php";
include_once "./../dao/studentDao.php";
include_once "./../dao/studentScoreDao.php";
include_once "./../dao/taskDao.php";
include_once "./../dao/teacherDao.php";
include_once "./../dao/studentGroupDao.php";
include_once "./../dao/studentScoreDao.php";
include_once "./../dao/groupScoreDao.php";
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
	//	通过id查询学生
	function getStudentById($data) {
		if (isset($data["id"])) {
			$result = $this -> student -> findStudentById($data["id"]);
			if (count($result) > 0) {
				return $result[0];
			} else {
				return null;
			}
		} else {
			error("缺少信息");
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
	//查询小组列表
	public function getGroupsByTaskId($data) {
		if(isset($data["task_id"])){
			$page = null;
			$size = null;
			if (isset($data["page"]) && isset($data["size"])) {
				if ($data["page"] <= 0) {
					$data["page"] = 1;
				}
				$page = ($data["page"] - 1) * $data["size"];
				$size = $data["size"];
			}
			$result = $this -> group -> findGroupByTaskId($data["task_id"],$page, $size);
			return $result;
		}else{
			error("缺少必要信息");
		}
	}
	//根据id查询小组
	public function getGroupsById($data) {
		if(isset($data["id"])){
			$result = $this -> group -> findGroupById($data["id"]);
			if(count($result)>0){
				return $result[0];
			}else{
				return null;
			}
		}else{
			error("缺少必要信息");
		}
	}
	public function isTheTaskGroupHaveMember($data){
		if (isset($data["student_id"])&&isset($data["task_id"])){
			$result=$this->group->findGroupByTaskId($data["task_id"]);
			for($i=0;$i<count($result);$i++){
				$data2=array(
					"group_id"=>$result[$i]["id"],
					"student_id"=>$data["student_id"]
				);
				$resultStu=$this->studentGroup->findMemberByGroupIdAndStuId($data2);
				if(count($resultStu)>0){
					return true;
				}
			}
			return false;
		}else{
			error("缺少信息");
		}
	}
	public function getStuGroupBytaskIdAndStuId($data){
		if (isset($data["student_id"])&&isset($data["task_id"])){
			$result=$this->group->findGroupByTaskId($data["task_id"]);
			for($i=0;$i<count($result);$i++){
				if($result[$i]["student_id"]==$data["student_id"]){
					return $result[$i];
				}
			}
			return null;
		}else{
			error("缺少信息");
		}
	}
	public function getStuGroupById($data){
		if (isset($data["id"])){
			$result=$this->studentGroup->findMemberByGroupId($data["id"]);
			if(count($result)>0){
				return $result[0];
			}else{
				error("找不到此成员信息");
			}
		}else{
			error("缺少信息");
		}
	}
	//	搜索查询小组
	public function sreachGroup($data) {
		if (isset($data["key"])&&isset($data["task_id"])) {
			if ($data["value"] == "") {
				$result = $this -> group -> findGroupByTaskId($data["task_id"],0, 10);
			}else{
				$result = $this -> group -> sreachGroup($data);
			}
			return  $result;
		}else{
			error("缺少必要信息");
		}
	}
	//查询成员列表
	public function getStudentGroupByGroupId($data) {
		if(isset($data["group_id"])){
			$page = null;
			$size = null;
			if (isset($data["page"]) && isset($data["size"])) {
				if ($data["page"] <= 0) {
					$data["page"] = 1;
				}
				$page = ($data["page"] - 1) * $data["size"];
				$size = $data["size"];
			}
			$result = $this -> studentGroup -> findMemberByGroupId($data["group_id"],$page, $size);
			return $result;
		}else{
			error("缺少必要信息");
		}
	}
	//	搜索组内成员查询
	public function sreachStudentGroup($data) {
		if (isset($data["key"])&&isset($data["group_id"])) {
			$array=[];
			if ($data["value"] == "") {
				$result = $this -> studentGroup -> findMemberByGroupId($data["group_id"],0, 10);
			}else{
				$result = $this -> student -> sreachStudent($data);
				if(count($result)>0){
					for($i=0;$i<count($result);$i++){
						$data["student_id"]=$result[$i]["id"];
						$resultStuGro = $this -> studentGroup -> findMemberByGroupIdAndStuId($data);
						if(count($resultStuGro)>0){
							array_push($array,$resultStuGro[0]);
						}else{
							$result = $this -> studentGroup -> findMemberByGroupId($data["group_id"],0, 10);
							return $result;
						}
						
					}
				}
				return  $array;
			}
			return  $result;
		}else{
			error("缺少必要信息");
		}
	}
	//查询成员组内互评分
	public function getStudentScoreByStuGroId($data) {
		if(isset($data["student_group_id"])){
			$page = null;
			$size = null;
			if (isset($data["page"]) && isset($data["size"])) {
				if ($data["page"] <= 0) {
					$data["page"] = 1;
				}
				$page = ($data["page"] - 1) * $data["size"];
				$size = $data["size"];
			}
			$result = $this -> studentScore -> findStudentScoreByStuGroupId($data["student_group_id"],$page, $size);
			return $result;
		}else{
			error("缺少必要信息");
		}
	}
	//查询成员组内互评分
	public function getStudentScoreByFromStudentId($data) {
		if(isset($data["from_student_id"])){
			$page = null;
			$size = null;
			if (isset($data["page"]) && isset($data["size"])) {
				if ($data["page"] <= 0) {
					$data["page"] = 1;
				}
				$page = ($data["page"] - 1) * $data["size"];
				$size = $data["size"];
			}
			$result = $this -> studentScore -> findStudentScoreByFromStudentId($data["from_student_id"],$page, $size);
			return $result;
		}else{
			error("缺少必要信息");
		}
	}
	//查询成员组内互评分
	public function getGroupScoreByGroId($data) {
		if(isset($data["group_id"])){
			$page = null;
			$size = null;
			if (isset($data["page"]) && isset($data["size"])) {
				if ($data["page"] <= 0) {
					$data["page"] = 1;
				}
				$page = ($data["page"] - 1) * $data["size"];
				$size = $data["size"];
			}
			$result = $this -> groupScore -> findGroupScoreByGroupId($data["group_id"],$page, $size);
			return $result;
		}else{
			error("缺少必要信息");
		}
	}
	
	public function getGroupScoreByTaskIdAndFromGroId($data) {
		$page = null;
		$size = null;
		if (isset($data["page"]) && isset($data["size"])) {
			if ($data["page"] <= 0) {
				$data["page"] = 1;
			}
			$page = ($data["page"] - 1) * $data["size"];
			$size = $data["size"];
		}
		if(isset($data["from_group_id"])&&isset($data["task_id"])){
			$result_group=$this->getGroupsByTaskId($data,$page,$size);
			for($i=0;$i<count($result_group);$i++){
				$data["group_id"]=$result_group[$i]["id"];
				$result_score=$this->groupScore->findGroupScoreByGroupIdAndFromGroupId($data);
				$result_group[$i]["score"]=isset($result_score[0]["score"])? $result_score[0]["score"]:"未评分";
				$result_group[$i]["from_group_id"]=isset($result_score[0]["from_group_id"])? $result_score[0]["from_group_id"]:"无人评分";
			}
			if(count($result_group)>0){
				return $result_group;
			}else{
				error("无小组信息");
			}
		}else{
			error("缺少必要信息");
		}
	}
	
	public function getGroupScoreByGroupIdAndFromGroupId($data) {
		if(isset($data["from_group_id"])){
			$result_score=$this->groupScore->findGroupScoreByGroupIdAndFromGroupId($data);
			if(count($result_score)>0){
				return $result_score;
			}else{
				return null;
			}
		}else{
			error("缺少必要信息");
		}
	}
}
?>