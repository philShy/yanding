<?php
//更新原始数据
require_once '../include.php';
$pro = fetchAll("select distinct(pid) from album order by pid");
foreach ($pro as $_pro){
	$models = fetchAll("select * from album where pid={$_pro['pid']} order by arrange asc");
	$key=1;
	foreach ($models as $model){
		update('album', array('arrange'=>$key),"id={$model['id']}");
		$key++;
	}
}
echo "操作完成";