<?php
include_once "./../handler/handler.php";
include_once "./../service/select.php";
include_once "./../utils/session_status.php";
include_once "./../utils/tools.php";
if (sessionIsLogin()) {
	$selectService = new SelectService();
	$data=array(
		"curriculum"=>isset($_GET["curriculum"])?$_GET["curriculum"]:null,
		"is_archive"=>isset($_GET["is_archive"])?$_GET["is_archive"]:null,
		"page"=>isset($_GET["page"])?$_GET["page"]:0,
		"size"=>isset($_GET["size"])?$_GET["size"]:10
	);
	switch(getSessionRole()){
		case "admin":
			break;
		case "teacher":
			$data["teacher_id"]=getSessionId();
			break;
		case "student":
			break;
	}
	//查询结果，用于数据
	$result1=$selectService->getTasks($data);
	$size=$data["size"];
	$data["page"]=null;
	$data["size"]=null;
	//查询结果，用于转换总页数
	$result2=$selectService->getTasks($data);
	$pages=getPage($result2,$size);
	$outData=array(
		"pages"=>$pages,
		"data"=>$result1
	);
	succeedOfInfo("查询任务成功", $outData);
} else {
	error("用户未登录");
}

?>