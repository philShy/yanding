<?php
function addFile($arr){
	return insert("file", $arr);
}
//通过download表的id获取对应的文件
function getFileByDid($did){
	$file = fetchAll("select * from file where did={$did}");
	return $file;
}

/**
 * 根据文件id删除对应文件
 * @param unknown $imgId
 */
function delFileById($fileId,$did){
	$filePath = fetchOne("select filePath from file where id={$fileId}");
	$mes = delete("file","id='{$fileId}'");
	if (file_exists("../file/" .$filePath['filePath'])) {
		unlink("../file/" .$filePath['filePath']);
	}
	if ($mes) {
		alertMes("删除成功", "editDown.php?id={$did}");
	}
}