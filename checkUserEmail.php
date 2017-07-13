<?php
require_once 'include.php';
$user_email = array();
if (!empty($_POST['user_email'])) {
	$user_email = fetchAll("select id,user_email from user where user_email='{$_POST['user_email']}'");
}

if (empty($user_email)) {
	echo "true";
}else {
	echo "false";
}