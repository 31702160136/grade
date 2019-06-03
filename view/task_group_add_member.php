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
      <div class="layui-row">
        <div class="layui-form layui-col-md12 x-so">
          <div class="layui-input-inline">
              <select id="condition" name="area" lay-filter="area">
                <option value="username">学号</option>
                <option value="name">姓名</option>
              </select>
          </div>
          <input type="text" id="sreach"  placeholder="请输入查询信息" autocomplete="off" class="layui-input">
          <button class="layui-btn" onclick="sreach()"><i class="layui-icon">&#xe615;</i></button>
        </div>
      </div>
      <xblock>
        <button class="layui-btn" onclick="add()"><i class="layui-icon"></i>添加</button>
      </xblock>
      <table class="layui-table x-admin" >
        <thead id="title">
          <tr>
            <th>
              <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
            </th>
            <th>学号</th>
            <th>姓名</th>
            <th>系部</th>
            <th>班级</th></tr>
        </thead>
        <tbody id="table">
        	
        </tbody>
      </table>
    </div>
<script>
var pg_ini={
	page:1,
	size:999,
	task_id:getQueryVariable("task_id")
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
				            	'<td>'+item.department+'</td>'+
				            	'<td>'+item.class+'</td>'+
			          		'</tr>';
  	return list;
}

function sreach(){
	var data={
		page:1,
		size:pg_ini.size,
		task_id:getQueryVariable("task_id"),
	}
	queryTask(data);
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

function add(argument) {

	var data = tableCheck.getData();
	$.ajax({
		type:"post",
		url:host+"cre_member.php",
	  	data:{
	  		task_id:encodeURI(getQueryVariable("task_id")),
	  		group_id:encodeURI(getQueryVariable("group_id")),
	  		student_id:data
	  	},
	  	success:function(res){
	  				console.log(res);
	        	var data=JSON.parse(res);
	        	console.log(data);
	          if(data.status){
	          	// 可以对父窗口进行刷新 
	          	x_admin_father_reload();
	          }else{
		          	layer.msg(data.message, {
									icon: 5,
									time: 1000
								});
	          }
	   }
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
