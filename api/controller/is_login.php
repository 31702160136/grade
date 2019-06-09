<?php
include_once "./../utils/session_status.php";
include_once "./../handler/handler.php";
include_once "./../boss/boss.php";
if(sessionIsLogin()){
	boss("is_login");
	succeed("用户已登录");
}else{
	error("用户未登录");
}
?>