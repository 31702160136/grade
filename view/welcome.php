<!doctype html>
<html class="x-admin-sm">
    <head>
        <meta charset="UTF-8">
        <title>后台信息</title>
        <meta name="renderer" content="webkit|ie-comp|ie-stand">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
        <meta http-equiv="Cache-Control" content="no-siteapp" />
        <script type="text/javascript" src="js/jquery.min.js"></script>
		<script src="js/host.js"></script>
		<script src="js/is_login.js"></script>
        <link rel="stylesheet" href="./css/font.css">
        <link rel="stylesheet" href="./css/xadmin.css">
    </head>
    <body>
    	<br />
    	<fieldset class="layui-elem-field">
    		<legend>管理员信息</legend>
    		<div class="layui-field-box">
                <table class="layui-table" lay-skin="line">
                    <tbody>
                        <tr>
                            <td id="info_username">
                               	账号：admin
                            </td>
                        </tr>
                        <tr>
                            <td id="info_name">
                               	管理员：xxx
                            </td>
                        </tr>
                        <tr>
                            <td id="info_role">
                               	角色：普通管理员
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
    	</fieldset>
        
        <!--<div class="x-body">-->
            <!-- 为 ECharts 准备一个具备大小（宽高）的 DOM -->
            <!--<div id="main" style="width: 100%;height:400px;"></div>-->
        <!--</div>-->

        <script type="text/javascript">
        // 基于准备好的dom，初始化echarts实例
		init();
		function init(){
			$.ajax({
				type:"get",
				url:host+"sel_user_info.php",
				async:true,
				success:function(res){
					console.log(res);
					var data=JSON.parse(res);
					$("#info_username").text("账号："+data.data.username);
					$("#info_name").text("管理员："+data.data.name);
					$("#info_role").text("角色："+data.data.role);
				}
			});
		}
    </script>
    </body>
</html>