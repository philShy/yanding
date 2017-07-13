<?php
require_once 'include.php';
if (isset($_REQUEST['act'])&&$_REQUEST['act']=='remail') {
	$reset['user_email'] = $_POST['user_email'];
	resetMail($reset);
}else {
	$user['user_email'] = $_POST['user_email'];
	$user['user_name'] = $_POST['user_name'];
	$user['nickname'] = $_POST['nickname'];
	$user['user_mobile'] = $_POST['user_mobile'];
	$user['user_telephone'] = $_POST['user_telephone'];
	$user['company'] = $_POST['company'];
	$user['dutyId'] = $_POST['dutyId'];
	$user['regtime'] = time();
	$user['token'] = md5($user['user_email'] .$user['regtime']); //创建用于激活识别码
	$user['token_exptime'] = time()+30*60;//过期时间为30分钟后
	addUser($user);
}

?>
<!doctype html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="utf-8">
<title>上海研鼎信息技术有限公司</title>
<link type="text/css" rel="stylesheet" href="styles/reset.css">
<link type="text/css" rel="stylesheet" href="styles/main.css">
<script type="text/javascript" src="scripts/search.js"></script>
</head>

<body>
	<?php include 'head.php';?>
	<div class="regSucess">
		<div class="regSucTop">
			<span class="userExt"><?php echo $_REQUEST['act']=='remail'?'重新发送邮件成功':'恭喜您已完成注册';?></span>
		</div>
		<div class="regSucCon">
			<img alt="" src="images/register/regSuc.png">
			<div>您将在5分钟内收到系统自动发送的电子邮件，请在30分钟以内查看邮箱邮件并设置密码，如果没有找到这封邮件，请查看垃圾邮件或者广告邮件，如果仍然没有，请点这里<a href="resetMail.php">重新发送</a>。</div>
			<div>一旦设定好您的密码，您即可使用此账号登录并获取所需要的资料，如仍有问题？请<a href="contactUs.php">联系我们</a>。</div>
		</div>
	</div>

	
	<?php include 'bottom.php';?>

</body>

</html>

