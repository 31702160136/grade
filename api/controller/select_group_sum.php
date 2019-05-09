<?php
include_once "./../handler/handler.php";
include_once "./../service/selectService.php";
include_once "./../utils/session_status.php";
if (sessionIsLogin()) {
	$selectService = new SelectService();
	$data = array(
		"task_id"=>@$_GET["task_id"],
		"page" => @$_GET["page"],
		"size" => @$_GET["size"]
	);
	$result = $selectService ->getTasks($data);
	if(is_float((count($result)/10))){
		$sum=intval((count($result)/10))+1;
	}else{
		$sum=1;
	}
	succeedOfInfo("查询小组页数成功", $sum);
} else {
	error("用户未登录");
}
?>