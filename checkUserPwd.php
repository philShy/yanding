<?php
require_once 'include.php';
$user = array();
if (!empty($_POST['user_email'])) {
	$user = fetchOne("select id,active,user_email,nickname,user_pwd from user where user_email='{$_POST['user_email']}'");
}
if (!empty($user)&&$user['active']>0&&(md5(json_encode($user['nickname'] .$_POST['user_pwd']))==$user['user_pwd'])) {
	echo "true";
}else {
	echo "false";
}