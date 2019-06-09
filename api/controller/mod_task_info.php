<?php
include_once "./../handler/handler.php";
include_once "./../service/modify.php";
include_once "./../utils/session_status.php";
include_once "./../boss/boss.php";
if (sessionIsLogin()) {
	boss("mod_task_info");
	$modifyService = new ModifyService();
	$data = array(
		"id"=>@$_POST["id"],
		"curriculum" => isset($_POST["curriculum"])?$_POST["curriculum"]:null,
		"semester"=> isset($_POST["semester"])?$_POST["semester"]:null,
		"class"=> isset($_POST["class"])?$_POST["class"]:null,
		"is_archive"=> isset($_POST["is_archive"])?$_POST["is_archive"]:null,
		"weight_teacher"=> isset($_POST["weight_teacher"])?$_POST["weight_teacher"]:null,
		"weight_group"=> isset($_POST["weight_group"])?$_POST["weight_group"]:null,
		"weight_group_in"=> isset($_POST["weight_group_in"])?$_POST["weight_group_in"]:null
	);
	$result = $modifyService ->modifyTaskInfo($data);
	if ($result) {
		succeed("修改任务信息成功");
	} else {
		error("修改任务信息失败");
	}
} else {
	error("用户未登录");
}
?>