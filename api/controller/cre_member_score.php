<?php
include_once "./../handler/handler.php";
include_once "./../service/create.php";
include_once "./../service/modify.php";
include_once "./../service/select.php";
include_once "./../utils/session_status.php";
include_once "./../boss/boss.php";
if (sessionIsLogin()) {
	boss("cre_member_score");
	$createService = new CreateService();
	$selectService = new SelectService();
	$modifyService = new ModifyService();
	$data = array(
		"from_student_id" => getSessionId(),
		"student_group_id" => @$_POST["student_group_id"]
	);
	$inspect = $selectService->getMemberScore($data);
	if(count($inspect)>0){
		$data_mod=array(
			"id"=>$inspect[0]["id"],
			"score"=>@$_POST["score"]
		);
		$result=modifyScore($modifyService,$data_mod);
	}else{
		$data = array(
			"from_student_id" => getSessionId(),
			"student_group_id" => @$_POST["student_group_id"],
			"score"=>@$_POST["score"]
		);
		$result=createScore($createService,$data);
	}
	if ($result) {
		succeed("评分成功");
	} else {
		error("评分失败");
	}
} else {
	error("用户未登录");
}
function modifyScore($modifyService,$data_mod){
	$result=$modifyService->modifyStudentScore($data_mod);
	return $result;
}
function createScore($createService,$data){
	$result = $createService -> createStudentScore($data);
	return $result;
}
?>