<?php
include_once "./../handler/handler.php";
include_once "./../service/selectService.php";
include_once "./../utils/session_status.php";
if (sessionIsLogin()) {
	$selectService = new SelectService();
	$data = array(
		"key"=>@$_GET["key"],
		"value"=> @$_GET["value"]
	);
	$result=$selectService->sreachStudent($data);
	succeedOfInfo("查询学生成功", $result);
} else {
	error("用户未登录");
}
?>