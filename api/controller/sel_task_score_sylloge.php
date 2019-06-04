<?php
include_once "./../handler/handler.php";
include_once "./../service/select.php";
include_once "./../utils/session_status.php";
include_once "./../utils/tools.php";
if (sessionIsLogin()) {
	$selectService = new SelectService();
	$data_score=array(
		"task_id"=>@$_GET["task_id"]
	);
	$data_score["id"]=$data_score["task_id"];
	$score=$selectService->getTaskScoreSylloge($data_score);
	$res_task=$selectService->getTasks($data_score);
	
	
	$teacher_w=0;
	$group_w=0;
	$student_w=0;
	for($i=0;$i<count($score);$i++){
		if(@$score[$i]["teacher_score"]!=0){
			$score[$i]["teacher_score"]=round($score[$i]["teacher_score"]);
			$teacher_w=($res_task[0]["weight_teacher"]*0.01)*$score[$i]["teacher_score"];
		}else{
			$score[$i]["teacher_score"]=0;
		}
		if(@$score[$i]["group_score"]!=0){
			$score[$i]["group_score"]=round($score[$i]["group_score"]);
			$group_w=($res_task[0]["weight_group"]*0.01)*$score[$i]["group_score"];
		}else{
			$score[$i]["group_score"]=0;
		}
		if(@$score[$i]["student_score"]!=0){
			$score[$i]["student_score"]=round($score[$i]["student_score"]);
			$student_w=($res_task[0]["weight_group_in"]*0.01)*$score[$i]["student_score"];
		}else{
			$score[$i]["student_score"]=0;
		}
		$score[$i]["score"]=round($teacher_w+$group_w+$student_w);
		$teacher_w=0;
		$group_w=0;
		$student_w=0;
	}
	succeedOfInfo("查询成绩汇总成功", $score);
} else {
	error("用户未登录");
}

?>