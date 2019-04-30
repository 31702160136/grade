<?php
include_once "./../handler/handler.php";
include_once "./../service/selectService.php";
include_once "./../utils/session_status.php";
if (sessionIsLogin()) {
	$selectService = new SelectService();
	$data = array(
		"page" => @$_GET["page"],
		"size" => @$_GET["size"]
	);
	switch(getSessionRole()){
		case "admin":
			$result = $selectService ->getTasks($data);
			break;
		case "teacher":
			$data["teacher_id"]=getSessionId();
			$result = $selectService ->getTasksByTeacherId($data);
			break;
		default :
			error("未知角色，不能查询任务");
			break;
	}
	succeedOfInfo("查询任务列表成功", $result);
} else {
	error("用户未登录");
}
?>