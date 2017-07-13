<?php 
require_once 'include.php';
checkBrowser();
if (isset($_SESSION['userId'])) {
	$userInfo = fetchOne("select * from user where id={$_SESSION['userId']}");
}
$dutyInfo = fetchAll("select * from user_duty");
?>
<!doctype html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="utf-8">
<title>上海研鼎信息技术有限公司-<?php echo $act=='log'?'登录':'注册';?></title>
<link type="text/css" rel="stylesheet" href="styles/reset.css">
<link type="text/css" rel="stylesheet" href="styles/main.css">
<script type="text/javascript" src="scripts/jquery-2.1.1.js"></script>
<script type="text/javascript" src="scripts/jquery.validate.min.js"></script>
<script type="text/javascript" src="scripts/messages_zh.js"></script>
<script type="text/javascript" src="scripts/search.js"></script>
</head>

<body>
	<?php include 'head.php';?>
	
	<div id="userRegis" class="userAccounts">
		<div class="regTop">
			<span class="userExt">编辑个人资料</span>
		</div>
		<form action="doEditUserInfo.php" method="post">
			<ul class="user_login">
				<li class="l_lab">电子邮箱：</li>
				<li class="r_inp"><input type="text"  name="user_email" disabled="true" value="<?php echo $userInfo['user_email'];?>"></li>
				<li class="l_lab">姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名：</li>
				<li class="r_inp"><input type="text"  name="user_name" value="<?php echo $userInfo['user_name'];?>"></li>
				<li class="l_lab">昵&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;称：</li>
				<li class="r_inp"><input type="text"  name="nickname" id="nickname" value="<?php echo $userInfo['nickname'];?>"></li>
				<li class="l_lab">手机号码：</li>
				<li class="r_inp"><input type="text"  name="user_mobile" id="user_mobile" value="<?php echo $userInfo['user_mobile'];?>"></li>
				<li class="l_lab">固定电话：</li>
				<li class="r_inp"><input type="text"  name="user_telephone" id="user_telephone" value="<?php echo $userInfo['user_telephone'];?>"></li>
				<li class="l_lab">公&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;司：</li>
				<li class="r_inp"><input type="text"  name="company" value="<?php echo $userInfo['company'];?>" required></li>
				<li class="l_lab">公司职位：</li>
				<li class="r_inp">
					<select name="dutyId">
						<option value="0">请选择</option>
						<?php foreach ($dutyInfo as $duty):?>
						<option value="<?php echo $duty['id']?>" <?php echo $duty['id']==$userInfo['dutyId']?"selected='selected'":null;?>><?php echo $duty['duty_name'];?></option>
						<?php endforeach;?>
					</select>
				</li>
				<li class="b_submit"><input type="submit" value="提&nbsp;&nbsp;&nbsp;&nbsp;交"></li>
			</ul>
		</form>
	</div>
	
	<?php include 'bottom.php';?>
	
	<script type="text/javascript">
	$(function() {
		//注册验证
	    $("#userRegis form").validate({
	        //出错时添加的标签
	        errorElement: "span",
	        rules: {
		        //验证邮箱
	        	user_email: {
	                required: true,
	            },
	          	//验证昵称
		    	nickname: {
		                required: true,
		                minlength: 3,
		                maxlength: 16,
	            },
	            //验证手机号码
	            user_mobile : {
	            	phone : true,//自定义验证规则（手机、座机必填一个）
	            	isMobile: true,//自定义验证规则（验证手机号）
	            	digits:true,//整数
	            },
	            //验证座机
	            user_telephone : {
	            	phone : true,//自定义验证规则（手机、座机必填一个）
	            	isTele: true,//自定义验证规则（验证座机）
		        },
	        },
	        success: function(label) {
	            //正确时的样式
	            label.text(" ").addClass("success");
	        },
	        messages: {
	        	user_email: {
	                required: "必填",
	            },
	            nickname: {
	                required: "必填",
	                minlength: "昵称长度不能小于3个字符",
	                maxlength: "昵称长度不能大于16个字符",
	            },
	            user_mobile : {
	            	digits:"请输入正确的手机号码",
	            },
	            user_telephone : {
	            	
		        },
	        },
	        errorPlacement: function(error, element) { //错误信息位置设置方法
	        	error.appendTo( element.parent() ); //这里的element是录入数据的对象
	        },
		});

	    $.validator.addMethod("phone", function(value, element) {
	        var mobile = $("#user_mobile").val();// 手机号码
	        var telephone = $("#user_telephone").val();// 固定电话
	        return !(isEmpty(mobile) && isEmpty(telephone));
	      }, "固定电话和手机号码至少填一个");

	 	// 手机号码验证
		$.validator.addMethod("isMobile", function(value, element) {
			var length = value.length;
			var mobile = /^(13[0-9]{9})|(18[0-9]{9})|(14[0-9]{9})|(17[0-9]{9})|(15[0-9]{9})$/;
			return this.optional(element) || (length == 11 && mobile.test(value));
		}, "请正确填写您的手机号码");
		// 固定电话验证
		$.validator.addMethod("isTele", function(value, element) {
			var tele = /^(\(\d{3,4}\)|\d{3,4}-|\s)?\d{7,14}$/;
			return this.optional(element) || tele.test(value);
		}, "请正确填写您的固定电话"); 
	});
	// 空字符串判断
	function isEmpty(v, allowBlank) {
	   return v === null || v === undefined || (!allowBlank ? v === "" : false);
	}
	</script>
</body>

</html>
