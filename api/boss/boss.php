<?php
include_once "./../handler/handler.php";
include_once "./../service/select.php";
include_once "./../utils/session_status.php";
include_once "./../utils/tools.php";
function boss($func,$data=null){
	$func($data);
}

function cre_group_score($data){
	if(!(getSessionRole()=="teacher"||
			getSessionRole()=="student"||
			getSessionRole()=="admin")){
		error("权限不足");
	}
}
function cre_group($data){
	if(!(getSessionRole()=="teacher"||
			getSessionRole()=="student"||
			getSessionRole()=="admin")){
		error("权限不足");
	}
}
function cre_member_score($data){
	if(!(getSessionRole()=="teacher"||
			getSessionRole()=="student"||
			getSessionRole()=="admin")){
		error("权限不足");
	}
}
function cre_member($data){
	if(!(getSessionRole()=="teacher"||
			getSessionRole()=="student"||
			getSessionRole()=="admin")){
		error("权限不足");
	}
}
function cre_student($data){
	
}
function cre_task($data){
	if(!(getSessionRole()=="teacher")){
		error("权限不足");
	}
}
function cre_teacher($data){
	if(!(getSessionRole()=="admin")){
		error("权限不足");
	}
}
function del_break_group($data){
	if(!(getSessionRole()=="teacher"||
			getSessionRole()=="student")){
		error("权限不足");
	}
}
function del_group_dissolve($data){
	if(!(getSessionRole()=="teacher"||
			getSessionRole()=="student")){
		error("权限不足");
	}
}
function del_group($data){
	if(!(getSessionRole()=="teacher"||
			getSessionRole()=="student"||
			getSessionRole()=="admin")){
		error("权限不足");
	}
}
function del_member($data){
	if(!(getSessionRole()=="teacher"||
			getSessionRole()=="student"||
			getSessionRole()=="admin")){
		error("权限不足");
	}
}
function del_student($data){
	if(!(getSessionRole()=="admin")){
		error("权限不足");
	}
}
function del_task($data){
	if(!(getSessionRole()=="teacher"||
			getSessionRole()=="admin")){
		error("权限不足");
	}
}
function del_teachers($data){
	if(!(getSessionRole()=="admin")){
		error("权限不足");
	}
}
function get_user_info($data){
}
function is_login($data){
}
function login_student($data){
}
function login_teacher($data){
}
function login($data){
}
function mod_group_score($data){
	if(!(getSessionRole()=="teacher"||
			getSessionRole()=="student"||
			getSessionRole()=="admin")){
		error("权限不足");
	}
}
function mod_student_info($data){
	if(!(getSessionRole()=="teacher"||
			getSessionRole()=="student"||
			getSessionRole()=="admin")){
		error("权限不足");
	}
}
function mod_task_info($data){
	if(!(getSessionRole()=="teacher"||
			getSessionRole()=="admin")){
		error("权限不足");
	}
}
function mod_teacher_info($data){
	if(!(getSessionRole()=="teacher"||
			getSessionRole()=="admin")){
		error("权限不足");
	}
}
function out_login($data){
	if(!(getSessionRole()=="teacher"||
			getSessionRole()=="student"||
			getSessionRole()=="admin")){
		error("权限不足");
	}
}
function sel_group_score($data){
	if(!(getSessionRole()=="teacher"||
			getSessionRole()=="student"||
			getSessionRole()=="admin")){
		error("权限不足");
	}
}
function sel_groups($data){
	if(!(getSessionRole()=="teacher"||
			getSessionRole()=="student"||
			getSessionRole()=="admin")){
		error("权限不足");
	}
}
function sel_member($data){
	if(!(getSessionRole()=="teacher"||
			getSessionRole()=="student"||
			getSessionRole()=="admin")){
		error("权限不足");
	}
}
function sel_stu_score($data){
	if(!(getSessionRole()=="teacher"||
			getSessionRole()=="student"||
			getSessionRole()=="admin")){
		error("权限不足");
	}
}
function sel_students($data){
	if(!(getSessionRole()=="teacher"||
			getSessionRole()=="student"||
			getSessionRole()=="admin")){
		error("权限不足");
	}
}
function sel_task_score_sylloge($data){
	if(!(getSessionRole()=="teacher"||
			getSessionRole()=="admin")){
		error("权限不足");
	}
}
function sel_task($data){
	if(!(getSessionRole()=="teacher"||
			getSessionRole()=="student"||
			getSessionRole()=="admin")){
		error("权限不足");
	}
}
function sel_teachers($data){
	if(!(getSessionRole()=="admin")){
		error("权限不足");
	}
}
function sel_user_info($data){
	if(!(getSessionRole()=="teacher"||
			getSessionRole()=="student"||
			getSessionRole()=="admin")){
		error("权限不足");
	}
}
function student_location($data){
	if(!(getSessionRole()=="teacher"||
			getSessionRole()=="student"||
			getSessionRole()=="admin")){
		error("权限不足");
	}
}
function user_type($data){
	if(!(getSessionRole()=="teacher"||
			getSessionRole()=="student"||
			getSessionRole()=="admin")){
		error("权限不足");
	}
}
?>