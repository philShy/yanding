<?php 
require_once 'include.php';
checkBrowser();
$act = $_REQUEST['act'];
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
	
	<div id="userRegis" class="userAccounts" style="display: <?php echo $act=='log'?none:block;?>">
		<div class="regTop">
			<span class="userExt">注册</span>
			<span class="userNor" onclick="showLogin()">登录</span>
		</div>
		<form action="doRegister.php?act=regis" method="post">
			<ul class="user_login">
				<li class="l_lab">电子邮箱：</li>
				<li class="r_inp"><input type="email"  name="user_email" id="user_email" placeholder="请输入公司/学校邮箱" class="must"></li>
				<li class="l_lab">姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名：</li>
				<li class="r_inp"><input type="text"  name="user_name"></li>
				<li class="l_lab">昵&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;称：</li>
				<li class="r_inp"><input type="text"  name="nickname" id="nickname" class="must"></li>
				<li class="l_lab">手机号码：</li>
				<li class="r_inp"><input type="text"  name="user_mobile" id="user_mobile"></li>
				<li class="l_lab">固定电话：</li>
				<li class="r_inp"><input type="text"  name="user_telephone" id="user_telephone"></li>
				<li class="l_lab">公&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;司：</li>
				<li class="r_inp"><input type="text"  name="company" class="must" required></li>
				<li class="l_lab">公司职位：</li>
				<li class="r_inp">
					<select name="dutyId">
						<option value="0">请选择</option>
						<?php foreach ($dutyInfo as $duty):?>
						<option value="<?php echo $duty['id']?>"><?php echo $duty['duty_name'];?></option>
						<?php endforeach;?>
					</select>
				</li>
				<li class="l_lab">验&nbsp;&nbsp;证&nbsp;&nbsp;码：</li>
				<li class="r_verify"><input type="text"  name="userVerify" class="regVerify"></li>
				<img id="userVerify" src="admin/getVerify.php" alt="" />
				<span class="userverify_change" onclick="change_verify()">换一张</span>
				<li class="b_submit"><input type="submit" value="注&nbsp;&nbsp;&nbsp;&nbsp;册"></li>
			</ul>
		</form>
	</div>
	
	<div id="userLogin" class="userAccounts" style="display: <?php echo $act=='log'?block:none;?>">
		<div class="regTop">
			<span class="userExt">登录</span>
			<span class="userNor" onclick="showRegis()">注册</span>
		</div>
		<form action="doLogin.php" method="post">
			<ul class="user_login" style="height: 300px;">
				<li class="l_lab">电子邮箱：</li>
				<li class="r_inp"><input type="email"  name="user_email" placeholder="请输入公司/学校邮箱" id="user_email1"></li>
				<li class="l_lab">密&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;码：</li>
				<li class="r_inp"><input type="password"  name="user_pwd" id="user_pwd"></li>
				<li class="r_inp" style="text-align:right;margin-bottom: 0;"><a href="userAccounts.php?act=reg">现在注册</a>&nbsp;|&nbsp;<a href="resetMail.php">忘记密码？</a></li>
				<li class="b_submit" style="margin-top: 10px;"><input type="submit" value="登&nbsp;&nbsp;&nbsp;&nbsp;录"></li>
			</ul>
		</form>
	</div>
	
	<?php include 'bottom.php';?>
	
	<script type="text/javascript">
	window.onload = function (){
	    $(".must").after("<span style='color:red;'>*</span>");
	}
	$(function() {
		//注册验证
	    $("#userRegis form").validate({
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
	                            return true;
	                        else
	                            return false;
	                    }
	                }
	            },
	          	//验证昵称
		    	nickname: {
		                required: true,
		                minlength: 3,
		                maxlength: 16,
		                remote: {
		                    type: "post",
		                    url: "checkNickName.php",
		                    data: {
		                    	nickname: function() {
		                            return $("#nickname").val();
		                        }
		                    },
		                    dataType: "html",
		                    dataFilter: function(data, type) {
		                        if (data == "true")
		                            return true;
		                        else
		                            return false;
		                    }
		                }
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
			        userVerify : {
			        	required: true,
				    },
				  	//验证邮箱
		        	userVerify: {
		                required: true,
		                remote: {
		                    type: "post",
		                    url: "checkVerify.php",
		                    data: {
		                    	userVerify: function() {
		                            return $(".regVerify").val();
		                        }
		                    },
		                    dataType: "html",
		                    dataFilter: function(data, type) {
		                        if (data == "true")
		                            return true;
		                        else
		                            return false;
		                    }
		                }
		            },
			        
	        },
	        messages: {
	        	user_email: {
	                required: "必填",
	                remote: "此邮箱已注册，可直接登录（或重设密码）"
	            },
	            nickname: {
	                required: "必填",
	                minlength: "昵称长度不能小于3个字符",
	                maxlength: "昵称长度不能大于16个字符",
	                remote: "此昵称已经存在，请更换"
	            },
	            user_mobile : {
	            	digits:"请输入正确的手机号码",
	            },
	            user_telephone : {
	            	
		        },
		        userVerify : {
		        	required: "请输入验证码",
		        	remote:"验证码错误",
			    }
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

		//登录验证
	    $("#userLogin form").validate({
	        rules: {
		        //验证邮箱
	        	user_email: {
	                required: true,
	                remote: {
	                    type: "post",
	                    url: "checkUserEmail.php",
	                    data: {
	                    	user_email: function() {
	                            return $("#user_email1").val();
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
	          //验证密码
	        	user_pwd: {
	                required: true,
	                remote: {
	                    type: "post",
	                    url: "checkUserPwd.php",
	                    data: {
	                    	user_pwd: function() {
	                            return $("#user_pwd").val();
	                        },
	                        user_email: function() {
	                            return $("#user_email1").val();
	                        },
	                    },
	                    dataType: "html",
	                    dataFilter: function(data, type) {
	                        if (data == "true")
	                            return true;
	                        else
	                            return false;
	                    }
	                }
	            },
	        },
	        messages: {
	        	user_email: {
	                required: "必填",
	                remote: "此账号还未注册",
	            },
	            user_pwd: {
	                required: "必填",
	                remote: "此账号未激活或密码错误",
	            },
	        },
		}); 
	    
	});
	//更换验证码
	function change_verify(){
		var img = document.getElementById("userVerify");  
        img.src =  "admin/getVerify.php?" + Math.random().toString(); 
	}
	// 空字符串判断
	function isEmpty(v, allowBlank) {
	   return v === null || v === undefined || (!allowBlank ? v === "" : false);
	}
	function showLogin(){
		regis = document.getElementById("userRegis");
		login = document.getElementById("userLogin");
		regis.style.display="none";
		login.style.display="block";
	}
	function showRegis(){
		regis = document.getElementById("userRegis");
		login = document.getElementById("userLogin");
		regis.style.display="block";
		login.style.display="none";
	}
	</script>
</body>

</html>
