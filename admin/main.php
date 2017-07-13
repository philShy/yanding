<?php 
require_once '../include.php';
checkLogined();
?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
</head>
<body>
<center>
	<h3 style="color:#1b1b1b;">系统信息</h3>
	<table width="70%" border="1" cellpadding="5" cellspacing="0" bgcolor="#ebf5ff">
		<tr>
			<th style="color:#1b1b1b;">操作系统</th>
			<td><?php echo PHP_OS;?></td>
		</tr>
		<tr>
			<th style="color:#1b1b1b;">Apache版本</th>
			<td><?php echo apache_get_version();?></td>
		</tr>
		<tr>
			<th style="color:#1b1b1b;">PHP版本</th>
			<td><?php echo PHP_VERSION;?></td>
		</tr>
		<tr>
			<th style="color:#1b1b1b;">运行方式</th>
			<td><?php echo PHP_SAPI;?></td>
		</tr>
	</table>
	<h3 style="color:#1b1b1b;">软件信息</h3>
	<table width="70%" border="1" cellpadding="5" cellspacing="0" bgcolor="#ebf5ff">
		<tr>
			<th style="color:#1b1b1b;">系统名称</th>
			<td>研鼎信息技术有限公司官网</td>
		</tr>
		<tr>
			<th style="color:#1b1b1b;">开发团队</th>
			<td>研鼎研发团队</td>
		</tr>
		<tr>
			<th style="color:#1b1b1b;">公司网址</th>
			<td><a href="http://www.yandingtech.com">http://www.yanding.com</a></td>
		</tr>
		<tr>
			<th style="color:#1b1b1b;">成功案例</th>
			<td>52rd/rdbuy</td>
		</tr>
	</table>
</center>

</body>
</html>