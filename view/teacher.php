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
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="">演示</a>
        <a>
          <cite>导航元素</cite></a>
      </span>
      <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
      <div class="layui-row">
        <div class="layui-form layui-col-md12 x-so">
          <div class="layui-input-inline">
              <select name="area" lay-filter="area" id="condition">
                <option value="name">教师</option>
                <option value="username">账号</option>
              </select>
          </div>
          <input type="text" id="sreach" placeholder="请输入查询信息" autocomplete="off" class="layui-input">
          <button class="layui-btn" onclick="sreach()"><i class="layui-icon">&#xe615;</i></button>
        </div>
      </div>
      <xblock>
        <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>删除</button>
        <button class="layui-btn" onclick="x_admin_show('添加教师','./teacher_add.php',600,450)"><i class="layui-icon"></i>添加</button>
        <span class="x-right" id="sumInfo" style="line-height:40px">共有数据：88 条</span>
      </xblock>
      <table class="layui-table x-admin">
        <thead id="title">
          <tr>
            <th>
              <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
            </th>
            <th>账号</th>
            <th>姓名</th>
            <th>密码</th>
            <th>操作</th></tr>
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
	size:10
}
//初始化数据
queryTask(pg_ini);
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
		url:host+"sel_teachers.php",
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
    	var list='<tr>'+
		        	'<td>'+
		          		'<div id="icheckbox" class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='+item.id+'><i class="layui-icon">&#xe605;</i></div>'+
		        	'</td>'+
		        	'<td>'+item.username+'</td>'+
            	'<td>'+item.name+'</td>'+
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
		if($("#condition").val()=="username"){
			data["username_s"]=$("#sreach").val();
		}else if($("#condition").val()=="name"){
			data["name"]=$("#sreach").val();
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
			queryTask(data);
    },false);
}
function sreach(){
	var data={
		page:1,
		size:pg_ini.size
	}
	queryTask(data);
}
//编辑窗口
function edit(item){
	var str="id="+encodeURI(item.id)+"&username="+encodeURI(item.username)+"&name="+encodeURI(item.name)+"&password="+encodeURI(item.password);
	x_admin_show("编辑","teacher_edit_info.php?"+str,600,400);
}

//	$(document).on('click','#a1',function(){
//             x_admin_show("编辑","member-edit.html",600,400);
//  })
/*用户-停用*/
function member_stop(obj, id) {
	layer.confirm('确认要停用吗？', function(index) {

		if($(obj).attr('title') == '启用') {
			//发异步把用户状态进行更改
			$(obj).attr('title', '停用')
			$(obj).find('i').html('&#xe62f;');
			$(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
			layer.msg('已停用!', {
				icon: 5,
				time: 1000
			});
		} else {
			$(obj).attr('title', '启用')
			$(obj).find('i').html('&#xe601;');

			$(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
			layer.msg('已启用!', {
				icon: 5,
				time: 1000
			});
		}

	});
}

/*用户-删除*/
function member_del(obj, id) {
	layer.confirm('确认要删除吗？', function(index) {
		//发异步删除数据
		$(obj).parents("tr").remove();
		layer.msg('已删除!', {
			icon: 1,
			time: 1000
		});
	});
}

function delAll(argument) {

	var data = tableCheck.getData();
	
	layer.confirm('确认要删除吗？' + data, function(index) {
		$.ajax({
		type:"post",
		url:host+"del_teachers.php",
  	data:{
  		ids:data
  	},
  	success:function(res){
        	var data=JSON.parse(res);
        	if(data.status){
        		layer.msg(data.message, {icon: 1});
	          // 可以对父窗口进行刷新 
	          x_admin_father_reload();
        	}else{
        		layer.msg(data.message, {icon: 1});
        	}
   }
  });
//		//捉到所有被选中的，发异步进行删除
//		layer.msg('删除成功', {
//			icon: 1
//		});
//		$(".layui-form-checked").not('.header').parents('tr').remove();
	});
}
</script>
		<script>var _hmt = _hmt || [];
(function() {
	var hm = document.createElement("script");
	hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
	var s = document.getElementsByTagName("script")[0];
	s.parentNode.insertBefore(hm, s);
})();</script>
  </body>

</html>
