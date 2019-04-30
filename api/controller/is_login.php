<?php
include_once "./../utils/session_status.php";
include_once "./../handler/handler.php";
if(sessionIsLogin()){
	succeed("用户已登录");
}else{
	error("用户未登录");
}
?>