<?php
include_once "./../handler/handler.php";
include_once "./../service/create.php";
include_once "./../utils/session_status.php";
include_once "./../boss/boss.php";
if (sessionIsLogin()) {
	boss("cre_teacher");
	$createService = new CreateService();
	$data = array(
		"name" => @$_POST["name"],
		"username" => @$_POST["username"],
		"password" => @$_POST["password"]
	);
	$result = $createService -> createTeacher($data);
	if ($result) {
		succeed("创建教师成功");
	} else {
		error("创建教师失败");
	}
} else {
	error("用户未登录");
}
?>