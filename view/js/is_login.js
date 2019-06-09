function is_login(str){
	$.ajax({
		type:"post",
		url: host + "is_login.php",
		async:true,
		success: function(data){
			var res=JSON.parse(data);
			if (!res.status) {
//				alert(res.message);
				if(str=="student"){
					console.log(1);
					window.location.href = "login.php";
				}else if(str=="teacher"){
					window.location.href = "login_teacher.php";
				}else if(str=="admin"){
					window.location.href = "login_admin.php";
				}
				return;
			}
		},
	    error : function () {
	      	document.write("error");
	    }
	});
}
function out_login(){
		$.ajax({
			type:"get",
			url: host + "out_login.php",
			async:true,
			success: function(data){
				
			},
		    error : function () {
		      	document.write("error");
		    }
		});
	}