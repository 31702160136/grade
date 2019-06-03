function is_login(str){
	$.ajax({
		type:"post",
		url: host + "is_login.php",
		async:true,
		success: function(data){
			var res=JSON.parse(data);
			if (!res.status) {
				alert(res.message);
				if(str=="student"){
					window.location.href = "login_student.php";
				}else if(str=="teacher"){
					window.location.href = "login_teacher.php";
				}else if(str=="admin"){
					window.location.href = "login.php";
				}
				return;
			}
		},
	    error : function () {
	      	document.write("error");
	    }
	});
}
