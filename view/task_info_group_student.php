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
    <script type="text/javascript" src="./js/myBase64.js"></script>
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
        <a href="javascript:history.go(-2)">任务列表</a>
        <a href="javascript:history.go(-1)">小组列表</a>
        <a>
          <cite id="g_title">成员列表</cite></a>
				<span class="x-right" style="line-height:40px;margin-top: 5px;"><button class="layui-btn" onclick="outLogin()">退出登陆</button></span>
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
          <input type="text" id="sreach"  placeholder="请输入查询信息" autocomplete="off" class="layui-input">
          <button class="layui-btn" onclick="sreach()"><i class="layui-icon">&#xe615;</i></button>
        </div>
      </div>
      <xblock>
      	<button id="breakGroup" class="layui-btn" onclick="break_group()"><i class="layui-icon"></i>退出小组</button>
        <button id="del" class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>删除</button>
        <button id="dissolveGroup" class="layui-btn" onclick="dissolve_group()"><i class="layui-icon"></i>解散小组</button>
        <button id="add" class="layui-btn" onclick="add()"><i class="layui-icon"></i>添加成员</button>
          <span class="x-right" id="captain" style="line-height:40px;margin-top: -5px;margin-right: 20px;"><a>队长：xxx</a></span>
      </xblock>
      <table class="layui-table x-admin" >
        <thead id="title">
          <tr>
            <th>
              <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
            </th>
            <th>序号</th>
            <th>学号</th>
            <th>姓名</th>
            <th>分数</th>
            <th>组员互评</th>
          </tr>
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
var b=new Base64();
console.log();
var decoData=b.decode(getQueryVariable("data"));
var task_id=getQueryVariableInData(decoData,"task_id");
var group_id=getQueryVariableInData(decoData,"group_id");
var name=getQueryVariableInData(decoData,"name");
var pg_ini={
	page:1,
	size:10,
	task_id:task_id,
	group_id:group_id
}
//用户类型初始化
init();
var status="学生";
//初始化数据
queryTask(pg_ini);
//绑定多选框事件
reCheckbox();
$("#dissolveGroup").hide();
$("#del").hide();
$("#add").hide();
$("#breakGroup").hide();
function init(){
	is_login("student");
	$.ajax({
		type:"get",
		url:host+"user_type.php",
		async:true,
		success:function(res){
			var data=JSON.parse(res);
			is_login(data.data.role);
			if(data.status){
				switch(data.data.role){
					case "admin":
						
						break;
					case "teacher":
						student();
						status="教师";
						break;
					case "student":
						student();
						status="学生";
						break;
				}
			}
		}
	});
}
function student(){
	//学生定位
	$.ajax({
		type:"get",
		url:host+"student_location.php",
		async:true,
		data:{
			group_id:group_id
		},
		success:function(res){
			var data=JSON.parse(res);
			//判断是否为组成员
			if(data.data.is_menber){
				$("#breakGroup").show();
			}
			//判断是否为组队长
			if(data.data.captain){
				$("#breakGroup").hide();
				$("#dissolveGroup").show();
				$("#del").show();
				$("#add").show();
			}else{
				
			}
		}
	});
}
function queryTask(data){
	if($("#condition").val()=="username"){
		data["username_s"]=$("#sreach").val();
	}else if($("#condition").val()=="name"){
		data["name_s"]=$("#sreach").val();
	}
	$.ajax({
		type:"get",
		url:host+"sel_member.php",
		async:true,
		data:data,
		success:function(res){
			var data=JSON.parse(res);
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
				$("#captain").text("队长："+data.data.data.captain);
				numberArr=[1];
				for(var i=0;i<parseInt(data.data.pages);i++){
					numberArr.push(i*pg_ini.size+1);
				}
				numbers=numberArr[at];
				//信息列表
				$.each(data.data.data.data, function(index,item) {
					var list=getList(item,numbers++);
					$("#table").append(list);
				});
			}
		}
	});
}
function getList(item,index){
	var doEditItem=JSON.stringify(item);
	var score="";
	if(item.score!="自己"){
		score='<a title="评分" onclick="editScore('+doEditItem.replace(/\"/g,"'")+')" href="javascript:;">'+
                	'<i class="layui-icon">&#xe642;</i>'+
              	'</a>';
	}
    	var list='<tr>'+
            	'<td>'+
              		'<div id="icheckbox" class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='+item.id+'><i class="layui-icon">&#xe605;</i></div>'+
            	'</td>'+
            	'<td>'+index+'</td>'+
            	'<td>'+item.username+'</td>'+
            	'<td>'+item.name+'</td>'+
            	'<td>'+item.score+
            		score+
            	'</td>'+
            	'<td class="td-manage">'+
              	'<button class="layui-btn" onclick="select('+doEditItem.replace(/\"/g,"'")+')"><i class="layui-icon"></i>查看互评</button>'+
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
			task_id:task_id,
			group_id:group_id
		}
		if($("#condition").val()=="username"){
			data["username_s"]=$("#sreach").val();
		}else if($("#condition").val()=="name"){
			data["name"]=$("#sreach").val();
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
			task_id:task_id,
			group_id:group_id
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
				task_id:task_id,
				group_id:group_id
			}
			queryTask(data);
    },false);
}
function outLogin(){
	out_login();
	if(status=="学生"){
		window.location.href="login.php";
	}else if(status=="教师"){
		window.location.href="login_teacher.php";
	}
}
function sreach(){
	numbers=1;
	var data={
		page:1,
		size:pg_ini.size,
		task_id:task_id,
		group_id:group_id
	}
	queryTask(data);
	$("#at").text(1);
}

function add(){
	var str="group_id="+encodeURI(group_id)+"&task_id="+encodeURI(task_id);
	x_admin_show("编辑","task_group_add_member.php?"+str,600,500);
}
function member_sort(){
	numbers=1;
	numberArr=[1];
	pg_ini.size=parseInt($("#edit_page").val());
	//初始化数据
	queryTask(pg_ini);
}
function dissolve_group(){
	layer.alert("确定解散队伍？",function () {
		$.ajax({
			type:"post",
			url:host+"del_group_dissolve.php",
			data:{
				group_id:group_id,
				task_id:task_id
			},
			success:function(res){
				var data=JSON.parse(res);
				if (data.status) {
					layer.alert("解散队伍成功", {icon: 6},function () {
						history.back(-1);
					});
				}else{
					layer.msg(data.message, {icon: 2});
				}
			}
		});
	});
}
function break_group(){
	$.ajax({
		type:"post",
		url:host+"del_break_group.php",
		data:{
			group_id:group_id
		},
		success:function(res){
			var data=JSON.parse(res);
			if (data.status) {
				layer.alert(data.message, {icon: 6},function () {
					history.back(-1);
				});
			}else{
				layer.msg('退出失败', {icon: 2});
			}
		}
	});
}
function editScore(item){
	var str="student_group_id="+item.id+"&index=student";
	x_admin_show("评分","edit_score.php?"+str,600,200);
}
function select(item){
	var str="student_group_id="+item.id;
	x_admin_show("互评","student_score.php?"+str,600,500);
}

//	$(document).on('click','#a1',function(){
//             x_admin_show("编辑","member-edit.html",600,400);
//  })


function delAll(argument) {

	var data = tableCheck.getData();
	if(!(data.length>0)){
		layer.msg("请勾选成员", {icon: 2});
	}else{
		layer.confirm('确认要删除吗？' + data, function(index) {
			$.ajax({
				type:"post",
				url:host+"del_member.php",
		  	data:{
		  		group_id:group_id,
		  		ids:data
		  	},
		  	success:function(res){
		        	var data=JSON.parse(res);
		        	if(data.status){
		        		layer.msg(data.message, {icon: 1});
			          // 可以对父窗口进行刷新 
			          location.replace(location.href);
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
