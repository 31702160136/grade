<?php
include_once "./../handler/handler.php";
include_once "./../service/selectService.php";
include_once "./../utils/session_status.php";
if (sessionIsLogin()) {
	$selectService = new SelectService();
	$data = array(
		"from_group_id"=>@$_GET["group_id"],
		"task_id"=>@$_GET["task_id"],
		"page" => @$_GET["page"],
		"size" => @$_GET["size"]
	);
	$result=$selectService->getGroupScoreByTaskIdAndFromGroId($data);
	$sum=0;
	for($i=0;$i<count($result);$i++){
		if($result[$i]["student_id"]==-1){
			$result[$i]["student"]="未设置队长";
		}else{
			$data=array(
				"id"=>$result[$i]["student_id"]
			);
			$result_stu=$selectService->getStudentById($data);
			$result[$i]["student"]=isset($result_stu)?  $result_stu["name"]:"未设置队长";
		}
		if($result[$i]["teacher_by_score"]==-1){
			$result[$i]["teacher_by_score"]="未评分";
		}
		
		$sc_data=array(
			"group_id"=>$result[$i]["id"]
		);
		$score_percent=$selectService->getGroupScoreByGroId($sc_data);
		$result[$i]["score_percent"]=0;
		for($k=0;$k<count($score_percent);$k++){
			if(count($score_percent[$k])>0){
				$result[$i]["score_percent"]+=$score_percent[$k]["score"];
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
	succeedOfInfo("查询学生成绩列表成功", $result);
} else {
	error("用户未登录");
}
?>