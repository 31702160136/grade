<?php
include_once "./../handler/handler.php";
include_once "./../service/modify.php";
include_once "./../utils/session_status.php";
if (sessionIsLogin()) {
	$modifyService = new ModifyService();
	$data = array(
		"id"=>@$_POST["id"],
		"teacher_by_score"=>@$_POST["teacher_by_score"]
	);
	$result = $modifyService ->modifyGroupInfo($data);
	if ($result) {
		succeed("设置成绩成功");
	} else {
		error("设置成绩失败");
	}
} else {
	error("用户未登录");
}
?>