<?php
include_once "./../handler/handler.php";
include_once "./../service/selectService.php";
include_once "./../utils/session_status.php";
include_once "./../boss/boss.php";
if (sessionIsLogin()) {
	boss("get_user_info");
	$selectService = new SelectService();
	$data=array(
		"username"=>getSessionUserName()
	);
	switch(getSessionRole()){
		case "admin":
			$result=$selectService->getAdminByUserName($data);
			break;
		case "teacher":
			$result=$selectService->getTeacherByUserName($data);
			break;
		case "student":
			
			break;
	}
	succeedOfInfo("查询用户信息成功", $result);
} else {
	error("用户未登录");
}
?>