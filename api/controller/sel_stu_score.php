<?php
include_once "./../handler/handler.php";
include_once "./../service/select.php";
include_once "./../utils/session_status.php";
include_once "./../utils/tools.php";
include_once "./../boss/boss.php";
if (sessionIsLogin()) {
	boss("sel_stu_score");
	$selectService = new SelectService();
	$data_score=array(
		"student_group_id"=>@$_GET["student_group_id"]
	);
	$score=$selectService->getMemberScore($data_score);
	succeedOfInfo("查询学生成绩成功", $score);
} else {
	error("用户未登录");
}

?>