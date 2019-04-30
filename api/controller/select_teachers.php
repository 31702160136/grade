<?php
include_once "./../handler/handler.php";
include_once "./../service/selectService.php";
include_once "./../utils/session_status.php";
if (sessionIsLogin()) {
	$selectService = new SelectService();
	$data = array(
		"page" => @$_GET["page"],
		"size" => @$_GET["size"]
	);
	$result = $selectService ->getTeachers($data);
	succeedOfInfo("查询教师列表成功", $result);
} else {
	error("用户未登录");
}
?>