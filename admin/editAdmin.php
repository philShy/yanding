<?php 
require_once '../include.php';
checkLogined();
$id=$_REQUEST['id'];
$row=getAdminById($id);

if(isset($_SESSION['adminId'])){
	$adminId = $_SESSION['adminId'];
}elseif(isset($_COOKIE['adminId'])){
	$adminId = $_COOKIE['adminId'];
}
$user = getAdminById($adminId);
$where = '';
if ($user['limits'] == 0) {
	$where .= " where id={$adminId}";
}
?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script type="text/javascript" src="./scripts/jquery-1.6.4.js"></script>
<script type="text/javascript" src="../scripts/jquery.validate.min.js"></script>
<script type="text/javascript" src="../scripts/messages_zh.js"></script>
<title>编辑管理员</title>
</head>
<body>
<h3>编辑管理员</h3>
<form action="doAdminAction.php?act=editAdmin&id=<?php echo $id;?>" method="post">
<table width="70%" border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
	<tr>
		<td align="right">管理员名称</td>
		<td><input type="text" name="username" value="<?php echo $row['username'];?>" required/></td>
	</tr>
	<tr>
		<td align="right">管理员密码</td>
		<td><input type="password" name="password"  value="" required/></td>
	</tr>
	<tr>
		<td align="right">管理员邮箱</td>
		<td><input type="email" name="email" value="<?php echo $row['email'];?>" required/></td>
	</tr>
	<?php if($user['limits']==1):?>
	<tr>
		<td align="right">是否是超级管理员</td>
		<td>
			<select name="limits">
				<?php for($i=0;$i<2;$i++):?>
				<option value="<?php echo $i;?>" <?php echo $i==$row['limits']?"selected='selected'":null; ?>>
				<?php 
				if ($i==0) {
					echo "否";
				}elseif ($i==1){
					echo "是";
				}
				?>
				</option>
				<?php endfor;?>
			</select>
		</td>
	</tr>
	<?php endif;?>
	<tr>
		<td colspan="2"><input type="submit"  value="编辑管理员"/></td>
	</tr>

</table>
</form>
</body>
</html>