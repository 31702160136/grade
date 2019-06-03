<?php
include_once "./../handler/handler.php";
include_once "./../service/delete.php";
include_once "./../service/select.php";
include_once "./../utils/session_status.php";
if(sessionIsLogin()){
	$deleteService=new DeleteService();
	$selectService = new SelectService();
	$data = array(
		"group_id"=>@$_POST["group_id"]
	);
	$result = $selectService ->getGroups($data);
	$data = array(
		"group_id"=>@$_POST["group_id"],
		"student_id"=>@$result[0]["student_id"]
	);
	$result2=$selectService ->getMember($data);
	if(in_array($result2[0]["id"], @$_POST["ids"])){
		error("不能删除自己");
	}
	$data=@$_POST["ids"];
	$result=$deleteService->delStudentGroupById($data);
	if($result){
		succeed("删除成员成功");
	}else{
		error("删除成员失败");
	}
}else{
	error("用户未登录");
}
?>