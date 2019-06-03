<?php
include_once "./../config/source.php";
//		$data=array("jj"=>"jj","j3j"=>"jj1");
class Sql{
	private $link=null;
	private $is_test=FALSE;
	function __construct(){
		$source=new Source();
		$this->link=$source->getSource();
	}
	/*
	 * 	sql语句
	 * 
	 * */
	function query($sql){
		if($this->is_test){
			echo $sql;
			exit(0);
		}
		$result = mysqli_query($this->link, $sql); //查询
		$array=array();
		if(mysqli_num_rows($result)>0){
			while($row = mysqli_fetch_assoc($result))
			{
				array_push($array,$row);
			}
		}
		return $array;
	}
	/*
	 * 	$array=array(
	 * 		"table"=表格,
	 * 		"data"=数据
	 * 	);
	 * 
	 * */
	function insert($array){
		$data=$array["data"];
		$str1=null;
		$str2=null;
		$count=count($data);
		foreach($data as $key=>$value){
			if($data[$key]==null){
				unset($data[$key]);
				$count--;
				continue;
			}
			if($count>1){
				$str1=$str1."`".$key."`, ";
				$str2=$str2."'".$value."', ";
			}else{
				$str1=$str1."`".$key."`";
				$str2=$str2."'".$value."'";
			}
			$count--;
		}
		$sql="insert into `".$array['table']."` (".$str1.") values (".$str2.")";
		if($this->is_test){
			echo $sql;
			exit(0);
		}
		$result = mysqli_query($this->link, $sql);
		mysqli_commit($this->link);
		return $result;
	}
	/*
	 * 	$array=array(
	 * 		"table"=表格,
	 * 		"id"=id
	 * 	);
	 * 
	 * */
	function modify($array){
		$data=$array["data"];
		$str=null;
		$count=count($data);
		foreach($data as $key=>$value){
			if(is_null($data[$key])){
				unset($data[$key]);
				$count--;
				continue;
			}
			if($count>1){
				$str=$str."`".$key."` = '".$value."', ";
			}else{
				$str=$str."`".$key."` = '".$value."' ";
			}
			$count--;
		}
		$sql="update `".$array['table']."` set ".$str." where id=".$array['id'];
		if($this->is_test){
			echo $sql;
			exit(0);
		}
		$result = mysqli_query($this->link, $sql);
		mysqli_commit($this->link);
		return $result;
	}
	/*
	 * 	$array=array(
	 * 		"table"=表格,
	 * 		"fields"=条件,
	 * 		"data"=数据
	 * 	);
	 * 
	 * */
	function delete($array){
		$str=null;
		for($i=0;$i<count($array['data']);$i++){
			if(($i+1)>=count($array['data'])){
				$str=$str."'".$array['data'][$i]."'";
			}else{
				$str=$str."'".$array['data'][$i]."',";
			}
		}
		$sql="delete from `".$array['table']."` where `".$array['fields']."` in (".$str.")";
		if($this->is_test){
			echo $sql;
			exit(0);
		}
		$result = mysqli_query($this->link, $sql);
		mysqli_commit($this->link);
		return $result;
	}
	
	function deleteOne($array){
		$str=null;
		$data=$array["data"];
		$count=count($data);
		foreach($data as $key=>$value){
			if(is_null($data[$key])){
				unset($data[$key]);
				$count--;
				continue;
			}
			if($count>1){
				$str=$str."`".$key."` = '".$value."' and ";
			}else{
				$str=$str."`".$key."` = '".$value."' ";
			}
			$count--;
		}
		$sql="delete from `".$array['table']."` where ".$str;
		if($this->is_test){
			echo $sql;
			exit(0);
		}
		$result = mysqli_query($this->link, $sql);
		mysqli_commit($this->link);
		return $result;
	}
}
?>