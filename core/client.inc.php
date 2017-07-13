<?php
/**
 * 添加客户的操作
 * @return string
 */
function addClient(){
	$arr=$_POST;
	$path="./client";
	$uploadFiles=uploadFile($path);
	$arr['client_img'] = $uploadFiles[0]['name'];
	if(insert("client",$arr)){
		addOperate(getUserName(),'client','add',getInsertId());
		$mes="客户添加成功!<br/><a href='addClient.php'>继续添加</a>|<a href='listClient.php'>查看客户</a>";
	}else{
		$mes="客户添加失败！<br/><a href='addClient.php'>重新添加</a>|<a href='listClient.php'>查看客户</a>";
	}
	return $mes;
}

/**
 * 根据ID得到指定客户信息
 * @param int $id
 * @return array
 */
function getClientById($id){
	$sql="select id,client_name,client_img from client where id={$id}";
	return fetchOne($sql);
}

/**
 * 修改客户的操作
 * @param string $where
 * @return string
 */
function editClient($id){
	$arr=$_POST;
	$path="./client";
	$uploadFiles=uploadFile($path);
	if (!empty($uploadFiles)) {
		$arr['client_img'] = $uploadFiles[0]['name'];
	}
	$img = fetchOne("select client_img from client where id={$id}");
	if (!empty($img)&&!empty($uploadFiles)) {
		if (file_exists("client/" .$img['client_img'])) {
			unlink("client/" .$img['client_img']);
		}
	}
	if(update("client", $arr,"id={$id}")){
		addOperate(getUserName(),'client','edit',$id);
		$mes="客户修改成功!<br/><a href='listClient.php'>查看客户列表</a>";
	}else{
		$mes="客户修改失败!<br/><a href='listClient.php'>重新修改</a>";
	}
	return $mes;
}

/**
 *删除客户
 * @param string $where
 * @return string
 */
function delClient($id){
	$bra = getClientById($id);
	if (!empty($bra['client_img'])) {
		if (file_exists("client/" .$bra['client_img'])) {
			unlink("client/" .$bra['client_img']);
		}
	}
	$where="id=".$id;
	if(delete("client",$where)){
		addOperate(getUserName(),'client','del',$id);
		$mes="客户删除成功!<br/><a href='listClient.php'>查看客户</a>|<a href='addClient.php'>添加客户</a>";
	}else{
		$mes="删除失败！<br/><a href='listClient.php'>请重新操作</a>";
	}
	return $mes;
	
	

}

/**
 * 得到所有客户
 * @return array
 */
function getAllClient(){
	$sql="select id,client_name,client_img from client order by client_name asc";
	$rows=fetchAll($sql);
	return $rows;
}
