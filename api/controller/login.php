<?php
include_once "./../handler/handler.php";
include_once "./../service/select.php";
include_once "./../utils/session_status.php";
$username = @$_POST["username"];
$password = @$_POST["password"];
$data=array(
	"username"=>$username
);
$selectService = new SelectService();
$result = $selectService ->getAdminByUserName($data);
if ($result["password"] == $password) {
	sessionLogin($result);
	$data = array("name" => $result["name"]);
	succeedOfInfo("登陆成功", $data);
} else {
	sessionOutLogin();
	error("密码错误"); 
}
?>