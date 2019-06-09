<?php
include_once "./../handler/handler.php";
include_once "./../service/select.php";
include_once "./../utils/session_status.php";
include_once "./../boss/boss.php";
if (sessionIsLogin()) {
	$selectService = new SelectService();
	$data = array(
		"group_id"=>@$_GET["group_id"]
	);
	$result = $selectService ->getGroups($data);
	succeedOfInfo("获取学生组内信息成功", $result[0]);
} else {
	error("用户未登录");
}
?>