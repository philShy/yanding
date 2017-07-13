<?php
require_once 'include.php';
$verify = $_SESSION['verify'];
$userVerify = $_POST['userVerify'];
if (!empty($userVerify)&&(strtolower($verify) == strtolower($userVerify))) {
	echo "true";
}else {
	echo "false";
}