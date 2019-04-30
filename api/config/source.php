<?php

class Source{
	
	private $mysql_server_name='localhost'; //改成自己的mysql数据库服务器
 
	private $mysql_username='root'; //改成自己的mysql数据库用户名
 
	private $mysql_password=''; //改成自己的mysql数据库密码

	private $mysql_database='grade'; //改成自己的mysql数据库名
	
	var $link=null;
	public function getSource(){
		if(!isset($this->link)){
			$this->link=mysqli_connect($this->mysql_server_name,$this->mysql_username,$this->mysql_password,$this->mysql_database) or die("连接数据库失败") ; //连接数据库
			mysqli_query($this->link,'set names utf8');//兼容低版本字符输出编码
			mysqli_set_charset($this->link,"set names utf8"); //数据库输出编码
			return $this->link;
		}else{
			return $this->link;
		}
	}
	public function closeSource(){
		if(isset($this->link)){
			mysqli_close($this->link);
			$this->link=null;
		}
	}
}
?>