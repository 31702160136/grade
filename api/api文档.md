//登陆类---------------------------------------------------------
1.登陆接口:
	接口：login.php
	类型:post
	参数1：username  //账号
	参数2: password  //密码
	成功：
	{
    	"status": true,
    	"message": "登陆成功",
    	"code": 200,
    	"data":[
    		{
    			"name":"小1"
    		}
    	]
	}
2.退出登陆接口:
	接口：out_login.php
	类型post/get
	参数：无
	成功：
	{
    	"status": true,
    	"message": "注销成功",
    	"code": 200
	}
3.是否登陆接口
	接口: is_login.php
	类型post/get
	参数：无
	成功：
	{
    	"status": true,
    	"message": "用户已登录",
    	"code": 200
	}
//用户类---------------------------------------------------------
4.注册接口
	接口：create_admin.php
	类型:post
	参数1：name  //姓名
	参数2: username  //账号
	参数3: password      //密码
	参数4: phone      //手机(选填)
	参数5: email      //邮箱(选填)
	参数1：is_state  //是否激活(选填),默认激活
	参数1：role  //角色(选填)默认admin(普通管理员),可输入的参数admin(普通管理员),superAdmin(超级管理员)
	成功：
	{
    	"status": true,
    	"message": "注册成功",
    	"code": 200
	}
4.修改密码接口
	接口：modify_password.php
	类型:post
	参数1：oldPassword  //旧密码
	参数3: password      //新密码
	成功：
	{
    	"status": true,
    	"message": "密码修改成功",
    	"code": 200
	}
5.查询用户列表接口
	接口：select_users.php
	类型:get
	参数1：page  //页数
	参数2：size  //获取信息数量
	{
    	"status": true,
    	"message": "获取用户列表成功",
    	"code": 200,
    	"data": [
        	{
        	    "id": "1",
        	    "name": "超级管理员", 			//姓名
        	    "username": "admin", 			//账号
        	    "password": "admin", 			//密码
            	"role": "superAdmin",			//角色
            	"phone": null,					//手机
            	"email": null,					//邮箱
            	"creation_time": "1553779168",	//注册时间
            	"modify_time": "1553779168"		//更新时间
        	}
    	]
	}
5.批量删除用户列表接口
	接口：delete_users.php
	类型:post
	参数1：ids[]  //删除单个例子：ids[]:[1]，删除多个例子实例：ids[]:[1,2,3,4,5]
		发送ajax请求前把数据打包成数组，ids[]进行发送
	{
    "status": true,
    "message": "删除用户成功",
    "code": 200
	}
5.根据账号的方式查询用户接口
	接口：select_user_by_username.php
	类型:get
	参数：username  //账号
	{
    	"status": true,
    	"message": "获取用户列表成功",
    	"code": 200,
    	"data": [
        	{
        	    "id": "1",
        	    "name": "超级管理员", 			//姓名
        	    "username": "admin", 			//账号
        	    "password": "admin", 			//密码
            	"role": "superAdmin",			//角色
            	"phone": null,					//手机
            	"email": null,					//邮箱
            	"creation_time": "1553779168",	//注册时间
            	"modify_time": "1553779168"		//更新时间
        	}
    	]
	}
//栏目类---------------------------------------------------------
5.查询栏目接口
	接口：select_columns.php
	类型:get
	参数2：page  //页数（选题）
	参数3：size  //获取信息数量（选题）
	{
    	"status": true,
    	"message": "获取栏目列表成功",
    	"code": 200,
    	"data": [
        	{
            	"id": "3",
            	"title": "好栏目",				//栏目标题
            	"index": "0",					//排序权重值，越高越排前
            	"is_start": "1",				//状态0不启用，1启用
            	"creation_time": "1554366110",	//创建时间
            	"modify_time": "1554368747"		//更新时间
        	}
    	]
	}
5.创建栏目接口
	接口：create_column.php
	类型:post
	参数1：title  //栏目标题
	参数3: index      //栏目排序权重,默认0,范围0-无限,值越大排越高最高权限(选填)
	参数3: is_start      //是否启用(0不启用，1启用),默认不启用(选填)
	成功：
	{
    	"status": true,
    	"message": "创建栏目成功",
    	"code": 200
	}
6.修改栏目接口
	接口：modify_column.php
	类型:post
	参数1：title  //栏目标题(选填)
	参数3: index      //栏目排序权重,范围0-9,9最高权限(选填)
	成功：
	{
    	"status": true,
    	"message": "修改栏目成功",
    	"code": 200
	}
6.栏目启动状态接口
	接口：modify_column_start.php
	类型:post
	参数1：id  //栏目
	成功：
	{
    	"status": true,
    	"message": "设置栏目启动状态成功",
    	"code": 200
	}
5.批量删除栏目列表接口
	接口：delete_column.php
	类型:post
	参数1：ids[]  //删除单个例子：ids[]:[1]，删除多个例子实例：ids[]:[1,2,3,4,5]
		发送ajax请求前把数据打包成数组，ids[]进行发送
	{
    	"status": true,
    	"message": "删除栏目成功",
    	"code": 200
	}
//新闻类---------------------------------------------------------
7.查询新闻接口
	接口：select_news.php
	类型:get
	参数2：page  //页数（选题）
	参数3：size  //获取信息数量（选题）
	成功：
	{
    	"status": true,
    	"message": "获取新闻列表成功",
    	"code": 200,
    	"data": [
        	{
            	"id": "11",
            	"title": "我是新闻",				//新闻标题
            	"describe": "撒旦",				//新闻描述
            	"content": "阿斯蒂芬发",			//新闻内容，格式为HTML
            	"cover": "www.yulemofang.cn/computer/images/41eb7d00561daa28f0a0b603de18975c.jpg",//封面图片
            	"slideshow_cover": "/computer/images/微信截图_20180922011410.png",//轮播图片
            	"type": "阿斯蒂芬",				//新闻类型
            	"contributor": "案说法",			//投稿者
            	"is_hot": "0",					//是否热点新闻0为不热点，1为热点
            	"is_top": "0",					//是否定制0为不顶置，1为顶置
            	"is_start": "0",				//是否启用
            	"column_id": "3",				//新闻对应的栏目id
            	"user_id": "1",					//发布新闻的管理员id
            	"creation_time": "1554393636",	//创建时间
            	"modify_time": "1554393636"		//更新时间
        	}
    	]
	}
7.根据栏目id查询新闻接口
	接口：select_news_by_column_id.php
	类型:get
	参数1：column_id  //栏目id
	参数2：page  //页数（选题）
	参数3：size  //获取信息数量（选题）
	成功：
	{
    	"status": true,
    	"message": "获取新闻列表成功",
    	"code": 200,
    	"data": [
        	{
            	"id": "11",
            	"title": "我是新闻",				//新闻标题
            	"describe": "撒旦",				//新闻描述
            	"content": "阿斯蒂芬发",			//新闻内容，格式为HTML
            	"cover": "www.yulemofang.cn/computer/images/41eb7d00561daa28f0a0b603de18975c.jpg",//封面图片
            	"slideshow_cover": "/computer/images/微信截图_20180922011410.png",//轮播图片
            	"type": "阿斯蒂芬",				//新闻类型
            	"contributor": "案说法",			//投稿者
            	"is_hot": "0",					//是否热点新闻0为不热点，1为热点
            	"is_top": "0",					//是否定制0为不顶置，1为顶置
            	"is_start": "0",				//是否启用
            	"column_id": "3",				//新闻对应的栏目id
            	"user_id": "1",					//发布新闻的管理员id
            	"creation_time": "1554393636",	//创建时间
            	"modify_time": "1554393636"		//更新时间
        	}
    	]
	}
6.新闻启动状态设置接口
	接口：modify_news_start.php
	类型:post
	参数1：id  //新闻id
	成功：
	{
    	"status": true,
    	"message": "新闻启动状态设置成功",
    	"code": 200
	}
6.新闻火热状态设置接口
	接口：modify_news_hot.php
	类型:post
	参数1：id  //新闻id
	成功：
	{
    	"status": true,
    	"message": "新闻火热状态设置成功",
    	"code": 200
	}
6.新闻置顶状态设置接口
	接口：modify_news_top.php
	类型:post
	参数1：id  //新闻id
	成功：
	{
    	"status": true,
    	"message": "新闻置顶状态设置成功",
    	"code": 200
	}
5.批量删除新闻列表接口
	接口：delete_news.php
	类型:post
	参数1：ids[]  //删除单个例子：ids[]:[1]，删除多个例子实例：ids[]:[1,2,3,4,5]
		发送ajax请求前把数据打包成数组，ids[]进行发送
	{
    	"status": true,
    	"message": "删除文章成功",
    	"code": 200
	}