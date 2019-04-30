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
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
      <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
      <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  
  <body>
    <div class="x-body">
        <form class="layui-form">
          <div class="layui-form-item">
              <label for="curriculum" class="layui-form-label">
                  <span class="x-red">*</span>任务名称
              </label>
              <div class="layui-input-inline">
                  <input type="text" id="curriculum" name="curriculum" required="" lay-verify="curriculum"
                  autocomplete="off" class="layui-input">
              </div>
          </div>
          <div class="layui-form-item">
              <label for="semester" class="layui-form-label">
                  <span class="x-red">*</span>学期
              </label>
              <div class="layui-input-inline">
                  <input type="text" id="semester" name="semester" required="" lay-verify="semester"
                  autocomplete="off" class="layui-input">
              </div>
          </div>
          <div class="layui-form-item">
              <label for="class" class="layui-form-label">
                  <span class="x-red">*</span>班级
              </label>
              <div class="layui-input-inline">
                  <input type="text" id="class" name="class" required="" lay-verify="class"
                  autocomplete="off" class="layui-input">
              </div>
          </div>
          <div class="layui-form-item">
              <label for="teacher" class="layui-form-label">
                  <span class="x-red">*</span>老师
              </label>
              <div class="layui-input-inline">
                  <input type="text" id="teacher" name="teacher_id" required="" lay-verify="teacher"
                  autocomplete="off" class="layui-input">
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">
              </label>
              <button  class="layui-btn" lay-filter="add" lay-submit="">
                  增加
              </button>
          </div>
      </form>
    </div>
    <script>
        layui.use(['form','layer'], function(){
          $ = layui.jquery;
          var form = layui.form
          ,layer = layui.layer;
        
          //自定义验证规则
          form.verify({
            nikename: function(value){
              if(value.length < 1){
                return '昵称至少得1个字符啊';
              }
            }
            ,password: [/(.+){3,20}$/, '密码必须3到20位']
            ,repassword: function(value){
                if($('#L_pass').val()!=$('#L_repass').val()){
                    return '两次密码不一致';
                }
            }
          });
		//监听提交
          form.on('submit(add)', function(data){
            console.log(data);
           	$.ajax({
           		type:"post",
           		url:host+"create_task.php",
           		async:true,
           		data:data.field,
           		success:function(res){
           			var data=JSON.parse(res);
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
            return false;
          });
          
          
        });
init();
function init(){
	$.ajax({
	type:"post",
	url:host+"get_user_info.php",
   		async:true,
   		success:function(res){
   			var result=JSON.parse(res);
   			var data=result.data;
   			$("#teacher").val(data.name);
   		}
   });
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