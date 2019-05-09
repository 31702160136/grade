<?php
include_once "./../handler/handler.php";
include_once "./../service/selectService.php";
include_once "./../utils/session_status.php";
if (sessionIsLogin()) {
	$selectService = new SelectService();
	$data = array(
		"student_group_id"=>@$_GET["student_group_id"],
		"page" => @$_GET["page"],
		"size" => @$_GET["size"]
	);
	$result=$selectService->getStudentScoreByStuGroId($data);
	for($i=0;$i<count($result);$i++){
		$dataStu=array(
			"id"=>$result[$i]["from_student_id"],
			"page" => @$_GET["page"],
			"size" => @$_GET["size"]
		);
		$result_stu=$selectService->getStudentById($dataStu);
		if(isset($result_stu)){
			$result[$i]["name"]=$result_stu["name"];
		}else{
			$result[$i]["name"]="空气评的分";
		}
	}
	succeedOfInfo("查询学生成绩列表成功", $result);
} else {
	error("用户未登录");
}
?>