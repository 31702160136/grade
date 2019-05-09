<?php
include_once "./../handler/handler.php";
include_once "./../service/createService.php";
include_once "./../utils/session_status.php";
$createService = new CreateService();
$data = array(
	"name" => @$_POST["name"],
	"username" => @$_POST["username"],
	"password" => @$_POST["password"],
	"department" => @$_POST["department"],
	"class" => @$_POST["class"]
);
$result = $createService -> createStudent($data);
if ($result) {
	succeed("创建学生成功");
} else {
	error("创建学生失败");
}
?>