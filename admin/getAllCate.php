<?php
require_once '../include.php';
checkLogined();
$big_cates = getAllBigCate();
$_big_cates = array();
$_small_cates = array();
if (!empty($big_cates)) {
	foreach ($big_cates as $big_cate){
		$big_cate_id = "";
		if (strlen($big_cate['id'])==1) {
			$big_cate_id = "00" .$big_cate['id'];
		}elseif (strlen($big_cate['id'])==2) {
			$big_cate_id = "0" .$big_cate['id'];
		}elseif (strlen($big_cate['id'])==3) {
			$big_cate_id = $big_cate['id'];
		}
		$_big_cate['item_code'] = $big_cate_id ."000";
		$_big_cate['item_name'] = $big_cate['big_cName'];

		
		$_big_cates[] = $_big_cate;
// 		var_dump($_big_cates);
		$small_cates = getSmallCateByBigCId($big_cate['id']);
		if($small_cates){
			foreach ($small_cates as $small_cate){
				$small_cate_id = "";
				if (strlen($small_cate['id'])==1) {
					$small_cate_id = "00" .$small_cate['id'];
				}elseif (strlen($small_cate['id'])==2) {
					$small_cate_id = "0" .$small_cate['id'];
				}elseif (strlen($small_cate['id'])==3) {
					$small_cate_id = $small_cate['id'];
				}
				$_small_cate['item_code'] = $big_cate_id .$small_cate_id;
				$_small_cate['item_name'] = $small_cate['small_cName'];
				$_small_cates[] = $_small_cate;
// 				var_dump($_small_cates);
			}
		}
	}
	echo json_encode(array_merge($_big_cates,$_small_cates));
}