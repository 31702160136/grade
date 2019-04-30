<?php
function sessionIsLogin() {
	@session_start();
	if (@$_SESSION['username'] != null) {
		return true;
	} else {
		return false;
	}
}

function sessionLogin($data) {
	@session_start();
	$_SESSION['username'] = $data["username"];
	$_SESSION['role'] = $data["role"];
	$_SESSION['id'] = $data["id"];
}

function getSessionUserInfo() {
	@session_start();
	$data=array();
	$data["username"]=$_SESSION['username'];
	$data["role"]=$_SESSION['role'];
	$data["id"]=$_SESSION['id'];
	return $data;
}

function getSessionUserName() {
	@session_start();
	return $_SESSION['username'];
}

function getSessionRole() {
	@session_start();
	return $_SESSION['role'];
}

function getSessionId() {
	@session_start();
	return $_SESSION['id'];
}

function sessionOutLogin() {
	@session_start();
	@session_unset();
	@session_destroy();

	if (empty($_SESSION)) {
		return true;
	} else {
		return false;
	}
}
?>