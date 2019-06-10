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
    <xblock>
        <button id="del" class="layui-btn" onclick="tableToExcel()">下载表格</button>
      </xblock>
      <table class="layui-table x-admin"  id="table">
        <thead id="title">
          <tr>
          	<th>学号</th>
            <th>姓名</th>
            <th>小组</th>
            <th>组员互评</th>
            <th>小组互评</th>
            <th>教师评分</th>
            <th>总成绩</th>
          </tr>
        </thead>
      </table>
    </div>
<script>
	init();
	var jsonData=null;
function init(){
	$.ajax({
	url:host+"sel_task_score_sylloge.php",
  	data:{
  		task_id:getQueryVariable("task_id")
  	},
  	success:function(res){
        	var data=JSON.parse(res);
        	jsonData=data.data;
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
			'<td>'+item.username+'</td>'+
    	'<td>'+item.name+'</td>'+
    	'<td>'+item.group_name+'</td>'+
    	'<td>'+item.student_score+'</td>'+
    	'<td>'+item.group_score+'</td>'+
    	'<td>'+item.teacher_score+'</td>'+
    	'<td>'+item.score+'</td>'+
	'</tr>'+
	'</tbody>';
	return list;
}
function tableToExcel(){
	if(jsonData==null){
		layer.msg("无数据下载", {icon: 2});
		return;
	}
      //列标题
      var str ='<tr> <td style="border: solid #010100 1px;">学号</td> <td style="border: solid #010100 1px;">姓名</td> <td style="border: solid #010100 1px;">小组评分</td> <td style="border: solid #010100 1px;">组员评分</td> <td style="border: solid #010100 1px;">教师评分</td> <td style="border: solid #010100 1px;">总成绩</td> </tr>';
      //循环遍历，每行加入tr标签，每个单元格加td标签
      for(var i = 0 ; i < jsonData.length ; i++ ){
        str+='<tr>';
        str+="<td style='border: solid #010100 1px;'> "+jsonData[i].username+"\t"+"</td>";
        str+="<td style='border: solid #010100 1px;'> "+jsonData[i].name+"\t"+"</td>";
        str+="<td style='border: solid #010100 1px;'> "+jsonData[i].student_score+"\t"+"</td>";
        str+="<td style='border: solid #010100 1px;'> "+jsonData[i].group_score+"\t"+"</td>";
        str+="<td style='border: solid #010100 1px;'> "+jsonData[i].teacher_score+"\t"+"</td>";
        str+="<td style='border: solid #010100 1px;'> "+jsonData[i].score+"\t"+"</td>";
        str+='</tr>';
      }
      //Worksheet名
      var worksheet = 'Sheet1';
      var uri = 'data:application/vnd.ms-excel;base64,';
 
      //下载的表格模板数据
      var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office"'+
      					'xmlns:x="urn:schemas-microsoft-com:office:excel"'+
      					'xmlns="http://www.w3.org/TR/REC-html40">'+
      					'<head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>'+
        				'<x:Name>'+getQueryVariable("task_name")+'</x:Name>'+
        				'<x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet>'+
        				'</x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]-->'+
        				'</head><body><table>'+str+'</table></body></html>';
      //下载模板
      window.location.href = uri + base64(template);
    }
    //输出base64编码
    function base64 (s) {
    	return window.btoa(unescape(encodeURIComponent(s)));
    }


</script>
  </body>

</html>
