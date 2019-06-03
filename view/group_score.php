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
      <table class="layui-table x-admin"  id="table">
        <thead id="title">
          <tr>
            <th>分数</th>
            <th>评分组</th>
          </tr>
        </thead>
      </table>
    </div>
<script>
	init();
function init(){
	$.ajax({
		url:host+"sel_group_score.php",
  	data:{
  		group_id:getQueryVariable("group_id")
  	},
  	success:function(res){
  			console.log(res);
        	var data=JSON.parse(res);
        	console.log(data);
        	if(data.status){
        		$(data.data).each(function(index,item){
	        		var list=getList(item);
		          	$("#table").append(list);
	    			});
        	}
    	}
 });
}
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


</script>
  </body>

</html>
