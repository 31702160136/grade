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
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="javascript:history.go(-1)">任务列表</a>
        <a>
          <cite>小组列表</cite></a>
      </span>
      <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
      <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so" action="student.php" method="get">
          <div class="layui-input-inline">
              <select name="area" lay-filter="area">
                <option value="name">组名</option>
              </select>
          </div>
          <input type="text" name="value"  placeholder="请输入查询信息" autocomplete="off" class="layui-input">
          <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
        </form>
      </div>
      <xblock>
        <button class="layui-btn" onclick="openMyGroup()"><i class="layui-icon"></i>我的小组</button>
        <button class="layui-btn" onclick="add()"><i class="layui-icon"></i>创建小组</button>
        <span class="x-right" id="sumInfo" style="line-height:40px">共有数据：88 条</span>
      </xblock>
      <table class="layui-table x-admin"  id="table">
        <thead id="title">
          <tr>
            <th>组名</th>
            <th>队长</th>
            <th id="score">分数</th>
            <th>互评分值比例</th>
            <th>小组互评</th>
            <th>组成员</th>
          </tr>
        </thead>
      </table>
      <div class="page">
        <div>
          <a class="prev"  onclick="jian()" style="cursor:pointer">&lt;&lt;</a>
          <a id="page1" class="num" onclick="pageOn('page1')" style="cursor:pointer">0</a>
          <span id="page2" class="current" onclick="pageOn('page2')" style="cursor:pointer">1</span>
          <a id="page3" class="num" onclick="pageOn('page3')" style="cursor:pointer">2</a>
          <a id="page4" class="num" onclick="pageOn('page4')" style="cursor:pointer">3</a>
          <a id="sum" class="num" onclick="pageOn('sum')" style="cursor:pointer">489</a>
          <a class="next"  onclick="jia()" style="cursor:pointer">&gt;&gt;</a>
        </div>
      </div>
    </div>
<script>
			//初始化
      init();
    	layui.use(['form','laydate'], function(){
        var laydate = layui.laydate;
        var form = layui.form;
        //执行一个laydate实例
        form.on('submit(sreach)', function(data){
        	$.ajax({
        		type:"get",
        		url:host+"select_sreach_group.php",
        		async:true,
        		data:{
        			task_id:getQueryVariable("task_id"),
        			key:data.field.area,
        			value:data.field.value
        		},
        		success:function(res){
        			var data=JSON.parse(res);
        			var is_title=false;
        			var dataSum=0;
        			$(data.data).each(function(index,item){
        				dataSum++;
        				var title=$("#title").prop("outerHTML");
			        	var list=getList_member(item);
			          	if(!is_title){
			          		$("#table").html(title);
			          		is_title=true;
			          	}
			          	$("#table").append(list);
			          	$("#score").hide();
		    				});
		    				$("#sumInfo").text("共有数据："+dataSum+ "条");
        		}
        	});
            return false;
        });
         
        laydate.render({
          elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
          elem: '#end' //指定元素
        });
      });
//  页数变量
    var pageSum=0;
    //页数加
   	function jia(){
   		if(parseInt($("#page2").prop("innerHTML"))<pageSum){
   			var page=parseInt($("#page2").prop("innerHTML"))+1;
   			window.location.href=window.location.origin+window.location.pathname+"?page="+page+"&task_id="+getQueryVariable("task_id");
   		}
   	}
   	//页数减
   	function jian(){
   		if(parseInt($("#page2").prop("innerHTML"))>1){
   			var page=parseInt($("#page2").prop("innerHTML"))-1;
   			window.location.href=window.location.origin+window.location.pathname+"?page="+page+"&task_id="+getQueryVariable("task_id");
   		}
   	}
   	//跳页
   	function pageOn(id){
   		var page=parseInt($("#"+id).prop("innerHTML"));
   		window.location.href=window.location.origin+window.location.pathname+"?page="+page+"&task_id="+getQueryVariable("task_id");
   	}
//初始化
function init(){
	var page=getQueryVariable("page");
	//页数初始化
	if(page){
		$("#page1").text(parseInt(page)-1);
 		$("#page2").text(parseInt(page));
 		$("#page3").text(parseInt(page)+1);
 		$("#page4").text(parseInt(page)+2);
	}else{
		page=1;
	}
	//页数初始化
	$.ajax({
 			url:host+"select_group_sum.php",
 			success:function(res){
   				var data=JSON.parse(res);
   				pageSum=parseInt(data.data);
   				//页数范围控制
   				if(pageSum=>4){
   					$("#sum").text(data.data);
   				}else if(pageSum==2){
   					$("#page1").text(parseInt(page)-1);
   					$("#page2").text(parseInt(page));
   					$("#page3").text(parseInt(page)+1);
   					$("#page4").hide();
   					$("#sum").hide();
   				}else if(pageSum==1){
   					$("#page1").text(parseInt(page)-1);
   					$("#page2").text(parseInt(page));
   					$("#page3").hide();
   					$("#page4").hide();
   					$("#sum").hide();
   				}
   				var page2=parseInt($("#page2").prop("innerHTML"));
   			if((page2+2)===pageSum||(page2+1)===pageSum){
   				$("#page4").hide();
   				$("#sum").hide();
   			}
   			if(page2===pageSum){
   				$("#page3").hide();
   				$("#page4").hide();
   				$("#sum").hide();
   			}
   			if(page2===1){
   				$("#page1").hide();
   			}
   			//页数范围控制
 			}
 		});
 	getGroups();
}
var myGroupId=0;
function getGroups(){
	//查询小组列表
	$.ajax({
		url:host+"select_my_group.php",
  	data:{
  		"task_id":getQueryVariable("task_id")
  	},
  	success:function(res){
        	var data=JSON.parse(res);
        	if(data.status){
        		myGroupId=data.data.group_id;
        		getGroups_captain(data.data.group_id);
        	}else{
        		getGroups_member();
        	}
    	}
  });
}
function getGroups_captain(group_id){
	//查询小组列表
	$.ajax({
		url:host+"select_group_score_list.php",
  	data:{
  		"task_id":getQueryVariable("task_id"),
  		"group_id":group_id,
  		page:$("#page2").prop("innerHTML"),
  		size:10
  	},
  	success:function(res){
        	var data=JSON.parse(res);
    		if(data.status){
	        	var dataSum=0;
	        	$(data.data).each(function(index,item){
	        		dataSum++;
	//      		$("#sumInfo").text(parseInt());
		        	var list=getList(item);
		          	$("#table").append(list);
	    		});
	    		$("#sumInfo").text("共有数据："+dataSum+ "条");
    		}else{
	        window.location.href="login_student.php";
	    	}
    	}
  });
}
function getGroups_member(){
	//查询小组列表
	$.ajax({
		url:host+"select_groups.php",
  	data:{
  		"task_id":getQueryVariable("task_id"),
  		page:$("#page2").prop("innerHTML"),
  		size:10
  	},
  	success:function(res){
        	var data=JSON.parse(res);
    		if(data.status){
        	var dataSum=0;
        	$(data.data).each(function(index,item){
        		dataSum++;
//      		$("#sumInfo").text(parseInt());
	        	var list=getList_member(item);
	          	$("#table").append(list);
    		});
    		$("#sumInfo").text("共有数据："+dataSum+ "条");
    		}else{
	        window.location.href="login_student.php";
	    	}
    	}
  });
}
//渲染多选框事件
$(document).on('click', '#icheckbox',function() {
	if($(this).hasClass('layui-form-checked')) {
		$(this).removeClass('layui-form-checked');
		if($(this).hasClass('header')) {
			$(".x-admin .layui-form-checkbox").removeClass('layui-form-checked');
		}
	} else {
		$(this).addClass('layui-form-checked');
		if($(this).hasClass('header')) {
			$(".x-admin .layui-form-checkbox").addClass('layui-form-checked');
		}
	}
});
//获取链接get参数
function getQueryVariable(variable)
{
       var query = window.location.search.substring(1);
       var vars = query.split("&");
       for (var i=0;i<vars.length;i++) {
               var pair = vars[i].split("=");
               if(pair[0] == variable){return pair[1];}
       }
       return(false);
}
function getList(item){
	var doEditItem=JSON.stringify(item);
	var list='<tbody>'+
	    	'<tr>'+
            	'<td>'+item.name+'</td>'+
            	'<td>'+item.student+'</td>'+
            	'<td>'+item.score+
            	'<a title="编辑" onclick="editScore('+doEditItem.replace(/\"/g,"'")+')" href="javascript:;">'+
                	'<i class="layui-icon">&#xe642;</i>'+
              	'</a>'+
            	'</td>'+
            	'<td>'+item.score_percent+'</td>'+
            	'</td>'+
            	'<td class="td-manage">'+
              	'<button class="layui-btn" onclick="select('+doEditItem.replace(/\"/g,"'")+')"><i class="layui-icon"></i>查看互评</button>'+
            	'</td>'+
            	'<td class="td-manage">'+
              	'<a href="stu_task_info_group_student.php?group_id='+item.id+"&name="+item.name+"&task_id="+encodeURI(getQueryVariable("task_id"))+'">'+
              		'<button class="layui-btn"><i class="layui-icon"></i>查看成员</button>'+
            	'</a>'+
            	'</td>'+
      		'</tr>'+
  		'</tbody>';
  	return list;
}
function getList_member(item){
	var doEditItem=JSON.stringify(item);
	var list='<tbody>'+
	    	'<tr>'+
            	'<td>'+item.name+'</td>'+
            	'<td>'+item.student+'</td>'+
            	'<td>'+item.score_percent+'</td>'+
            	'</td>'+
            	'<td class="td-manage">'+
              	'<button class="layui-btn" onclick="select('+doEditItem.replace(/\"/g,"'")+')"><i class="layui-icon"></i>查看互评</button>'+
            	'</td>'+
            	'<td class="td-manage">'+
              	'<a href="stu_task_info_group_student.php?group_id='+item.id+"&name="+item.name+"&task_id="+encodeURI(getQueryVariable("task_id"))+'">'+
              		'<button class="layui-btn"><i class="layui-icon"></i>查看成员</button>'+
            	'</a>'+
            	'</td>'+
      		'</tr>'+
  		'</tbody>';
  $("#score").hide();
  	return list;
}
//编辑窗口
function add(){
	var str="task_id="+encodeURI(getQueryVariable("task_id"));
	x_admin_show("编辑","task_group_add.php?"+str,600,200);
}
function editScore(item){
	x_admin_show("设置成绩","stu_task_group_edit_score.php?group_id="+item.id+"&from_group_id="+myGroupId,600,200);
}
function editCaptain(item){
	x_admin_show("设置队长","task_group_edit_captain.php?group_id="+item.id,600,400);
}
function select(item){
	var str="group_id="+item.id;
	x_admin_show("编辑","group_score.php?"+str,600,500);
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

function openMyGroup() {

	var data = tableCheck.getData();
	$.ajax({
		type:"get",
		url:host+"select_my_group.php",
  	data:{
  		task_id:encodeURI(getQueryVariable("task_id"))
  	},
  	success:function(res){
        	var data=JSON.parse(res);
        	if(data.status){
        		var a=document.createElement("a");
	        	a.href="stu_task_info_group_student.php?group_id="+data.data.group_id+"&name="+data.data.name+"&task_id="+encodeURI(getQueryVariable("task_id"));
	   				a.click();
        	}else{
        		layer.msg("未加入小组", {
							icon: 5,
							time: 1000
						});
        	}
   }
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
