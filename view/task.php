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
    <script type="text/javascript" src="js/tools.js"></script>
    <script type="text/javascript" src="./js/is_login.js"></script>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
      <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
      <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  
  <body>
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a>
          <cite>任务列表</cite></a>
      </span>
    </div>
    <div class="x-body">
      <div class="layui-row">
        <div class="layui-form layui-col-md12 x-so">
        	<input type="text" id="sreach" placeholder="请输入查询信息" autocomplete="off" class="layui-input">
          	<button class="layui-btn" onclick="sreach()"><i class="layui-icon">&#xe615;</i></button>
        <span class="x-right" id="userInfo" style="line-height:40px"><button class="layui-btn" onclick="edit()">修改信息</button></span>
        </div>
      </div>
      <xblock>
        <button id="del" class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>删除</button>
        <button id="cre" class="layui-btn" onclick="x_admin_show('创建任务','./task_add.php',600,550)"><i class="layui-icon"></i>创建</button>
        <button id="archive" class="layui-btn" onclick="x_admin_show('存档','./archive_task.php',800,700)">存档</button>
      </xblock>
      <table class="layui-table x-admin" >
        <thead id="title">
          <tr>
            <th>
              <div id="allICheckbox" class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
            </th>
            <th>课程</th>
            <th>班级</th>
            <th>学期</th>
            <th>任务发布日期</th>
            <th>任课老师</th>
            <th>查看任务</th>
            <th id="sylloge">汇总</th>
             <th id="operate">操作</th>
            </tr>
        </thead>
        <tbody id="table">
        	
        </tbody>
      </table>
      <div class="page">
        <div>
        	<a style="border: none;">共有<span id="pages" style="border: none;">1</span>页</a>
        	<a style="border: none;">当前<span id="at" style="border: none;">1</span>页</a>
          	<a class="prev"  onclick="back()" style="cursor:pointer">上一页</a>
          	<a class="next"  onclick="next()" style="cursor:pointer">下一页</a>
	      	<a style="border: none;">
	      		<select id="go" style="height: 30px;">
	      		</select>
	      	</a>
        </div>
      </div>
    </div>
<script>
var pg_ini={
	page:1,
	size:10,
	is_archive:0
}
var infos=null;
var status="学生";
$("#del").hide();
$("#cre").hide();operate
$("#operate").hide();
$("#sylloge").hide();
$("#archive").hide();
$("#userInfo").hide();
init();
function init(){
	$.ajax({
		type:"get",
		url:host+"user_type.php",
		async:true,
		success:function(res){
			var data=JSON.parse(res);
			is_login(data.data.role);
			console.log(data);
			if(data.status){
				switch(data.data.role){
					case "admin":
						break;
					case "teacher":
						status="教师";
						infos=data.data.info;
						$("#del").show();
						$("#cre").show();
						$("#operate").show();
						$("#sylloge").show();
						$("#archive").show();
						break;
					case "student":
						status="学生";
						$("#userInfo").show();
						infos=data.data.info;
						break;
				}
				//初始化数据
				queryTask(pg_ini);
				//绑定多选框事件
				reCheckbox();
			}
		}
	});
}

function queryTask(data){
	$.ajax({
		type:"get",
		url:host+"sel_task.php",
		async:true,
		data:data,
		success:function(res){
			console.log(res);
			var data=JSON.parse(res);
			console.log(data);
			if(data.status){
				$("#pages").text(data.data.pages);
				$("#go").html("");
				$("#table").html("");
				var at=parseInt($("#at").prop("innerText"));
				//处理跳页
				for(var i=0;i<data.data.pages;i++){
					if(i+1==at){
						$("#go").append('<option value="'+(i+1)+'" selected>'+(i+1)+'</option>');
					}else{
						$("#go").append('<option value="'+(i+1)+'">'+(i+1)+'</option>');
					}
				}
				//信息列表
				$.each(data.data.data, function(index,item) {
					var list=getList(item);
					$("#table").append(list);
				});
			}
		}
	});
}
function getList(item){
	var doEditItem=JSON.stringify(item);
	var operate="";
	var sylloge="";
	if(status=="教师"){
		operate='<td>'+
		        		'<button class="layui-btn"  onclick="archive('+doEditItem.replace(/\"/g,"'")+')"><i class="layui-icon"></i>存档</button>'+
		        		'<button class="layui-btn"  onclick="editTask('+doEditItem.replace(/\"/g,"'")+')"><i class="layui-icon"></i>设置任务</button>'+
		        	'</td>';
		sylloge='<td>'+
		        		'<button class="layui-btn"  onclick="sylloge('+doEditItem.replace(/\"/g,"'")+')"><i class="layui-icon"></i>任务汇总</button>'+
		        	'</td>';
	}
    	var list='<tr>'+
		        	'<td>'+
		          		'<div id="icheckbox" class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='+item.id+'><i class="layui-icon">&#xe605;</i></div>'+
		        	'</td>'+
		        	'<td>'+item.curriculum+'</td>'+
		        	'<td>'+item.class+'</td>'+
		        	'<td>'+item.semester+'</td>'+
		        	'<td>'+getMyDate(item.creation_time)+'</td>'+
		        	'<td>'+item.name+'</td>'+
		        	'<td class="td-manage">'+
		          '<a href="task_info_group.php?task_id='+item.id+'">'+
		          		'<button class="layui-btn"><i class="layui-icon"></i>查看任务</button>'+
		        	'</a>'+
		        	'</td>'+
		        	sylloge+
		        		operate+
		  		'</tr>';
  	return list;
}
//编辑窗口
function back(){
	var page=parseInt($("#at").prop("innerText"));
	var pages=parseInt($("#pages").prop("innerText"));
	if(page>=pages&&page!=1){
		page--;
		var data={
			page:page,
			size:pg_ini.size,
			is_archive:pg_ini.is_archive,
			curriculum:$("#sreach").val()
		}
		queryTask(data);
		$("#at").text(page);
	}
}
//编辑窗口
function next(item){
	var page=parseInt($("#at").prop("innerText"));
	var pages=parseInt($("#pages").prop("innerText"));
	if(page<pages){
		page++;
		var data={
			page:page,
			size:pg_ini.size,
			is_archive:pg_ini.is_archive,
			curriculum:$("#sreach").val()
		}
		queryTask(data);
		$("#at").text(page);
	}
}
//监听下拉框点击事件
window.onload = function () {
    document.getElementById('go').addEventListener('change',function(){
    	var page=parseInt($("#go").val());
    	$("#at").text(page);
    	var data={
				page:page,
				size:pg_ini.size,
				is_archive:pg_ini.is_archive,
				curriculum:$("#sreach").val()
			}
		queryTask(data);
    },false);
}
function sreach(){
	var data={
		page:1,
		size:pg_ini.size,
		is_archive:pg_ini.is_archive,
		curriculum:$("#sreach").val()
	}
	queryTask(data);
}
//编辑窗口
function edit(){
	if(status=="学生"){
		var str="id="+encodeURI(infos.id)+"&username="+encodeURI(infos.username)+"&name="+encodeURI(infos.name)+"&department="+encodeURI(infos.department)+"&class="+encodeURI(infos.class)+"&password="+encodeURI(infos.password);
		x_admin_show("修改学生信息","student_edit_info.php?"+str,600,400);
	}
}
//编辑窗口
function editTask(item){
	if(status=="教师"){
		var str="id="+encodeURI(item.id)+
						"&curriculum="+encodeURI(item.curriculum)+
						"&semester="+encodeURI(item.semester)+
						"&class="+encodeURI(item.class)+
						"&weight_teacher="+encodeURI(item.weight_teacher)+
						"&weight_group="+encodeURI(item.weight_group)+
						"&weight_group_in="+encodeURI(item.weight_group_in);
		x_admin_show("修改任务信息","task_edit.php?"+str,600,480);
	}
	
}
function sylloge(item){
	var str="task_id="+item.id;
	x_admin_show("编辑","sylloge.php?"+str,600,800);
}
function archive(item){
	layer.confirm('确定要存档吗？', function(index) {
		$.ajax({
			type:"post",
			url:host+"mod_task_info.php",
			async:true,
			data:{
				id:item.id,
				is_archive:1
			},
			success:function(res){
				console.log(res);
				var data=JSON.parse(res);
				if(data.status){
					layer.msg("存档成功", {icon: 1});
					location.replace(location.href);
				}
			}
		});
	});
	
}
function reList(){
	layui.use(['form'], function(){
		var form = layui.form;
		form.render();
	});
}
function del(item) {
	var ids=[item.id];
	layer.confirm('确认要删除吗？', function(index) {
		$.ajax({
			type:"post",
			url:host+"del_task.php",
			async:true,
			data:{
				ids:ids
			},
			success:function(res){
				console.log(res);
				var data=JSON.parse(res);
				if(data.status){
					layer.msg(data.message, {icon: 1});
					x_admin_father_reload();
				}else{
					layer.msg(data.message, {icon: 2});
				}
			}
		});
  });
}
function delAll(argument) {
	var ids = tableCheck.getData();
	if(!(ids.length>0)){
		layer.msg("请勾选任务", {icon: 2});
	}else{
		layer.confirm('确认要删除吗？', function(index) {
			$.ajax({
				type:"post",
				url:host+"del_task.php",
				async:true,
				data:{
					ids:ids
				},
				success:function(res){
					console.log(res);
					var data=JSON.parse(res);
					if(data.status){
						layer.msg(data.message, {icon: 1});
						x_admin_father_reload();
					}else{
						layer.msg(data.message, {icon: 2});
					}
				}
			});
	  });
	}
	
}

</script>
</body>

</html>
