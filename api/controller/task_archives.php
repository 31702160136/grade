<?php
include_once "./../handler/handler.php";
include_once "./../service/modify.php";
include_once "./../utils/session_status.php";
include_once "./../boss/boss.php";
if (sessionIsLogin()) {
	boss("mod_task_info");
	$modifyService = new ModifyService();
	$ids=@$_POST["ids"];
	if(!is_array($ids)){
		error("请输入正确参数");
	}
	$result=false;
	for($i=0;$i<count($ids);$i++){
		$data = array(
			"id"=>$ids[$i],
			"is_archive"=>0
		);
		$result = $modifyService ->modifyTaskInfo($data);
	}
	if ($result) {
		succeed("取消存档成功");
	} else {
		error("取消存档失败");
	}
} else {
	error("用户未登录");
}
?>