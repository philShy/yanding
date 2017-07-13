<?php 
require_once '../include.php';
checkLogined();
$rows = getAllBigCate();
if(!$rows){
	alertMes("没有相应商品大类，请先添加大类!!", "addBigCate.php");
}
$id=$_REQUEST['id'];
$small_cate=getSmallCateById($id);
?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
<script type="text/javascript" src="./scripts/jquery-1.6.4.js"></script>
<script type="text/javascript" src="../scripts/jquery.validate.min.js"></script>
<script type="text/javascript" src="../scripts/messages_zh.js"></script>
</head>
<body>
<h3>修改商品小类</h3>
<form action="doAdminAction.php?act=editSmallCate&id=<?php echo $id;?>" method="post">
<table width="70%" border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
	<tr>
		<td align="right">小分类名称</td>
		<td><input type="text" name="small_cName" value="<?php echo $small_cate['small_cName'];?>"  maxlength="14" required/></td>		
	</tr>
	<tr>
		<td align="right">商品大类</td>
		<td>
		<select name="big_cId">
			<?php foreach($rows as $row):?>
				<option value="<?php echo $row['id'];?>"<?php echo $row['id']==$small_cate['big_cId']?"selected='selected'":null;?>><?php echo $row['big_cName'];?></option>
			<?php endforeach;?>
		</select>
		</td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit"  value="修改小分类"/></td>
	</tr>

</table>
</form>
</body>
</html>