<?php
include_once "./../handler/handler.php";
include_once "./../service/deleteService.php";
include_once "./../service/modifyService.php";
include_once "./../service/selectService.php";
include_once "./../utils/session_status.php";
if(sessionIsLogin()){
	$deleteService=new DeleteService();
	$modifyService=new ModifyService();
	$selectService=new SelectService();
	$data=array(
		"student_id"=>getSessionId(),
		"group_id"=>@$_POST["group_id"]
	);
	$result=$deleteService->delStuGroupByStuIdAndGroupId($data);
	if($result){
		$data_member=array(
			"group_id"=>@$_POST["group_id"]
		);
		$result_member=$selectService->getStudentGroupByGroupId($data_member);
		if(count($result_member)>0){
			$data_modify=array(
				"id"=>$data["group_id"],
				"student_id"=>-1
			);
			$result_modify=$modifyService->modifyGroupInfo($data_modify);
			if($result_modify){
				succeed("退出小组成功");
			}else{
				error("退出小组失败");
			}
		}else{
			$data_group=[];
			array_push($data_group,$data["group_id"]);
			$result_delGroup=$deleteService->delGroupById($data_group);
			if($result_delGroup){
				succeed("小组已解散");
			}else{
				error("解散小组失败");
			}
		}
		
	}else{
		error("退出小组失败");
	}
}else{
	error("用户未登录");
}
?>