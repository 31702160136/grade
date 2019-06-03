<?php
include_once "./../handler/handler.php";
include_once "./../service/create.php";
include_once "./../utils/session_status.php";
if (sessionIsLogin()) {
	$createService = new CreateService();
	$data = array(
		"curriculum" => @$_POST["curriculum"],
		"semester" => @$_POST["semester"],
		"class" => @$_POST["class"],
		"weight_teacher"=>@$_POST["weight_teacher"],
		"weight_group"=>@$_POST["weight_group"],
		"weight_group_in"=>@$_POST["weight_group_in"],
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