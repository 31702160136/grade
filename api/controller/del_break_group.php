<?php
include_once "./../handler/handler.php";
include_once "./../service/delete.php";
include_once "./../utils/session_status.php";
include_once "./../boss/boss.php";
if(sessionIsLogin()){
	boss("del_break_group");
	$deleteService=new DeleteService();
	$data=array(
		"student_id"=>getSessionId(),
		"group_id"=>@$_POST["group_id"]
	);
	$result=$deleteService->delStuGroupByStuIdAndGroupId($data);
	if($result){
		succeed("退出小组成功");
	}else{
		error("退出小组失败");
	}
}else{
	error("用户未登录");
}
?>