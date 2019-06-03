<?php
include_once "./../handler/handler.php";
include_once "./../service/delete.php";
include_once "./../utils/session_status.php";
if(sessionIsLogin()){
	$deleteService=new DeleteService();
	$data=@$_POST["ids"];
	$result=$deleteService->delTeacherById($data);
	if($result){
		succeed("删除教师成功");
	}else{
		error("删除教师失败");
	}
}else{
	error("用户未登录");
}
?>