<?php
/**
 * 添加品牌的操作
 * @return string
 */
function addBraCate(){
	$arr=$_POST;
	$path="./braCate";
	$uploadFiles=uploadFile($path);
	$arr['bra_img'] = $uploadFiles[0]['name'];
	if(insert("brand_cate",$arr)){
		addOperate(getUserName(),'brand_cate','add',getInsertId());
		$mes="分类添加成功!<br/><a href='addBraCate.php'>继续添加</a>|<a href='listBraCate.php'>查看分类</a>";
	}else{
		$mes="分类添加失败！<br/><a href='addBraCate.php'>重新添加</a>|<a href='listBraCate.php'>查看分类</a>";
	}
	return $mes;
}

/**
 * 根据ID得到指定品牌分类信息
 * @param int $id
 * @return array
 */
function getBraCateById($id){
	$sql="select id,bra_cName,bra_img,bra_desc from brand_cate where id={$id}";
	return fetchOne($sql);
}

/**
 * 修改品牌分类的操作
 * @param string $where
 * @return string
 */
function editBraCate($id){
	$arr=$_POST;
	$path="./braCate";
	$uploadFiles=uploadFile($path);
	if (!empty($uploadFiles)) {
		$arr['bra_img'] = $uploadFiles[0]['name'];
	}
	$img = fetchOne("select bra_img from bra_cate where id={$id}");
	if (!empty($img)&&!empty($uploadFiles)) {
		if (file_exists("braCate/" .$img['bra_img'])) {
			unlink("braCate/" .$img['bra_img']);
		}
	}
	if(update("brand_cate", $arr,"id={$id}")){
		addOperate(getUserName(),'brand_cate','edit',$id);
		$mes="分类修改成功!<br/><a href='listBraCate.php'>查看品牌列表</a>";
	}else{
		$mes="分类修改失败!<br/><a href='listBraCate.php'>重新修改</a>";
	}
	return $mes;
}

/**
 *删除品牌分类
 * @param string $where
 * @return string
 */
function delBraCate($id){
	$sql= "select * from product where bra_cId={$id}";
	$rows = fetchAll($sql);
	if (!empty($rows)) {
		alertMes("不能删除该品牌，请先删除该品牌下的商品", "listPro.php");
	}else {
		$bra = getBraCateById($id);
		if (!empty($bra['bra_img'])) {
			if (file_exists("braCate/" .$bra['bra_img'])) {
				unlink("braCate/" .$bra['bra_img']);
			}
		}
		$where="id=".$id;
		if(delete("brand_cate",$where)){
			addOperate(getUserName(),'brand_cate','del',$id);
			$mes="分类删除成功!<br/><a href='listBraCate.php'>查看分类</a>|<a href='addBraCate.php'>添加分类</a>";
		}else{
			$mes="删除失败！<br/><a href='listBraCate.php'>请重新操作</a>";
		}
		return $mes;
	}
	

}

/**
 * 得到所有分类
 * @return array
 */
function getAllBraCate(){
	$sql="select id,bra_cName from brand_cate order by bra_cName asc";
	$rows=fetchAll($sql);
	return $rows;
}
