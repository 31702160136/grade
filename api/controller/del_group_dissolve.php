<?php
include_once "./../handler/handler.php";
include_once "./../service/delete.php";
include_once "./../service/select.php";
include_once "./../utils/session_status.php";
include_once "./../boss/boss.php";
if(sessionIsLogin()){
	boss("del_group_dissolve");
	$selectService = new SelectService();
	$deleteService=new DeleteService();
	$data=array(
		"group_id"=>@$_POST["group_id"],
		"task_id"=>@$_POST["task_id"],
		"student_id"=>getSessionId()
	);
	$result=$selectService->getGroups($data);
	if(!(count($result)>0)){
		error("只有队长才能解散队伍");
	}
	$data=array($result[0]["id"]);
	$result=$deleteService->delGroupById($data);
	if($result){
		succeed("删除小组成功");
	}else{
		error("删除小组失败");
	}
}else{
	error("用户未登录");
}
?>