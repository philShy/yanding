<?php
/**
 * 添加商品小类的操作
 * @return string
 */
function addSmallCate(){
	$arr=$_POST;
	if(insert("small_cate",$arr)){
		addOperate(getUserName(),'small_cate','add',getInsertId());
		$mes="小分类添加成功!<br/><a href='addSmallCate.php'>继续添加</a>|<a href='listSmallCate.php'>查看小分类</a>";
	}else{
		$mes="小分类添加失败！<br/><a href='addSmallCate.php'>重新添加</a>|<a href='listSmallCate.php'>查看小分类</a>";
	}
	return $mes;
}

/**
 * 根据ID得到指定商品小类信息
 * @param int $id
 * @return array
 */
function getSmallCateById($id){
	$sql="select id,small_cName,big_cId from small_cate where id={$id}";
	return fetchOne($sql);
}

/**
 * 修改商品小类的操作
 * @param string $where
 * @return string
 */
function editSmallCate($id){
	$arr=$_POST;
	if(update("small_cate", $arr,"id={$id}")){
		addOperate(getUserName(),'small_cate','edit',$id);
		$mes="小分类修改成功!<br/><a href='listSmallCate.php'>查看商品小类</a>";
	}else{
		$mes="小分类修改失败!<br/><a href='listSmallCate.php'>重新修改</a>";
	}
	return $mes;
}

/**
 *删除商品小类
 * @param string $where
 * @return string
 */
function delSmallCate($id){
	$res=checkProExist($id);
	if(!$res){
		$where="id=".$id;
		if(delete("small_cate",$where)){
			addOperate(getUserName(),'small_cate','del',$id);
			$mes="小分类删除成功!<br/><a href='listSmallCate.php'>查看小分类</a>|<a href='addSmallCate.php'>添加小分类</a>";
		}else{
			$mes="删除失败！<br/><a href='listSmallCate.php'>请重新操作</a>";
		}
		return $mes;
	}else{
		alertMes("不能删除小分类，请先删除该分类下的商品", "listPro.php");
	}
}

/**
 * 得到所有小分类
 * @return array
 */
function getAllSmallCate(){
	$sql="select id,small_cName from small_cate";
	$rows=fetchAll($sql);
	return $rows;
}

function getSmallCateByBigCId($big_cId){
	$sql = "select id,small_cName from small_cate where big_cId={$big_cId} order by id asc";
	$rows=fetchAll($sql);
	return $rows;
}