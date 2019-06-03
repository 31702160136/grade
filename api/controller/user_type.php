<?php
include_once "./../utils/session_status.php";
include_once "./../handler/handler.php";
include_once "./../service/select.php";
if(sessionIsLogin()){
	$selectService = new SelectService();
	if(getSessionRole()=="student"){
		$data=array(
			"username"=>getSessionUserName()
		);
		$result=$selectService->getStudents($data);
	}else if(getSessionRole()=="teacher"){
		$data=array(
			"username"=>getSessionUserName()
		);
		$result=$selectService->getTeachers($data);
	}else if(getSessionRole()=="admin"){
		$data=array(
			"username"=>getSessionUserName()
		);
		$result=$selectService->getAdminByUserName($data);
	}
	$data=array(
		"role"=>getSessionRole(),
		"info"=>$result[0]
	);
	succeedOfInfo("获取用户类型成功", $data);
}else{
	error("用户未登录");
}
?>