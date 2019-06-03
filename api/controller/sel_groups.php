<?php
include_once "./../handler/handler.php";
include_once "./../service/select.php";
include_once "./../utils/session_status.php";
include_once "./../utils/tools.php";
if (sessionIsLogin()) {
	$selectService = new SelectService();
	$data=array(
		"name_s"=>isset($_GET["name_s"])?$_GET["name_s"]:null,
		"task_id"=>@$_GET["task_id"],
		"page"=>isset($_GET["page"])?$_GET["page"]:0,
		"size"=>isset($_GET["size"])?$_GET["size"]:10
	);
	//查询结果，用于数据
	$result1=$selectService->getGroups($data);
	$group_id=-1;
	for($i=0;$i<count($result1);$i++){
		$data_mem=array(
			"student_id"=>getSessionId(),
			"group_id"=>$result1[$i]["id"]
		);
		$res_stu=$selectService->getMember($data_mem);
		if(count($res_stu)>0){
			$group_id=$result1[$i]["id"];
		}
	}
	
	for($i=0;$i<count($result1);$i++){
		if($group_id!=-1){
			$data_score=array(
				"from_group_id"=>$group_id,
				"group_id"=>$result1[$i]["id"]
			);
			$score=$selectService->getGroupScore($data_score);
			if(count($score)>0){
				$result1[$i]["score"]=$score[0]["score"];
			}else{
				$result1[$i]["score"]="未评分";
			}
			$data_mem2 = array(
				"group_id"=>$result1[$i]["id"],
				"student_id"=>getSessionId()
			);
			$result3=$selectService ->getMember($data_mem2);
			if(count($result3)>0){
				$result1[$i]["score"]="所在组";
			}
		}else{
			$result1[$i]["score"]="未评分";
		}
	}
	$size=$data["size"];
	$data["page"]=null;
	$data["size"]=null;
	//查询结果，用于转换总页数
	$result2=$selectService->getGroups($data);
	$pages=getPage($result2,$size);
	$outData=array(
		"pages"=>$pages,
		"data"=>$result1
	);
	succeedOfInfo("查询小组成功", $outData);
} else {
	error("用户未登录");
}

?>