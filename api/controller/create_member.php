<?php
include_once "./../handler/handler.php";
include_once "./../service/createService.php";
include_once "./../service/SelectService.php";
include_once "./../utils/session_status.php";
if (sessionIsLogin()) {
	$createService = new CreateService();
	$selectService=new SelectService();
	if(is_array(@$_POST["student_id"])){
		//无返回值
		arr($createService,$selectService);
	}else{
		$result=notArr($createService,$selectService);
	}
	if($result){
		succeed("添加成员成功");
	}else{
		error("添加成员失败");
	}
} else {
	error("用户未登录");
}
function arr($create,$select){
	$data = array(
		"student_id" => @$_POST["student_id"],
		"group_id" => @$_POST["group_id"],
		"task_id"=>@$_POST["task_id"]
	);
	$sign=0;
	for($i=0;$i<count($data["student_id"]);$i++){
		$data2=array(
			"student_id" => $data["student_id"][$i],
			"group_id" => $data["group_id"],
			"task_id"=>@$_POST["task_id"]
		);
		$result_bool=$select->isTheTaskGroupHaveMember($data2);
		if(!$result_bool){
			unset($data2["task_id"]);
			$result = $create -> createStudentGroup($data2);
		}else{
			$sign++;
		}
	}
	if($sign==0){
		succeed("添加成功");
	}else if($sign<count($data["student_id"])){
		succeed("添加成功，其中有".$sign."个学生添加失败，原因：已加入其他组");
	}else{
		error("添加失败,学生已加入其他组");
	}
}
function notArr($create,$select){
	$data=array(
		"student_id" => @$_POST["student_id"],
		"group_id" => @$_POST["group_id"],
		"task_id"=>@$_POST["task_id"]
	);
	$result_bool=$select->isTheTaskGroupHaveMember($data);
	if(!$result_bool){
		unset($data["task_id"]);
		$result = $create -> createStudentGroup($data);
		if ($result) {
			return true;
		}else{
			return false;
		}
	}
}
?>