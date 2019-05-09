<?php
include_once "./../handler/handler.php";
include_once "./../service/createService.php";
include_once "./../service/SelectService.php";
include_once "./../utils/session_status.php";
if (sessionIsLogin()) {
	$createService = new CreateService();
	$selectService=new SelectService();
	switch(getSessionRole()){
		case "admin":
			teacher($selectService,$createService);
			break;
		case "teacher":
			teacher($selectService,$createService);
			break;
		case "student":
			student($selectService,$createService);
			break;
	}
} else {
	error("用户未登录");
}

//教师
//
function teacher($select,$create){
	$data = array(
		"name" => @$_POST["name"],
		"task_id" => @$_POST["task_id"]
	);
	$result = $create -> createGroup($data);
	if ($result) {
		succeed("添加小组成功");
	} else {
		error("添加小组失败");
	}
}
//学生
//
function student($select,$create){
	$data = array(
		"name" => @$_POST["name"],
		"task_id" => @$_POST["task_id"],
		"student_id"=>getSessionId()
	);
	$result_bool=$select->isTheTaskGroupHaveMember($data);
	if(!$result_bool){
		$result = $create -> createGroup($data);
		if ($result) {
			$result_ts=$select->getStuGroupBytaskIdAndStuId($data);
			$data_menber=array(
				"group_id"=>$result_ts["id"],
				"student_id"=>getSessionId()
			);
			$result_sg = $create -> createStudentGroup($data_menber);
			if($result_sg){
				succeed("添加小组成功");
			}else{
				error("添加小组失败");
			}
		} else {
			error("添加小组失败");
		}
	}else{
		error("创建小组失败:请先退出当前小组再进行创建");
	}
}
?>