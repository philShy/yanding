<?php
require_once 'include.php';
$userInfo = fetchOne("select nickname,token from user where id={$_REQUEST['id']}");
$user['user_pwd'] = md5(json_encode($userInfo['nickname'] .$_POST['user_pwd']));
$user['active'] = 1;
$user['token_exptime'] = 0;
$user['token'] = 0;
$mes = update('user', $user,"id={$_REQUEST['id']}");
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
	<div class="setPwd">
	<?php if($mes):?>
		<div class="setPwdTop">
			<span class="userExt">设置密码成功</span>
		</div>
		<div class="setPwdTips" style="font-size: 18px;">您的密码已经成功设置！现在您可以<a href="userAccounts.php?act=log">登录</a>访问了。</div>
		<?php else :?>
		<div class="setPwdTop">
			<span class="userExt">设置密码失败</span>
		</div>
		<div class="setPwdTips" style="font-size: 18px;">您的密码设置失败！请<a href="active.php?verify=<?php echo $userInfo['token']?>">重新设置密码</a></div>
	<?php endif;?>
	</div>

	<?php include 'bottom.php';?>
</body>

</html>

