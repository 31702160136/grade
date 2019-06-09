<?php
include_once "./../handler/handler.php";
include_once "./../service/delete.php";
include_once "./../utils/session_status.php";
include_once "./../boss/boss.php";
if(sessionIsLogin()){
	boss("del_group");
	$deleteService=new DeleteService();
	$data=@$_POST["ids"];
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