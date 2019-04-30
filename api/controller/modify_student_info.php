<?php
include_once "./../handler/handler.php";
include_once "./../service/modifyService.php";
include_once "./../utils/session_status.php";
if (sessionIsLogin()) {
	$modifyService = new ModifyService();
	$data = array(
		"id"=>@$_POST["id"],
		"password" => @$_POST["password"],
		"department"=>@$_POST["department"],
		"name"=>@$_POST["name"],
		"class"=>@$_POST["class"]
	);
	$result = $modifyService ->modifyStudentInfo($data);
	if ($result) {
		succeed("修改学生信息成功");
	} else {
		error("修改学生信息失败");
	}
} else {
	error("用户未登录");
}
?>