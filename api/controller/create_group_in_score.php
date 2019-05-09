<?php
include_once "./../handler/handler.php";
include_once "./../service/createService.php";
include_once "./../service/SelectService.php";
include_once "./../utils/session_status.php";
if (sessionIsLogin()) {
	$createService = new CreateService();
	$data = array(
		"score" => @$_POST["score"],
		"from_group_id" => @$_POST["from_group_id"],
		"group_id" => @$_POST["group_id"]
	);
	$result = $createService -> createGroupInScore($data);
	if ($result) {
		succeed("评分成功");
	} else {
		error("评分失败");
	}
} else {
	error("用户未登录");
}
?>