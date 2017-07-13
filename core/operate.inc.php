<?php
/**
 * 生成操作记录
 * @return string
 */
function addOperate($username,$tableName,$crudName,$rowId){
	$arr = array();
	if (!empty($username)) {
		$arr['username'] = $username;
	}
	if (!empty($tableName)) {
		$tableInfo = fetchOne("select id from tableInfo where tableName='{$tableName}'");
		$arr['tableId'] = $tableInfo['id'];
	}
	if (!empty($crudName)) {
		$crudInfo = fetchOne("select id from crudInfo where crudName='{$crudName}'");
		$arr['crudId'] = $crudInfo['id'];
	}
	$arr['time'] = time();
	$arr['ip'] = get_client_ip();
	$arr['infoId'] = $rowId;
	insert("operation_log",$arr);
}

/**
 *删除操作记录
 * @param string $where
 * @return string
 */
function delOperate($id){
	$where="id=".$id;
	if(delete("operation_log",$where)){
		$mes="删除成功!<br/><a href='listOperation.php'>查看操作记录</a>";
	}else{
		$mes="删除失败！<br/><a href='listOperation.php'>请重新操作</a>";
	}
	return $mes;

}