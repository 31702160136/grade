<?php
include_once "./../handler/handler.php";
include_once "./../service/select.php";
include_once "./../utils/session_status.php";
if (sessionIsLogin()) {
	$selectService = new SelectService();
	$out_data=array();
	$data = array(
		"group_id"=>@$_GET["group_id"]
	);
	$result = $selectService ->getGroups($data);
	if(@$result[0]["student_id"]==getSessionId()){
		$out_data["captain"]=true;
	}else{
		$out_data["captain"]=false;
	}
	$data = array(
		"group_id"=>@$_GET["group_id"],
		"student_id"=>getSessionId()
	);
	$result2=$selectService ->getMember($data);
	if(count($result2)>0){
		$out_data["is_menber"]=true;
	}else{
		$out_data["is_menber"]=false;
	}
	succeedOfInfo("获取学生组内信息成功", $out_data);
} else {
	error("用户未登录");
}
?>