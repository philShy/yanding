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
		<div class="setPwdTop">
			<span class="userExt">重新发送邮件</span>
		</div>
		<form action="doRegister.php?act=remail" method="post">
			<ul class="user_setPwd">
				<li class="l_lab">电子邮箱：</li>
				<li class="r_inp"><input type="email"  name="user_email" id="user_email" placeholder="请输入公司/学校邮箱"></li>
				<li class="l_lab" style="width: 470px;height:40px;">请输入您注册的邮箱，重新发送邮件，通过邮件设置密码。</li>
				<li class="b_submit" style="margin-top: 0;"><input type="submit" value="发送邮件"></li>
			</ul>
		</form>
		
	</div>
	<?php include 'bottom.php';?>
	
	<script type="text/javascript">
		$(function() {
		    $(".setPwd form").validate({
		        rules: {
			        //验证邮箱
		        	user_email: {
		                required: true,
		                remote: {
		                    type: "post",
		                    url: "checkUserEmail.php",
		                    data: {
		                    	user_email: function() {
		                            return $("#user_email").val();
		                        }
		                    },
		                    dataType: "html",
		                    dataFilter: function(data, type) {
		                        if (data == "true")
		                            return false;
		                        else
		                            return true;
		                    }
		                }
		            },
		        },
		        messages: {
		        	user_email: {
		                required: "必填",
		                remote: "此邮箱还未注册"
		            },
		        },
			});
		    
		    
		});
	</script>

</body>

</html>