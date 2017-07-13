<?php
require_once 'include.php';
if (!empty($_SESSION['userId'])) {
	download($_REQUEST['filename']);
}else {
	alertMes("下载文件，请先登录", "userAccounts.php?act=log");
}