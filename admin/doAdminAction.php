<?php 
require_once '../include.php';
$act = $_REQUEST['act'];
$id = $_REQUEST['id'];
if ($act!="addQues") {
	checkLogined();
}
if($act == "logout"){
	logout();
}elseif ($act == "addBigCate"){
	$mes = addBigCate();
}elseif ($act == "editBigCate") {
	$mes = editBigCate($id);
}elseif ($act == "delBigCate") {
	$mes = delBigCate($id);
}elseif ($act == "addSmallCate") {
	$mes = addSmallCate();
}elseif ($act == "editSmallCate") {
	$mes = editSmallCate($id);
}elseif ($act == "delSmallCate") {
	$mes = delSmallCate($id);
}elseif ($act == "addBraCate") {
	$mes = addBraCate();
}elseif ($act == "editBraCate") {
	$mes = editBraCate($id);
}elseif ($act == "delBraCate") {
	$mes = delBraCate($id);
}elseif ($act == "addPro") {
	$mes = addPro();
}elseif ($act == "editPro"){
	$mes = editPro($id);
}elseif ($act == "delPro"){
	$mes = delPro($id);
}elseif ($act == "addNews"){
	$mes = addNews();
}elseif ($act == "editNews") {
	$mes = editNews($id);
}elseif ($act == "delNews") {
	$mes = delNews($id);
}elseif ($act == "delUnableNewsImg") {
	$mes = delUnableNewsImg();
}elseif ($act == "addEmp") {
	$mes = addEmp();
}elseif ($act == "editEmp") {
	$mes = editEmp($id);
}elseif ($act == "delEmp") {
	$mes = delEmp($id);
}elseif ($act == "delProImg") {
	$imgId = $_REQUEST['imgId'];
	$proId = $_REQUEST['proId'];
	$mes = delImgById($imgId,$proId);
}elseif ($act == "editProImgs"){
	$mes = editProImgs($id);
}elseif ($act == "addQues") {
	$mes = addQues();
}elseif ($act == "delQues") {
	$mes = delQues($id);
}elseif ($act == "addTech") {
	$mes = addTech();
}elseif ($act == "editTech") {
	$mes = editTech($id);
}elseif ($act == "delTech") {
	$mes = delTech($id);
}elseif ($act == "addDown"){
	$mes = addDown();
}elseif ($act == "delDown") {
	$mes = delDown($id);
}elseif ($act == "delFile") {
	$fileId = $_REQUEST['fileId'];
	$did = $_REQUEST['did'];
	$mes = delFileById($fileId,$did);
}elseif ($act == "editDown"){
	$mes = editDown($id);
}elseif ($act == "addMarket"){
	$mes = addMarket();
}elseif ($act == "editMarket") {
	$mes = editMarket($id);
}elseif ($act == "delMarket") {
	$mes = delMarket($id);
}elseif ($act == "addAdmin"){
	$mes = addAdmin();
}elseif ($act == "editAdmin"){
	$mes = editAdmin($id);
}elseif ($act == "delAdmin") {
	$mes = delAdmin($id);;
}elseif ($act == "addClient"){
	$mes = addClient();
}elseif ($act == "editClient"){
	$mes = editClient($id);
}elseif ($act == "delClient") {
	$mes = delClient($id);
}elseif ($act=="addModels"){
	$proId = $_REQUEST['proId'];
	$mes = addModels($proId);
}elseif ($act=="editModel") {
	$proId = $_REQUEST['proId'];
	$mes = editModel($id,$proId);
}elseif ($act=="delModel"){
	$proId = $_REQUEST['proId'];
	$mes = delModelById($id,$proId);
}elseif ($act=="moveUp"){
	$proId = $_REQUEST['proId'];
	$mes = moveUp($id,$proId);
}elseif ($act=="moveUpImg"){
	$proId = $_REQUEST['proId'];
	$mes = moveUpImg($id,$proId);
}elseif ($act == "delOpera"){
	$mes = delOperate($id);
}elseif ($act == "exportUser"){
	$mes = exportUser();
}

?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
</head>
<body>
<?php 
	if($mes){
		echo $mes;
	}
?>
</body>
</html>