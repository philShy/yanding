<?php 
require_once 'include.php';
$user_email=$_POST['user_email'];
$user_pwd=md5(json_encode($_POST['user_email']));
$sql="select id,active,user_email,nickname,user_pwd from user where user_email='{$user_email}'";
$row=fetchOne($sql);
if(!empty($row)&&$row['active']>0&&(md5(json_encode($row['nickname'] .$user_pwd)==$row['user_pwd']))){
	$_SESSION['userId']=$row['id'];
	$_SESSION['nickname']=$row['nickname'];
	echo "<script>window.location='index.php';</script>";
}else{
	alertMes("登录失败","userAccounts.php?act=log");
}
?>
