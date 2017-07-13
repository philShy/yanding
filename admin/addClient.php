<?php 
require_once '../include.php';
checkLogined();
?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
<link href="./styles/global.css"  rel="stylesheet"  type="text/css" media="all" />
<script type="text/javascript" src="./scripts/jquery-1.6.4.js"></script>
<script type="text/javascript" src="../scripts/jquery.validate.min.js"></script>
<script type="text/javascript" src="../scripts/messages_zh.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#selectFileBtn").click(function(){
		$fileField = $('<input type="file" name="thumbs[]"/>');
		$fileField.hide();
		$("#attachList").append($fileField);
		$fileField.trigger("click");
		$fileField.change(function(){
		$path = $(this).val();
		$filename = $path.substring($path.lastIndexOf("\\")+1);
		$attachItem = $('<div class="attachItem"><div class="left">a.gif</div><div class="right"><a href="#" title="删除附件">删除</a></div></div>');
		$attachItem.find(".left").html($filename);
		$("#attachList").append($attachItem);		
		});
	});
	$("#attachList>.attachItem").find('a').live('click',function(obj,i){
		$(this).parents('.attachItem').prev('input').remove();
		$(this).parents('.attachItem').remove();
	});
});
</script>
</head>
<body>
<h3>添加客户</h3>
<form action="doAdminAction.php?act=addClient" method="post" enctype="multipart/form-data">
<table width="70%" border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
	<tr>
		<td align="right">客户名称</td>
		<td><input type="text" name="client_name" placeholder="请输入客户名称" required/><span style="color:#333333;">输入英文的客户名称</span></td>
	</tr>
	<tr>
		<td align="right">客户图片</td>
		<td>
			<a href="javascript:void(0)" id="selectFileBtn">添加附件</a>
			<div id="attachList" class="clear"></div>
		</td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit"  value="添加客户"/></td>
	</tr>

</table>
</form>
</body>
</html>