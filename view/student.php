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
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a>
          <cite>学生管理</cite></a>
      </span>
    </div>
    <div class="x-body">
      <div class="layui-row">
        <div class="layui-form layui-col-md12 x-so">
          <div class="layui-input-inline">
              <select id="condition">
                <option value="username">学号</option>
                <option value="name">姓名</option>
              </select>
          </div>
          <input type="text" id="sreach" placeholder="请输入查询信息" autocomplete="off" class="layui-input">
          <button class="layui-btn" onclick="sreach()"><i class="layui-icon">&#xe615;</i></button>
        </div>
      </div>
      <xblock>
        <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>删除</button>
        <button class="layui-btn" onclick="x_admin_show('添加学生','./student_add.php',600,450)"><i class="layui-icon"></i>添加</button>
      </xblock>
      <table class="layui-table x-admin">
        <thead id="title">
          <tr>
            <th>
              <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
            </th>
            <th>序号</th>
            <th>学号</th>
            <th>姓名</th>
            <th>系部</th>
            <th>班级</th>
            <th>密码</th>
            <th>操作</th></tr>
        </thead>
        <tbody id="table">
        	
        </tbody>
      </table>
      <div class="page">
        <div>
        	<a style="border: none;">当前<span id="at" style="border: none;">1</span>页</a>
          	<a class="prev"  onclick="back()" style="cursor:pointer">上一页</a>
          	<a class="next"  onclick="next()" style="cursor:pointer">下一页</a>
        	<a style="border: none;">共有<span id="pages" style="border: none;">1</span>页</a>
	      	<a style="border: none;">
	      		<select id="go" style="height: 30px;">
	      		</select>
	      	</a>
	      	<a style="border: none;">
	      		<input id="edit_page" style="width: 50px;" type="number" maxlength="3" class="layui-input x-sort" onchange="member_sort()"  value='10'>
	      	</a>
        </div>
      </div>
    </div>
<script>
//序号
var numberArr=[1];
var numbers=1;
init();
function init(){
	is_login("admin");
	$.ajax({
		type:"get",
		url:host+"user_type.php",
		async:true,
		success:function(res){
			var data=JSON.parse(res);
			console.log(data);
			if(data.status&&data.data.role=="admin"){
				//初始化数据
				queryTask(pg_ini);
			}else{
				out_login();
				is_login("admin");
			}
		}
	});
}
var pg_ini={
	page:1,
	size:parseInt($("#edit_page").val())
}

//绑定多选框事件
reCheckbox();
function queryTask(data){
	if($("#condition").val()=="username"){
		data["username_s"]=$("#sreach").val();
	}else if($("#condition").val()=="name"){
		data["name"]=$("#sreach").val();
	}
	$.ajax({
		type:"get",
		url:host+"sel_students.php",
		async:true,
		data:data,
		success:function(res){
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
				numberArr=[1];
				for(var i=0;i<parseInt(data.data.pages);i++){
					numberArr.push(i*pg_ini.size+1);
					console.log(i*pg_ini.size);
				}
				numbers=numberArr[at];
				//信息列表
				$.each(data.data.data, function(index,item) {
					var list=getList(item,numbers++);
					$("#table").append(list);
				});
			}
		}
	});
}
function getList(item,index){
	var doEditItem=JSON.stringify(item);
    	var list='<tr>'+
		        	'<td>'+
		          		'<div id="icheckbox" class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='+item.id+'><i class="layui-icon">&#xe605;</i></div>'+
		        	'</td>'+
		        	'<td>'+index+'</td>'+
		        	'<td>'+item.username+'</td>'+
		        	'<td>'+item.name+'</td>'+
		        	'<td>'+item.department+'</td>'+
		        	'<td>'+item.class+'</td>'+
		        	'<td>'+item.password+'</td>'+
		        	'<td class="td-manage">'+
		          	'<button class="layui-btn" onclick="edit('+doEditItem.replace(/\"/g,"'")+')"><i class="layui-icon"></i>修改信息</button>'+
		        	'</td>'+
		  		'</tr>';
  	return list;
}
//编辑窗口
function back(){
	var page=parseInt($("#at").prop("innerText"));
	var pages=parseInt($("#pages").prop("innerText"));
	if(page>1){
		page--;
		var data={
			page:page,
			size:pg_ini.size,
			curriculum:$("#sreach").val()
		}
		queryTask(data);
		$("#at").text(page);
		var page=parseInt($("#at").prop("innerText"));
		numbers=numberArr[page-1];
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
				curriculum:$("#sreach").val()
			}
    	var pages=parseInt($("#pages").prop("innerText"));
			var page=parseInt($("#at").prop("innerText"));
//			numbers=pg_ini.size*(page-1)+1;
			queryTask(data);
			//numbers=numberArr[page-1];
    },false);
}
function sreach(){
	numbers=1;
	var data={
		page:1,
		size:pg_ini.size
	}
	queryTask(data);
}
//编辑窗口
function edit(item){
	var str="id="+encodeURI(item.id)+"&username="+encodeURI(item.username)+"&name="+encodeURI(item.name)+"&department="+encodeURI(item.department)+"&class="+encodeURI(item.class)+"&password="+encodeURI(item.password);
	x_admin_show("编辑","student_edit_info.php?"+str,600,400);
}
//修改密码窗口
function editPass(){
	x_admin_show("修改密码","member-edit.html",600,400);
}
function reList(){
	layui.use(['form'], function(){
		var form = layui.form;
		form.render();
	});
}
function member_sort(){
	numbers=1;
	numberArr=[1];
	pg_ini.size=parseInt($("#edit_page").val());
	//初始化数据
	queryTask(pg_ini);
}
function delAll(argument) {
	var ids = tableCheck.getData();
	if(!(ids.length>0)){
		layer.msg("请勾选学生", {icon: 2});
	}else{
		layer.confirm('确认要删除吗？', function(index) {
			$.ajax({
				type:"post",
				url:host+"del_student.php",
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
