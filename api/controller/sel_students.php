<?php
include_once "./../handler/handler.php";
include_once "./../service/select.php";
include_once "./../utils/session_status.php";
include_once "./../utils/tools.php";
if (sessionIsLogin()) {
	$selectService = new SelectService();
	$data=array(
		"name"=>isset($_GET["name"])?$_GET["name"]:null,
		"username_s"=>isset($_GET["username_s"])?$_GET["username_s"]:null,
		"page"=>isset($_GET["page"])?$_GET["page"]:0,
		"size"=>isset($_GET["size"])?$_GET["size"]:10
	);
	//查询结果，用于数据
	$result1=$selectService->getStudents($data);
	$size=$data["size"];
	$data["page"]=null;
	$data["size"]=null;
	//查询结果，用于转换总页数
	$result2=$selectService->getStudents($data);
	$pages=getPage($result2,$size);
	$outData=array(
		"pages"=>$pages,
		"data"=>$result1
	);
	succeedOfInfo("查询学生成功", $outData);
} else {
	error("用户未登录");
}

?>