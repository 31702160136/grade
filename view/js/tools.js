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
function getQueryVariableInData(data,variable)
{
   var query = data;
   var vars = query.split("&");
   for (var i=0;i<vars.length;i++) {
           var pair = vars[i].split("=");
           if(pair[0] == variable){return pair[1];}
   }
   return(false);
}
//渲染多选框事件
function reCheckbox(){
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
}
/*	时间戳转日期
 * 
 **/
function getMyDate(str){
	//时间戳为十位数，*1000转换为13位
    var oDate = new Date(str*1000),  
    oYear = oDate.getFullYear(),  
    oMonth = oDate.getMonth()+1,  
    oDay = oDate.getDate(),  
    oTime = oYear +'-'+ getzf(oMonth) +'-'+ getzf(oDay);//最后拼接时间  
    return oTime;  
}; 
//补0操作
function getzf(num){  
    if(parseInt(num) < 10){
        num = '0'+num;  
    }  
	return num;  
}