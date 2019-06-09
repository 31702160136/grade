<?php
include_once "./../handler/handler.php";
include_once "./../service/select.php";
include_once "./../utils/session_status.php";
include_once "./../utils/tools.php";
include_once "./../boss/boss.php";
if (sessionIsLogin()) {
	boss("sel_user_info");
	$data=array(
		"name"=>getSessionMyName(),
		"role"=>getSessionRole(),
		"username"=>getSessionUserName()
	);
	succeedOfInfo("查询当前账号信息成功", $data);
} else {
	error("用户未登录");
}

?>