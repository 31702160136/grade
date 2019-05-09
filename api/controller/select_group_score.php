<?php
include_once "./../handler/handler.php";
include_once "./../service/selectService.php";
include_once "./../utils/session_status.php";
if (sessionIsLogin()) {
	$selectService = new SelectService();
	$data = array(
		"group_id"=>@$_GET["group_id"],
		"page" => @$_GET["page"],
		"size" => @$_GET["size"]
	);
	$result=$selectService->getGroupScoreByGroId($data);
	for($i=0;$i<count($result);$i++){
		$dataGro=array(
			"id"=>$result[$i]["from_group_id"]
		);
		$result_gro=$selectService->getGroupsById($dataGro);
		if(isset($result_gro)){
			$result[$i]["name"]=$result_gro["name"];
		}else{
			$result[$i]["name"]="空气评的分";
		}
	}
	succeedOfInfo("查询学生成绩列表成功", $result);
} else {
	error("用户未登录");
}
?>