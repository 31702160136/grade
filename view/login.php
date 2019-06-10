<!doctype html>
<html  class="x-admin-sm">
<head>
	<meta charset="UTF-8">
	<title>后台登录-X-admin2.1</title>
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="./css/font.css">
	<link rel="stylesheet" href="./css/xadmin.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="./lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="./js/xadmin.js"></script>
    <script type="text/javascript" src="./js/cookie.js"></script>
    <script type="text/javascript" src="./js/host.js"></script>

</head>
<body class="login-bg">
    
    <div class="login layui-anim layui-anim-up">
        <div class="message">学生登陆
        </div>
        <div id="darkbannerwrap"></div>
        
        <form method="post" class="layui-form" >
            <input name="username" placeholder="用户名"  type="text" lay-verify="required" class="layui-input" >
            <hr class="hr15">
            <input name="password" lay-verify="required" placeholder="密码"  type="password" class="layui-input">
            <hr class="hr15">
            <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
            <hr class="hr20" >
        </form>
        <div>
        	<a href="javascript:x_admin_show('注册账号','student_add.php',600,500);">注册账号</a>
        	<a href="login_teacher.php" class="x-right">教师登陆</a>
        </div>
    </div>

<script>
 $(function  () {
	layui.use('form', function(){
	  var form = layui.form;
	  // layer.msg('玩命卖萌中', function(){
	  //   //关闭后的操作
	  //   });
	  //监听提交
	  form.on('submit(login)', function(data){
	    // alert(888)
	    $.ajax({
	    	type: "post",
	    	url: host+"login_student.php",
	    	async: true,
	    	data: data.field,
	    	success: function(res) {
	    		var data=JSON.parse(res);
	    		if(data.status){
	    			location.href='task.php';
	    		}else{
	    			layer.msg(data.message, {icon: 5});
	    		}
	    	}
	    });
	    return false;
	    });
	    });
	    })
</script>

    
    <!-- 底部结束 -->
</body>
</html>