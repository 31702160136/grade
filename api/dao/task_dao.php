<?php
include_once "./../db/sql.php";
$sq="";
class TaskDao {
	private $sql = null;
	function __construct() {
		$this -> sql = new Sql();
	}

	public function findTasks($data) {
		$lim="";
		$is_archive="t1.`teacher_id`=t2.`id`";
		$class="t1.`teacher_id`=t2.`id`";
		$task_id="t1.`teacher_id`=t2.`id`";
		$teacherId="t1.`teacher_id`=t2.`id`";
		$curriculum="t1.`teacher_id`=t2.`id`";
		//处理外键
		if(isset($data["teacher_id"])){
			$teacherId="t1.`teacher_id`='".trim($data["teacher_id"])."' ";
		}
		//处理课程名搜索条件
		if(isset($data["curriculum"])){
			$curriculum="t1.`curriculum` like '%".trim($data["curriculum"])."%' ";
		}
		//处理课程名搜索条件
		if(isset($data["id"])){
			$task_id="t1.`id` = '".trim($data["id"])."' ";
		}
		//处理课程名搜索条件
		if(isset($data["is_archive"])){
			$is_archive="t1.`is_archive` = '".trim($data["is_archive"])."' ";
		}
		//处理课程名搜索条件
		if(isset($data["class"])){
			$class="t1.`class` = '".trim($data["class"])."' ";
		}
		//处理页数
		if(isset($data["page"])&&isset($data["size"])){
			$lim="limit ".$data["page"].",".$data["size"];
		}
		$sql = "select t1.*,t2.`name` as name from `task` t1,`teacher` t2 where 
						t1.`teacher_id`=t2.`id` 
						and $class 
						and $is_archive 
						and $task_id 
						and $teacherId 
						and $curriculum 
						$lim";
		$result = $this -> sql -> query($sql);
		return $result;
	}
	public function findTaskMember($data) {
		$task_id="t.`id` = '".trim(@$data["id"])."' ";
		$sql = "select sg.student_id as student_id 
				from `student_group` sg,
				`group` g,
				`task` t 
				where g.task_id=t.id 
				and g.id=sg.group_id 
				and $task_id ";
		$result = $this -> sql -> query($sql);
		return $result;
	}
	function findMainGroup($data) {
		$lim="";
		$task_id="g.task_id=-1";
		if(isset($data["size"])&& !empty(trim($data["size"]))){
			$lim=" limit ".$data["page"].",".$data["size"];
		}
		if(isset($data["task_id"])&& !empty(trim($data["task_id"]))){
			$task_id="g.task_id='".$data["task_id"]."'";
		}
		$sql = "select 
					sg.group_id as id,
					s.id as student_id,
					s.username as username,
					avg(g.teacher_by_score) as teacher_score,
					s.`name`,
					g.`name` as group_name 
					from 
					student_group sg,
					`group` g,
					student s 
					where sg.student_id=s.id 
					and sg.group_id=g.id 
					and $task_id 
					GROUP BY sg.id 
					ORDER BY s.username ";
		$result = $this -> sql -> query($sql);
		return $result;
		
	}	
	function findStudentScoreSylloge($data) {
		$lim="";
		$task_id="g.task_id";
		if(isset($data["size"])&& !empty(trim($data["size"]))){
			$lim=" limit ".$data["page"].",".$data["size"];
		}
		if(isset($data["task_id"])&& !empty(trim($data["task_id"]))){
			$task_id="g.task_id='".$data["task_id"]."'";
		}
		$sql = "select 
					s.id as id,
					avg(ss.score) as score,
					s.`name`
					from 
					student_score ss,
					student_group sg,
					`group` g,
					student s
					where ss.student_group_id=sg.id 
					and sg.student_id=s.id 
					and sg.group_id=g.id 
					and $task_id 
					GROUP BY ss.student_group_id";
		$result = $this -> sql -> query($sql);
		return $result;
	}
	function findGroupScoreSylloge($data) {
		$lim="";
		$task_id="g.task_id";
		if(isset($data["size"])&& !empty(trim($data["size"]))){
			$lim=" limit ".$data["page"].",".$data["size"];
		}
		if(isset($data["task_id"])&& !empty(trim($data["task_id"]))){
			$task_id="g.task_id='".$data["task_id"]."'";
		}
		$sql = "select 
				g.id as id,
				avg(gs.score) as score
				from 
				`group` g,
				group_score gs
				where gs.group_id=g.id 
				and $task_id 
				GROUP BY gs.group_id";
		$result = $this -> sql -> query($sql);
		return $result;
	}
	function createTask($data) {
		$array = array(
			"table" => "task",
			"data" => $data
		);
		$result = $this -> sql -> insert($array);
		return $result;
	}

	//修改任务信息
	function modifyTaskInfo($data, $id) {
		$array = array("id" => $id, "table" => "task", "data" => $data);
		$result = $this -> sql -> modify($array);
		return $result;
	}
	//删除任务
	function deleteTaskById($data){
		$array=array(
			"table"=>"task",
			"fields"=>"id",
			"data"=>$data
		);
		$result=$this->sql->delete($array);
		return $result;
	}

}
?>