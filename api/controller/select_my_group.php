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
	$result=$selectService->getGroupsByTaskId($data);
	for($i=0;$i<count($result);$i++){
		$data_group=array(
			"group_id"=>$result[$i]["id"]
		);
		$result_stuGroup=$selectService->getStudentGroupByGroupId($data_group);
		for($k=0;$k<count($result_stuGroup);$k++){
			if($result_stuGroup[$k]["student_id"]==getSessionId()){
				$result_stuGroup[$k]["name"]=$result[$i]["name"];
				succeedOfInfo("查询个人小组成功", $result_stuGroup[$k]);
			}
		}
	}
	error("查询个人小组失败");
} else {
	error("用户未登录");
}
?>