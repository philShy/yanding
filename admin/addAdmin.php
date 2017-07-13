<?php 
require_once '../include.php';
checkLogined();
?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script type="text/javascript" src="./scripts/jquery-1.6.4.js"></script>
<script type="text/javascript" src="../scripts/jquery.validate.min.js"></script>
<script type="text/javascript" src="../scripts/messages_zh.js"></script>
<title>添加管理员</title>
</head>
<body>
<h3>添加管理员</h3>
<form action="doAdminAction.php?act=addAdmin" method="post">
<table width="70%" border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
	<tr>
		<td align="right">管理员名称</td>
		<td><input type="text" name="username" placeholder="请输入管理员名称" required/></td>
	</tr>
	<tr>
		<td align="right">管理员密码</td>
		<td><input type="password" name="password" required/></td>
	</tr>
	<tr>
		<td align="right">管理员邮箱</td>
		<td><input type="email" name="email" placeholder="请输入管理员邮箱" required/></td>
	</tr>
	<tr>
		<td align="right">是否是超级管理员</td>
		<td>
			<select name="limits">
				<option value="0">否</option>
				<option value="1">是</option>
			</select>
		</td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit"  value="添加管理员"/></td>
	</tr>

</table>
</form>
</body>
</html>