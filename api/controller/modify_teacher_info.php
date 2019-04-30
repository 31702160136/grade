<?php
include_once "./../handler/handler.php";
include_once "./../service/modifyService.php";
include_once "./../utils/session_status.php";
if (sessionIsLogin()) {
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