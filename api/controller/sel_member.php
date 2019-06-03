<?php
include_once "./../handler/handler.php";
include_once "./../service/select.php";
include_once "./../utils/session_status.php";
include_once "./../utils/tools.php";
if (sessionIsLogin()) {
	$selectService = new SelectService();
	$data=array(
		"name_s"=>isset($_GET["name_s"])?$_GET["name_s"]:null,
		"username_s"=>isset($_GET["username_s"])?$_GET["username_s"]:null,
		"task_id"=>$_GET["task_id"],
		"group_id"=>$_GET["group_id"],
		"page"=>isset($_GET["page"])?$_GET["page"]:0,
		"size"=>isset($_GET["size"])?$_GET["size"]:10
	);
	//查询结果，用于数据
	$result1=$selectService->getMember($data);
	//与成绩合并
	for($i=0;$i<count($result1);$i++){
		$data_score=array(
			"from_student_id"=>getSessionId(),
			"student_group_id"=>$result1[$i]["id"]
		);
		$score=$selectService->getMemberScore($data_score);
		if(count($score)>0){
			$result1[$i]["score"]=$score[0]["score"];
			$result1[$i]["score_id"]=$score[0]["id"];
		}else{
			$result1[$i]["score"]="未评分";
			$result1[$i]["score_id"]=0;
		}
		if($result1[$i]["student_id"]==getSessionId()){
			$result1[$i]["score"]="自己";
		}
	}
	$size=$data["size"];
	$data["page"]=null;
	$data["size"]=null;
	//查询结果，用于转换总页数
	$result2=$selectService->getMember($data);
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