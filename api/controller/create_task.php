<?php
include_once "./../handler/handler.php";
include_once "./../service/createService.php";
include_once "./../utils/session_status.php";
if (sessionIsLogin()) {
	$createService = new CreateService();
	$data = array(
		"curriculum" => @$_POST["curriculum"],
		"semester" => @$_POST["semester"],
		"class" => @$_POST["class"],
		"teacher_id" => getSessionId()
	);
	$result = $createService -> createTask($data);
	if ($result) {
		succeed("创建任务成功");
	} else {
		error("创建任务失败");
	}
} else {
	error("用户未登录");
}
?>