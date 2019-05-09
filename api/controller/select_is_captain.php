<?php
include_once "./../handler/handler.php";
include_once "./../service/selectService.php";
include_once "./../utils/session_status.php";
if (sessionIsLogin()) {
	$selectService = new SelectService();
	$data = array(
		"id"=>@$_GET["group_id"]
	);
	$result = $selectService ->getGroupsById($data);
	if($result["student_id"]==getSessionId()){
		succeed("队长");
	}else{
		error("不是队长");
	}
} else {
	error("用户未登录");
}
?>