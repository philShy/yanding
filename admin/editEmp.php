<?php 
require_once '../include.php';
checkLogined();
$id=$_REQUEST['id'];
$row=getEmpById($id);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>-.-</title>
<link href="./styles/global.css"  rel="stylesheet"  type="text/css" media="all" />
<link href="./styles/jedate/jquery.ui.css" rel="stylesheet" type="text/css" />
<link href="./styles/jedate/css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="utf-8" src="./scripts/jquery-1.6.4.js"></script>
<script type="text/javascript" charset="utf-8" src="../plugins/kindeditor/kindeditor.js"></script>
<script type="text/javascript" charset="utf-8" src="../plugins/kindeditor/lang/zh_CN.js"></script>
<script>
        KindEditor.ready(function(K) {
                window.editor = K.create('#editor_id');
        });

        KindEditor.ready(function(K) {
            window.editor = K.create('#editor_id1');
	    });
        
</script>
</head>
<body>
<h3>修改招聘信息</h3>
<form action="doAdminAction.php?act=editEmp&id=<?php echo $row['id'];?>" method="post" enctype="multipart/form-data">
<table width="70%"  border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
	<tr>
		<td align="right">职位</td>
		<td><input type="text" name="position"  value="<?php echo $row['position'];?>" maxlength="20" required/></td>
	</tr>
	<tr>
		<td align="right">工作地点</td>
		<td><input type="text" name="location"  value="<?php echo $row['location'];?>" required/></td>
	</tr>
	<tr>
		<td align="right">招聘人数</td>
		<td><input type="text" name="num"  value="<?php echo $row['num'];?>" required/></td>
	</tr>
	<tr>
		<td align="right">岗位职责</td>
		<td>
			<textarea name="duty" id="editor_id" style="width:100%;height:200px;"><?php echo $row['duty'];?></textarea>
		</td>
	</tr>
	<tr>
		<td align="right">任职要求</td>
		<td>
			<textarea name="requirement" id="editor_id1" style="width:100%;height:200px;"><?php echo $row['requirement'];?></textarea>
		</td>
	</tr>
	<tr>
		<td align="right">招聘起始时间</td>
		<td>
			<input type="text" readonly  id="startDate" name="startDate" value="<?php echo date("Y-m-d",$row['startDate']);?>"/>
		</td>
	</tr>
	<tr>
		<td align="right">招聘终止时间</td>
		<td>
			<input type="text" readonly  id="endDate" name="endDate" value="<?php echo date("Y-m-d",$row['endDate']);?>"/>
		</td>
	</tr>

	<tr>
		<td colspan="2"><input type="submit"  value="编辑招聘信息"/></td>
	</tr>
</table>
</form>
</body>
<script type="text/javascript" charset="utf-8" src="./scripts/jquery-1.6.4.js"></script>
<script type="text/javascript" src="./scripts/jquery.ui.js"></script>
<script type="text/javascript" charset="utf-8" src="../plugins/jedate/moment.min.js"></script>
<script type="text/javascript" charset="utf-8" src="../plugins/jedate/stay.js"></script>
</html>