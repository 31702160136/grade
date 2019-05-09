<?php
include_once "./../handler/handler.php";
include_once "./../service/selectService.php";
include_once "./../utils/session_status.php";
if (sessionIsLogin()) {
	$selectService = new SelectService();
	$data = array(
		"group_id"=>@$_GET["group_id"],
		"key"=>@$_GET["key"],
		"value"=> @$_GET["value"]
	);
	//搜索组内成员
	//
	$result_sreach=$selectService->sreachStudentGroup($data);
	//根据group_id(组的id)查询组内成员
	//为了计算成绩百分比，先查询组内所有成员，然后总结好组内成绩百分比再赋值给搜索到的成员的成绩
	$result=$selectService->getStudentGroupByGroupId($data);
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
	succeedOfInfo("查询成员成功", $result_sreach);
} else {
	error("用户未登录");
}
?>