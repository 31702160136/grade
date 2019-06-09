<?php
include_once "./../handler/handler.php";
include_once "./../service/create.php";
include_once "./../service/modify.php";
include_once "./../service/select.php";
include_once "./../utils/session_status.php";
include_once "./../boss/boss.php";
if (sessionIsLogin()) {
	boss("cre_group_score");
	$createService = new CreateService();
	$selectService = new SelectService();
	$modifyService = new ModifyService();
	$inspect = array(
		"task_id" =>@$_POST["task_id"],
		"student_id" =>  getSessionId()
	);
	$res_gro = $selectService->getGroups($inspect);
	if(count($res_gro)>0){
		$inspect2=array(
			"group_id"=>@$_POST["group_id"],
			"from_group_id"=>$res_gro[0]["id"]
		);
		$res_sc=$selectService->getGroupScore($inspect2);
		if(count($res_sc)>0){
			$data_sc=array(
				"id"=>$res_sc[0]["id"],
				"score"=>@$_POST["score"]
			);
			$result=$modifyService->modifyGroupScore($data_sc);
		}else{
			$data_sc=array(
				"from_group_id"=>$res_gro[0]["id"],
				"group_id"=>@$_POST["group_id"],
				"score"=>@$_POST["score"]
			);
			$result = $createService -> createGroupScore($data_sc);
		}
	}else{
		error("请让队长评分");
	}
	if ($result) {
		succeed("评分成功");
	} else {
		error("评分失败");
	}
} else {
	error("用户未登录");
}
?>