<?php
/**
 * 添加招聘信息的操作
 * @return string
 */
function addEmp(){
	$arr=$_POST;
	$arr['startDate'] = strtotime($arr['startDate']);
	$arr['endDate'] = strtotime($arr['endDate']);
	if(insert("employee",$arr)){
		addOperate(getUserName(),'employee','add',getInsertId());
		$mes="招聘信息添加成功!<br/><a href='addEmp.php'>继续添加</a>|<a href='listEmp.php'>查看招聘信息</a>";
	}else{
		$mes="招聘信息添加失败！<br/><a href='addEmp.php'>重新添加</a>|<a href='listEmp.php'>查看招聘信息</a>";
	}
	return $mes;
}

/**
 * 根据ID得到指定招聘信息
 * @param int $id
 * @return array
 */
function getEmpById($id){
	$sql="select id,position,location,num,duty,requirement,startDate,endDate from employee where id={$id}";
	return fetchOne($sql);
}

/**
 * 修改招聘信息的操作
 * @param string $where
 * @return string
 */
function editEmp($id){
	$arr=$_POST;
	$arr['startDate'] = strtotime($arr['startDate']);
	$arr['endDate'] = strtotime($arr['endDate']);
	if(update("employee", $arr,"id={$id}")){
		addOperate(getUserName(),'employee','edit',$id);
		$mes="招聘信息修改成功!<br/><a href='listEmp.php'>查看招聘信息</a>";
	}else{
		$mes="招聘信息修改失败!<br/><a href='listEmp.php'>重新修改</a>";
	}
	return $mes;
}

/**
 *删除招聘信息
 * @param string $where
 * @return string
 */
function delEmp($id){
	$where="id=".$id;
	if(delete("employee",$where)){
		addOperate(getUserName(),'employee','del',$id);
		$mes="招聘信息删除成功!<br/><a href='listEmp.php'>查看分类</a>|<a href='addEmp.php'>添加招聘信息</a>";
	}else{
		$mes="删除失败！<br/><a href='listEmp.php'>请重新操作</a>";
	}
	return $mes;

}

// /**
//  * 得到所有分类
//  * @return array
//  */
// function getAllBraCate(){
// 	$sql="select id,bra_cName from brand_cate";
// 	$rows=fetchAll($sql);
// 	return $rows;
// }
