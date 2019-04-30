<?php
include_once "./../handler/handler.php";
include_once "./../utils/session_status.php";
include_once "./../service/createService.php";
include_once "./../service/deleteService.php";

delStudent();
//删除学生,成功
function delStudent(){
	$deleteService =new DeleteService();
	$data=[1];
	$result=$deleteService->delStudentById($data);
	if($result){
		succeed("删除学生成功");
	}else{
		error("删除学生失败");
	}
}

//创建学生,成功
function createStudent(){
	$createService = new CreateService();
	$data=array(
		"name"=>"张三",
		"username"=>"1231",
		"password"=>"123",
		"department"=>"计算机",
		"class"=>"互联"
	);
	$result=$createService->createStudent($data);
	if($result){
		succeed("创建学生成功");
	}else{
		error("创建学生失败");
	}
}

?>