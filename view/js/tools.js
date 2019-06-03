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
	//渲染多选框事件
	$(document).on('click', '#allICheckbox',function() {
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
