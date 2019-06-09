<?php
include_once "./../utils/session_status.php";
include_once "./../handler/handler.php";
include_once "./../service/select.php";
include_once "./../boss/boss.php";
if(sessionIsLogin()){
	boss("user_type");
	$selectService = new SelectService();
	if(getSessionRole()=="student"){
		$data=array(
			"username"=>getSessionUserName()
		);
		$result=$selectService->getStudents($data);
		$result=$result[0];
	}else if(getSessionRole()=="teacher"){
		$data=array(
			"username"=>getSessionUserName()
		);
		$result=$selectService->getTeachers($data);
		$result=$result[0];
	}else if(getSessionRole()=="admin"){
		$data=array(
			"username"=>getSessionUserName()
		);
		$result=$selectService->getAdminByUserName($data);
	}
	$data=array(
		"role"=>getSessionRole(),
		"info"=>$result
	);
	succeedOfInfo("获取用户类型成功", $data);
}else{
	error("用户未登录");
}
?>