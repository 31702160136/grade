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
      <span class="x-right" id="sumInfo" style="line-height:40px">共有数据：88 条</span>
      <table class="layui-table x-admin"  id="table">
        <thead id="title">
          <tr>
            <th>分数</th>
            <th>评分人</th>
        </thead>
      </table>
    </div>
<script>
			//初始化
      init();
    	layui.use(['form','laydate'], function(){
        var laydate = layui.laydate;
        var form = layui.form;
        //执行一个laydate实例
         
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
   			window.location.href=window.location.origin+window.location.pathname+"?page="+page;
   		}
   	}
   	//页数减
   	function jian(){
   		if(parseInt($("#page2").prop("innerHTML"))>1){
   			var page=parseInt($("#page2").prop("innerHTML"))-1;
   			window.location.href=window.location.origin+window.location.pathname+"?page="+page;
   		}
   	}
   	//跳页
   	function pageOn(id){
   		var page=parseInt($("#"+id).prop("innerHTML"));
   		window.location.href=window.location.origin+window.location.pathname+"?page="+page;
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
 			url:host+"select_student_sum.php",
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
 	//查询成绩列表
	$.ajax({
		url:host+"select_student_score.php",
  	data:{
  		student_group_id:getQueryVariable("student_group_id"),
  		page:$("#page2").prop("innerHTML"),
  		size:10
  	},
  	success:function(res){
        	var data=JSON.parse(res);
        	var dataSum=0;
        	$(data.data).each(function(index,item){
        		dataSum++;
//      		$("#sumInfo").text(parseInt());
        		var list=getList(item);
	          	$("#table").append(list);
    		});
    		$("#sumInfo").text("共有数据："+dataSum+ "条");
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
function getList(item){
	var doEditItem=JSON.stringify(item);
	var list='<tbody>'+
	'<tr>'+
    	'<td>'+item.score+'</td>'+
    	'<td>'+item.name+'</td>'+
	'</tr>'+
	'</tbody>';
	return list;
}
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
