<?php
require_once 'include.php';
$nickname = array();
if (!empty($_POST['nickname'])) {
	$nickname = fetchAll("select id,nickname from user where nickname='{$_POST['nickname']}'");
}

if (empty($nickname)) {
	echo "true";
}else {
	echo "false";
}