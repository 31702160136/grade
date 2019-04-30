<?php
function error($msg){
	$arr=array(
		"status"=>false,
		"message"=>$msg,
		"code"=>403
	);
	echo json_encode($arr);
	exit(0);
}
function succeed($msg){
	$arr=array(
		"status"=>true,
		"message"=>$msg,
		"code"=>200
	);
	echo json_encode($arr);
	exit(0);
}
function succeedOfInfo($msg,$data){
	$arr=array(
		"status"=>true,
		"message"=>$msg,
		"code"=>200,
		"data"=>$data
	);
	echo json_encode($arr);
	exit(0);
}
?>