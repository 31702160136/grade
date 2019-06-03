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
      <table class="layui-table x-admin">
        <thead id="title">
          <tr>
            <th>分数</th>
            <th>评分人</th>
        </thead>
        <tbody id="table">
        	
        </tbody>
      </table>
    </div>
<script>
init();
function init(){
	$.ajax({
		type:"get",
		url:host+"sel_stu_score.php",
		async:true,
		data:{
			student_group_id:getQueryVariable("student_group_id")
		},
		success:function(res){
			var data=JSON.parse(res);
			console.log(data);
			//信息列表
			$.each(data.data, function(index,item) {
				var list=getList(item);
				$("#table").append(list);
			});
		}
	});
}
function getList(item){
	var doEditItem=JSON.stringify(item);
	var list='<tr>'+
    	'<td>'+item.score+'</td>'+
    	'<td>'+item.from_student+'</td>'+
	'</tr>';
	return list;
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
