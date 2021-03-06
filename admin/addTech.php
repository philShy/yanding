<?php 
require_once '../include.php';
checkLogined();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>-.-</title>
<link href="./styles/global.css"  rel="stylesheet"  type="text/css" media="all" />
<script type="text/javascript" charset="utf-8" src="../plugins/kindeditor/kindeditor.js"></script>
<script type="text/javascript" charset="utf-8" src="../plugins/kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript" src="./scripts/jquery-1.6.4.js"></script>
<script>
        KindEditor.ready(function(K) {
                window.editor = K.create('#editor_id');
        });
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
<h3>添加技术文章</h3>
<form action="doAdminAction.php?act=addTech" method="post" enctype="multipart/form-data">
<table width="70%"  border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
	<tr>
		<td align="right">技术文章标题</td>
		<td><input style="width:380px;" type="text" name="title" placeholder="请输入技术文章标题" maxlength="28" required/></td>
	</tr>
	<tr>
		<td align="right">技术文章发布人</td>
		<td><input type="text" name="author"  placeholder="请输入技术文章发布人" required/></td>
	</tr>
	<tr>
		<td align="right">技术文章内容摘要</td>
		<td>
			<textarea name="abstract_content" style="width:99%;height:150px;"></textarea>
		</td>
	</tr>
	<tr>
		<td align="right">技术文章详细内容</td>
		<td>
			<textarea name="content" id="editor_id" style="width:100%;height:400px;"></textarea>
		</td>
	</tr>
	<tr>
		<td align="right">技术文章图片</td>
		<td>
			<a href="javascript:void(0)" id="selectFileBtn">添加图片</a>
			<div id="attachList" class="clear"></div>
		</td>
	</tr>

	<tr>
		<td colspan="2"><input type="submit"  value="发布技术文章"/></td>
	</tr>
</table>
</form>
</body>
</html>