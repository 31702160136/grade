<?php
function getPage($data,$size_){
	if(is_array($data)){
		$sum=count($data);
		//每页的信息数量
		$size=$size_;
		//用新闻数量转换页数
		if(is_float($sum/$size)){
			$page=intval(($sum/$size))+1;
		}else{
			$page=intval(($sum/$size));
		}
		return $page;
	}else{
		return 1;
	}
}
?>