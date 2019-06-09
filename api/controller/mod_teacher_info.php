<?php
include_once "./../handler/handler.php";
include_once "./../service/modify.php";
include_once "./../utils/session_status.php";
include_once "./../boss/boss.php";
if (sessionIsLogin()) {
	boss("mod_teacher_info");
	$modifyService = new ModifyService();
	$data = array(
		"id"=>@$_POST["id"],
		"password" => @$_POST["password"],
		"name"=>@$_POST["name"]
	);
	$result = $modifyService ->modifyTeacherInfo($data);
	if ($result) {
		succeed("修改教师信息成功");
	} else {
		error("修改教师信息失败");
	}
} else {
	error("用户未登录");
}
?>