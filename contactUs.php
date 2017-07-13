<?php 
require_once 'include.php';
checkBrowser();
$user = array();
if (!empty($_SESSION['userId'])) {
	$userId = $_SESSION['userId'];
	$user = fetchOne("select user_name,user_email,user_mobile,user_telephone,company from user where id={$userId}");
}
?>
<!doctype html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="utf-8">
<title>研鼎-联系我们</title>
<link type="text/css" rel="stylesheet" href="styles/reset.css">
<link type="text/css" rel="stylesheet" href="styles/main.css">
<script type="text/javascript" src="scripts/jquery-2.1.1.js"></script>
<script type="text/javascript" src="scripts/jquery.validate.min.js"></script>
<script type="text/javascript" src="scripts/messages_zh.js"></script>
<script type="text/javascript" src="scripts/search.js"></script>
</head>
<body>
	<?php include 'head.php';?>
	<div class="con_list_top"></div>
	<div class="con_list_content">
		<div class="con_list_left">
			<div class="clf_top">
				<img alt="" src="images/contact/con_ltop.png">
			</div>
			<div class="clf_center"><span>联系我们</span></div>
			<div class="clf_bottom">
				<img alt="" src="images/news/news_lbottom.png">
			</div>
		</div>
		<div class="con_list_right">
			<div class="news_list_title" style="border-bottom: none;">
				<a href="index.php"><img alt="" src="images/news/news_rtop.png"></a>
				<span>&gt;&gt;&nbsp;&nbsp;联系我们</span>
			</div>
			
			<div class="con_desc">
				<p>如您对我司的产品感兴趣，请您填写如下信息和相关备注，点击“提交”按钮。</p>
				<p>我司销售人员会第一时间与您取得联系，非常感谢您的咨询。</p>
			</div>
			
			<div class="con_input">
				<form action="admin/doAdminAction.php?act=addQues" method="post" id="contact">
					<table>
						<tr>
							<td>姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名：<input type="text" name="username" class="must" value="<?php echo empty($user['user_name'])?'':$user['user_name'];?>" required/></td>
							<td>您的具体要求：</td>
						</tr>
						<tr>
							<td>电&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;话：<input type="text" name="phone" class="must" value="<?php echo empty($user['user_mobile'])?(empty($user['user_telephone'])?'':$user['user_telephone']):$user['user_mobile']?>" required/></td>
							<td rowspan="5"><div class="detail_request"><textarea style="width: 100%;height:100%;" name="remark" maxlength="200" placeholder="最多输入200字"></textarea></div></td>
						</tr>
						<tr>
							<td>电子邮箱：<input type="email" name="email" class="must" value="<?php echo empty($user['user_email'])?'':$user['user_email'];?>" required/></td>
						</tr>
						<tr>
							<td>公司名称：<input type="text" name="company" value="<?php echo empty($user['company'])?'':$user['company'];?>"/></td>
						</tr>
						<tr>
							<td>地&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;址：<input type="text" name="address" class="must" required/></td>
						</tr>
						<tr>
							<td>商品名称：<input type="text" name="pName" value="<?php echo empty($_REQUEST['pName'])?"":$_REQUEST['pName'];?>"/></td>
						</tr>
						<tr>
							<td  colspan="2"><input class="queSubmit" type="submit"  value="提    交"/></td>
						</tr>
					</table>
				</form>
			</div>
			
			<div class="con_map">
				<div class="map">
					<img alt="" src="images/contact/map.png"></div>
				<div class="map_tel">
					<h4>北京--研鼎办事处</h4>
					<div class="con_info">
						联系人：路静 Annie <br>
						电话：021-50275682<br>
						邮箱：sales@rdbuy.com
					</div>
					<h4>上海--上海研鼎信息技术有限公司</h4>
					<div class="con_info">
						联系人：刘红伟 Jacky<br>
						电话：021-50275655<br>
						邮箱：sales@rdbuy.com
					</div>
					<h4>深圳--研鼎办事处</h4>
					<div class="con_info">
						联系人：肖冯力 Leon<br>
						电话：15889619096 <br>
						邮箱：Leon.xiao@rdbuy.com 
					</div>
				</div>
			</div>
			
		</div>
	</div>
	<?php include 'bottom.php';?>
	
	<script type="text/javascript">
		window.onload = function (){
		    $(".must").after("<span style='color:red'>*</span>");
		}
		$(function() {
		    $("#contact").validate();
		});
	</script>
</body>
</html>