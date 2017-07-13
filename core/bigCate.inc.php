<?php
/**
 * 添加商品大类的操作
 * @return string
 */
function addBigCate(){
	$arr=$_POST;
	$path="./bigCate";
	$uploadFiles=uploadFile($path);
	$arr['albumPath'] = $uploadFiles[0]['name'];
	if(insert("big_cate",$arr)){
		addOperate(getUserName(),'big_cate','add',getInsertId());
		$mes="分类添加成功!<br/><a href='addBigCate.php'>继续添加</a>|<a href='listBigCate.php'>查看分类</a>";
	}else{
		$mes="分类添加失败！<br/><a href='addBigCate.php'>重新添加</a>|<a href='listBigCate.php'>查看分类</a>";
	}
	return $mes;
}

/**
 * 根据ID得到指定商品大类信息
 * @param int $id
 * @return array
 */
function getBigCateById($id){
	$sql="select id,big_cName,albumPath from big_cate where id={$id}";
	return fetchOne($sql);
}

/**
 * 修改商品大类的操作
 * @param string $where
 * @return string
 */
function editBigCate($id){
	$arr=$_POST;

	$path="./bigCate";
	$uploadFiles=uploadFile($path);
	if (!empty($uploadFiles)) {
		$arr['albumPath'] = $uploadFiles[0]['name'];
	}
	$img = fetchOne("select albumPath from big_cate where id={$id}");
	if (!empty($img)&&!empty($uploadFiles)) {
		if (file_exists("bigCate/" .$img['albumPath'])) {
			unlink("bigCate/" .$img['albumPath']);
		}
	}
	
	if(update("big_cate", $arr,"id={$id}")){
		addOperate(getUserName(),'big_cate','edit',$id);
		$mes="分类修改成功!<br/><a href='listBigCate.php'>查看商品大类</a>";
	}else{
		$mes="分类修改失败!<br/><a href='listBigCate.php'>重新修改</a>";
	}
	return $mes;
}

/**
 *删除商品大类
 * @param string $where
 * @return string
 */
function delBigCate($id){
	$res=getSmallCateByBigCId($id);
	if(!$res){
		$img = fetchOne("select albumPath from big_cate where id={$id}");
		if (!empty($img)) {
			if (file_exists("bigCate/" .$img['albumPath'])) {
				unlink("bigCate/" .$img['albumPath']);
			}
		}
		$where="id=".$id;
		if(delete("big_cate",$where)){
			addOperate(getUserName(),'big_cate','del',$id);
			$mes="分类删除成功!<br/><a href='listBigCate.php'>查看分类</a>|<a href='addBigCate.php'>添加分类</a>";
		}else{
			$mes="删除失败！<br/><a href='listBigCate.php'>请重新操作</a>";
		}
		return $mes;
	}else{
		alertMes("不能删除分类，请先删除该分类下的小分类", "listSmallCate.php");
	}
}

/**
 * 得到所有分类
 * @return array
 */
function getAllBigCate(){
	$sql="select id,big_cName,albumPath from big_cate order by id asc";
	$rows=fetchAll($sql);
	return $rows;
}
function getBigCateBySmallCid($small_cId){
	$sql = "select bc.big_cName,bc.id from big_cate bc join small_cate sc on bc.id=sc.big_cId where sc.id={$small_cId}";
	$rows = fetchOne($sql);
	return $rows;
}