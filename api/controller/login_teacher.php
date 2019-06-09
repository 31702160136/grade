<?php
include_once "./../handler/handler.php";
include_once "./../service/select.php";
include_once "./../utils/session_status.php";
include_once "./../boss/boss.php";
boss("login_teacher");
$username = @$_POST["username"];
$password = @$_POST["password"];
$data=array(
	"username"=>$username
);
$selectService = new SelectService();
$result = $selectService ->getTeachers($data);
$item=@$result[0];
if (@$item["password"] == $password) {
	sessionLogin($item);
	$data = array("name" => $item["name"],"role" => $item["role"]);
	succeedOfInfo("登陆成功", $data);
} else {
	sessionOutLogin();
	error("密码错误"); 
}
?>