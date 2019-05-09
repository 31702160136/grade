<?php
include_once "./../handler/handler.php";
include_once "./../service/modifyService.php";
include_once "./../utils/session_status.php";
if (sessionIsLogin()) {
	$modifyService = new ModifyService();
	$data = array(
		"id"=>@$_POST["id"],
		"student_id"=>@$_POST["student_id"]
	);
	if(is_array($data["student_id"])){
		error("设置错误，不能设置多个队长");
	}
	$result = $modifyService ->modifyGroupInfo($data);
	if ($result) {
		succeed("设置队长成功");
	} else {
		error("设置队长失败");
	}
} else {
	error("用户未登录");
}
?>