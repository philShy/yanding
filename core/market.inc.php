<?php
/**
 * 添加市场活动
 * @return string
 */
function addMarket(){
	$arr=$_POST;
	$path="./market";
	$uploadFiles=uploadFile($path);
	$arr['image'] = $uploadFiles[0]['name'];
	$arr['startDate'] = strtotime($arr['startDate']);
	$arr['endDate'] = strtotime($arr['endDate']);
	$res=insert("conference",$arr);
	if($res){
		addOperate(getUserName(),'conference','add',getInsertId());
		$mes="<p>添加成功!</p><a href='addMarket.php' target='mainFrame'>继续添加</a>|<a href='listMarket.php' target='mainFrame'>查看市场活动列表</a>";
	}else{
		$mes="<p>添加失败!</p><a href='addMarket.php' target='mainFrame'>重新添加</a>";

	}
	return $mes;
}
function editMarket($id){
	$arr=$_POST;
	$path="./market";
	$uploadFiles=uploadFile($path);
	if (!empty($uploadFiles)) {
		$arr['image'] = $uploadFiles[0]['name'];
	}
	$tech = getOneTech($id);
	if (!empty($tech['image'])&&!empty($uploadFiles)) {
		if (file_exists("market/" .$img['image'])) {
			unlink("market/" .$img['image']);
		}
	}

	$arr['startDate'] = strtotime($arr['startDate']);
	$arr['endDate'] = strtotime($arr['endDate']);
	$res=update("conference",$arr,"id={$id}");

	if($res){
		addOperate(getUserName(),'conference','edit',$id);
		$mes="<p>编辑成功!</p><a href='listMarket.php' target='mainFrame'>查看市场活动列表</a>";
	}else{
		$mes="<p>编辑失败!</p><a href='listMarket.php' target='mainFrame'>重新编辑</a>";

	}
	return $mes;
}
function getMarketById($id){
	$row = fetchOne("select * from conference where id={$id}");
	return $row;
}
function delMarket($id){
	$res=getMarketById($id);
	if(!empty($res['image'])){
		if (file_exists("market/" .$res['image'])) {
			unlink("market/" .$res['image']);
		}
	}

	$where="id=".$id;
	if(delete("conference",$where)){
		addOperate(getUserName(),'conference','del',$id);
		$mes="删除成功!<br/><a href='listMarket.php'>查看列表</a>|<a href='addMarket.php'>添加活动</a>";
	}else{
		$mes="删除失败！<br/><a href='listMarket.php'>请重新操作</a>";
	}
	return $mes;
}