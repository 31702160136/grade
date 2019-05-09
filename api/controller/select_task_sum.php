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
		case "student":
			$result = $selectService ->getTasks($data);
			break;
		default :
			error("未知角色，不能查询任务");
			break;
	}
	if(is_float((count($result)/10))){
		$sum=intval((count($result)/10))+1;
	}else{
		$sum=1;
	}
	succeedOfInfo("查询任务页数成功", $sum);
} else {
	error("用户未登录");
}
?>