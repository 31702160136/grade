<?php
include_once "./../handler/handler.php";
include_once "./../service/selectService.php";
include_once "./../utils/session_status.php";
if (sessionIsLogin()) {
	$selectService = new SelectService();
	$data = array(
		"task_id"=>@$_GET["task_id"],
		"key"=>@$_GET["key"],
		"value"=> @$_GET["value"]
	);
	$result_sreach=$selectService->sreachGroup($data);
	$result=$selectService->getGroupsByTaskId($data);
	//	保存组内所有分数总和
	//
	$sum=0;
	//设置未设置队长和评分的默认提示
	//
	for($i=0;$i<count($result_sreach);$i++){
		if($result_sreach[$i]["student_id"]==-1){
			$result_sreach[$i]["student"]="未设置队长";
		}else{
			$data=array(
				"id"=>$result_sreach[$i]["student_id"]
			);
			$result_stu=$selectService->getStudentById($data);
			$result_sreach[$i]["student"]=$result_stu["name"];
		}
		if($result_sreach[$i]["teacher_by_score"]==-1){
			$result_sreach[$i]["teacher_by_score"]="未评分";
		}
		
	}
	
	
	//	整理组内互评的分数
	//
	for($i=0;$i<count($result);$i++){
		$sc_data=array(
			"group_id"=>$result[$i]["id"]
		);
		$score=$selectService->getGroupScoreByGroId($sc_data);
		$result[$i]["score_percent"]=0;
		for($k=0;$k<count($score);$k++){
			if(count($score[$k])>0){
				$result[$i]["score_percent"]+=$score[$k]["score"];
			}
		}
		$sum+=$result[$i]["score_percent"];
	}
	
	//	转换成员分数在组内的百分比
	//
	for($i=0;$i<count($result);$i++){
		if($result[$i]["score_percent"]!=0){
			$result[$i]["score_percent"]/=$sum;
			$result[$i]["score_percent"]=round($result[$i]["score_percent"],2);
			$result[$i]["score_percent"]*=100;
		}
		$result[$i]["score_percent"].="%";
	}
	//成绩赋值给搜索组内成员
	//
	for($i=0;$i<count($result_sreach);$i++){
		for($k=0;$k<count($result);$k++){
			if($result_sreach[$i]["id"]==$result[$k]["id"]){
				$result_sreach[$i]["score_percent"]=$result[$k]["score_percent"];
				break;
			}
		}
	}
	succeedOfInfo("搜索小组成功", $result_sreach);
} else {
	error("用户未登录");
}
?>