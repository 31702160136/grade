<?php
include_once "./../handler/handler.php";
include_once "./../service/select.php";
include_once "./../utils/session_status.php";
include_once "./../utils/tools.php";
include_once "./../boss/boss.php";
if (sessionIsLogin()) {
	boss("sel_group_score");
	$selectService = new SelectService();
	$data_score=array(
		"group_id"=>@$_GET["group_id"]
	);
	$score=$selectService->getGroupScore($data_score);
	succeedOfInfo("查询组成绩成功", $score);
} else {
	error("用户未登录");
}

?>