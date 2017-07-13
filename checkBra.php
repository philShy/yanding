<?php
require_once 'include.php';
$search_bra = array();
if (!empty($_POST['bra'])) {
	$search_bra = fetchAll("select id,bra_cName from brand_cate where bra_cName like '%{$_REQUEST['bra']}%' order by bra_cName asc");
}
echo json_encode($search_bra);