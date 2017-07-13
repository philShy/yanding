<?php
require_once 'include.php';
$verify = stripslashes(trim($_REQUEST['verify']));
$nowtime = time();
$row = fetchOne("select id,token_exptime from user where token='{$verify}'");

$status = 0;
if($row){
	if($nowtime>$row['token_exptime']){ //30min
		$status = 0;
		//$msg = '您的激活有效期已过，请登录您的帐号重新发送激活邮件.';
	}else {
		$status = 1;
	}
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
<script type="text/javascript" src="scripts/jquery-2.1.1.js"></script>
<script type="text/javascript" src="scripts/jquery.validate.min.js"></script>
<script type="text/javascript" src="scripts/messages_zh.js"></script>
<script type="text/javascript" src="scripts/search.js"></script>
</head>

<body>
	<?php include 'head.php';?>
	<div class="setPwd">
	<?php if($status>0):?>
		<div class="setPwdTop">
			<span class="userExt">请设置您的登录密码</span>
		</div>
		<div class="setPwdTips">为了确保账户安全，请输入至少6位密码（至少包含一个字母和一个数字）</div>
		<form action="doSetpwd.php?id=<?php echo $row['id'];?>" method="post">
			<ul class="user_setPwd">
				<li class="l_lab">新&nbsp;&nbsp;密&nbsp;&nbsp;码：</li>
				<li class="r_inp"><input type="password" style="display:none"><input type="password"  name="user_pwd" id="user_pwd" value="" autocomplete="off"></li>
				<li class="l_lab">确认密码：</li>
				<li class="r_inp"><input type="password"  name="confirm-password" id="confirm-password" autocomplete="off"></li>
				<li class="b_submit"><input type="submit" value="确&nbsp;&nbsp;&nbsp;&nbsp;认"></li>
			</ul>
		</form>
		<?php else :?>
		<div class="setPwdTop">
			<span class="userExt">设置密码链接无效</span>
		</div>
		<div class="setPwdTips" style="font-size: 18px;">该链接无效，可能是链接已经过期，<a href="resetMail.php?act=remail">点此链接重新发送邮件</a>。如果链接仍然无效，请<a href="contactUs.php">联系我们</a></div>
	<?php endif;?>
	</div>
	<?php include 'bottom.php';?>
	
		<script type="text/javascript">
		$(function() {
		    $(".setPwd form").validate({
		        rules: {
		        	user_pwd: {
	                    required: true,
	                    minlength: 6,
	                    maxlength: 12,
	                    pwdrule:true,//自定义验证规则（密码至少包含一个数字和一个字母）
	                    notblank:true,//校验密码是否含有空格
	                },
	                "confirm-password": {
	                    equalTo: "#user_pwd"
	                }
		        },
		        messages: {
		        	password: {
	                    required: "必须填写密码",
	                    minlength: "密码最小为6位",
	                    maxlength: "密码最大为12位",
	                },
	                "confirm-password": {
	                    equalTo: "两次输入的密码不一致"
	                }
		        },
			}); 

		    $.validator.addMethod("notblank", function(value, element) {
		    	 var pwdblank = /^\S*$/;
		         return this.optional(element) ||(pwdblank.test(value));
		     }, "密码不可包含空格");

		    //用户名必须需包含数字和大小写字母中至少两种
		    $.validator.addMethod("pwdrule", function(value, element) {
		        var userblank = /^(?![0-9]+$)(?![a-z]+$)(?![A-Z]+$)[0-9A-Za-z]{6,12}$/;
		        return this.optional(element) ||(userblank.test(value));
		    }, "至少包含一个字母和一个数字");
		    
		});
	</script>

</body>

</html>

