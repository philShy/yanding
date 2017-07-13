<?php 
require_once 'include.php';
checkBrowser();
$user = $_POST;
if (isset($_SESSION['userId'])) {
	$mes = update('user', $user,"id={$_SESSION['userId']}");
	if ($mes) {
		$_SESSION['nickname']=$user['nickname'];
		alertMes("修改成功","index.php");
	}else {
		alertMes("修改失败","editUserInfo.php");
	}
}
?>