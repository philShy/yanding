<?php
require_once 'include.php';
$search_bra = array();
$search = $_POST['search'];
$bra = $_POST['bra'];
$where = "";
if ($search!="") {
	$where .= " and (p.pName like '%{$search}%' or p.pNum like '%{$search}%'
	or bi.big_cName like '%{$search}%' or s.small_cName like '%{$search}%' or br.bra_cName like '%{$search}%')";
}

if (!empty($bra)) {
	$search_bra = fetchAll("select distinct(p.bra_cId),br.bra_cName from product as p
		join big_cate bi on p.big_cId=bi.id
		join small_cate s on p.small_cId=s.id
		join brand_cate br on p.bra_cId=br.id
		where bra_cName like '%{$bra}%' {$where}");
}else {
	$search_bra = fetchAll("select distinct(p.bra_cId),br.bra_cName from product as p
		join big_cate bi on p.big_cId=bi.id
		join small_cate s on p.small_cId=s.id
		join brand_cate br on p.bra_cId=br.id
		{$where}");
}

echo json_encode($search_bra);