<!DOCTYPE html>
<html class="x-admin-sm">
  
  <head>
    <meta charset="UTF-8">
    <title>欢迎页面-X-admin2.1</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <link rel="stylesheet" href="./css/font.css">
    <link rel="stylesheet" href="./css/xadmin.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="./lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="./js/xadmin.js"></script>
    <script type="text/javascript" src="./js/cookie.js"></script>
    <script type="text/javascript" src="./js/host.js"></script>
    <script type="text/javascript" src="./js/tools.js"></script>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
      <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
      <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  
  <body>
    <div class="x-body">
        <div class="layui-form">
          <div class="layui-form-item">
              <label for="score" class="layui-form-label">
                  <span class="x-red">*</span>分数
              </label>
              <div class="layui-input-inline">
                  <input type="number" id="score" id="score"
                  autocomplete="off" class="layui-input">
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">
              </label>
              <button class="layui-btn" onclick="sendScore()">
                  	评分
              </button>
          </div>
      </div>
    </div>
    <script>
function sendScore(){
	var data=null;
	var urls="";
	switch(getQueryVariable("index")){
		case "student":
			data={
				score:$("#score").val(),
				student_group_id:getQueryVariable("student_group_id"),
			}
			urls="cre_member_score.php";
			break;
		case "teacher":
			data={
				"id":getQueryVariable("group_id"),
        "teacher_by_score":$("#score").val()
			}
			urls="mod_group_score.php";
			break;
		case "group":
			data={
				score:$("#score").val(),
				group_id:getQueryVariable("group_id"),
				task_id:getQueryVariable("task_id"),
			}
			console.log(data);
			urls="cre_group_score.php";
			break;
	}
	$.ajax({
		type:"post",
		url:host+urls,
		async:true,
		data:data,
		success:function(res){
			console.log(res);
			var data=JSON.parse(res);
			console.log(data);
			if(data.status){
				layer.alert(data.message, {icon: 6},function () {
	    		//关闭当前frame
	    		x_admin_close();
	    		// 可以对父窗口进行刷新 
	    		x_admin_father_reload();
				});
			}else{
				layer.msg(data.message, {icon: 5},function () {
	    		
				});
			}
		}
	});
}
    </script>
  </body>

</html>