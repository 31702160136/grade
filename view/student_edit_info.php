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
    <script type="text/javascript" src="./js/is_login.js"></script>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
      <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
      <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  
  <body>
    <div class="x-body">
        <form class="layui-form">
        	<input type="hidden" disabled id="id" name="id" required="" lay-verify="id"
                  autocomplete="off" class="layui-input">
          <div class="layui-form-item">
              <label for="username" class="layui-form-label">
                  <span class="x-red"></span>学号
              </label>
              <div class="layui-input-inline">
                  <input type="text" disabled id="username" name="username" required="" lay-verify="username"
                  autocomplete="off" class="layui-input">
              </div>
          </div>
          <div class="layui-form-item">
              <label for="name" class="layui-form-label">
                  <span class="x-red"></span>姓名
              </label>
              <div class="layui-input-inline">
                  <input type="text" id="name" name="name" required="" lay-verify="name"
                  autocomplete="off" class="layui-input">
              </div>
          </div>
          <div class="layui-form-item">
              <label for="department" class="layui-form-label">
                  <span class="x-red"></span>院系
              </label>
              <div class="layui-input-inline">
                  <input type="text" id="department" name="department" required="" lay-verify="department"
                  autocomplete="off" class="layui-input">
              </div>
          </div>
          <div class="layui-form-item">
              <label for="class" class="layui-form-label">
                  <span class="x-red"></span>班级
              </label>
              <div class="layui-input-inline">
                  <input type="text" id="class" name="class" required="" lay-verify="class"
                  autocomplete="off" class="layui-input">
              </div>
          </div>
          <div class="layui-form-item">
              <label for="password" class="layui-form-label">
                  <span class="x-red"></span>密码
              </label>
              <div class="layui-input-inline">
                  <input type="password" id="password" name="password" required="" lay-verify="password"
                  autocomplete="off" class="layui-input">
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">
              </label>
              <button  class="layui-btn" lay-filter="add" lay-submit="">
                  	修改
              </button>
          </div>
      </form>
    </div>
    <script>
      layui.use(['form','layer'], function(){
          $ = layui.jquery;
        var form = layui.form
        ,layer = layui.layer;
        //监听提交
        form.on('submit(add)', function(data){
          $.ajax({
          	type:"post",
          	url:host+"mod_student_info.php",
          	async:true,
          	data:data.field,
          	success:function(res){
          		var data=JSON.parse(res);
          		if(data.status){
          			if(decodeURI(getQueryVariable("ruter"))=="student_by"){
			      			$.ajax({
			          		type:"post",
					          	url:host+"out_login.php",
					          	async:true,
					          	success:function(res){
					      				layer.alert("修改成功，请重新登陆", {icon: 6},function () {
					              	x_admin_father_reload();//刷新父窗口
						          	});
						          }
			          	});
          			}else{
          				layer.alert("修改成功", {icon: 6},function () {
		              	// 获得frame索引
		              	var index = parent.layer.getFrameIndex(window.name);
		              	//关闭当前frame
		              	parent.layer.close(index);
		              	x_admin_father_reload();//刷新父窗口
		          		});
          			}
	          		
          		}
          	}
          });
          return false;
        });
      });
init();
function init(){
	var id=decodeURI(getQueryVariable("id"));
	var username=decodeURI(getQueryVariable("username"));
	var password_=decodeURI(getQueryVariable("password"));
	var department=decodeURI(getQueryVariable("department"));
	var name=decodeURI(getQueryVariable("name"));
	var class_=decodeURI(getQueryVariable("class"));
	$("#id").val(id);
	$("#username").val(username);
	$("#password").val(password_);
	$("#department").val(department);
	$("#name").val(name);
	$("#class").val(class_);
}
  </script>
    <script>var _hmt = _hmt || []; (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
      })();</script>
  </body>

</html>