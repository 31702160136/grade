<?php
include_once "./../handler/handler.php";
include_once "./../service/selectService.php";
include_once "./../utils/session_status.php";
if (sessionIsLogin()) {
	$selectService = new SelectService();
	$data = array(
		"group_id"=>@$_GET["group_id"],
		"page"=>@$_GET["page"],
		"size"=>@$_GET["size"]
	);
	//根据group_id(组的id)查询组内成员
	//
	$result_in=$selectService->getStudentGroupByGroupId($data);
	$data2 = array(
		"group_id"=>@$_GET["group_id"],
		"page"=>1,
		"size"=>99999
	);
	$result=$selectService->getStudentGroupByGroupId($data2);
	//	保存组内所有分数总和
	//
	$sum=0;
	//	整理组内互评的分数
	//
	for($i=0;$i<count($result);$i++){
		$sc_data=array(
			"student_group_id"=>$result[$i]["id"]
		);
		$score=$selectService->getStudentScoreByStuGroId($sc_data);
		$result[$i]["score_percent"]=0;
		$result[$i]["score"]="未评分";
		for($k=0;$k<count($score);$k++){
			if(count($score[$k])>0){
				$result[$i]["score_percent"]+=$score[$k]["score"];
			}
		}
		$sum+=$result[$i]["score_percent"];
	}
	//获取评分分数
	//
	$data_fromStuId=array(
		"from_student_id"=>getSessionId()
	);
	$result_score=$selectService->getStudentScoreByFromStudentId($data_fromStuId);
	for($k=0;$k<count($result_score);$k++){
		for($j=0;$j<count($result);$j++){
			if($result[$j]["id"]==$result_score[$k]["student_group_id"]){
				$result[$j]["score"]=$result_score[$k]["score"];
			}
		}
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
//	
//	//成绩赋值给组内成员
//	//
	for($i=0;$i<count($result_in);$i++){
		for($k=0;$k<count($result);$k++){
			if($result_in[$i]["id"]==$result[$k]["id"]){
				$result_in[$i]["score_percent"]=$result[$k]["score_percent"];
				$result_in[$i]["score"]=$result[$k]["score"];
			}
		}
	}
	succeedOfInfo("查询成员成功", $result_in);
} else {
	error("用户未登录");
}
?>