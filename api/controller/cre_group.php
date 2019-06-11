<?php
include_once "./../handler/handler.php";
include_once "./../service/create.php";
include_once "./../utils/session_status.php";
include_once "./../boss/boss.php";
if(sessionIsLogin()){
	boss("cre_group");
	$createService = new CreateService();
	$data = array(
		"name" => trim(@$_POST["name"]),
		"task_id"=>@$_POST["task_id"],
		"student_id"=>getSessionId()
	);
	$result = $createService -> createGroup($data);
	if ($result) {
		succeed("创建小组成功");
	} else {
		error("创建小组失败");
	}
}else{
	error("用户未登录");
}
?>