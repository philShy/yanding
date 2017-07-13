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
<script type="text/javascript" src="./scripts/jquery-1.6.4.js"></script>
<script  type="text/javascript">
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
<h3>添加下载内容</h3>
<form action="doAdminAction.php?act=addDown" method="post" enctype="multipart/form-data">
<table width="70%"  border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
	<tr>
		<td align="right">下载内容分类</td>
		<td>
			<select name="down_cate" onchange="change_cate()" id="down_cate";>
				<option value="1">产品</option>
				<option value="2">技术文章</option>
				<option value="3">售后服务</option>
			</select>
		
		</td>
	</tr>
	<tr id="tr1">
		<td align="right">产品类型</td>
		<td>
			<div>
				<select name="product" onchange="change_pro()" id="pro">
					<option value="0">请选择</option>
					<option value="1">文档</option>
					<option value="2">软件</option>
				</select>
			</div>
			
			<div>
				<label>对应产品统称</label><input type="text" name="pNum"  placeholder="商品统称"/>多个统称以逗号(英文输入)隔开
			</div>
			
			<div id="soft" style="display: none;">
				<ul style="list-style-type: none;margin:0;padding:0;">
					<li><label>链接</label><input type="text" name="soft_link"  placeholder="百度云链接"/></li>
					<li><label>密码</label><input type="text" name="soft_password"  placeholder="百度云密码"/></li>
				</ul>
			</div>
		</td>
	</tr>
	
	<tr id="tr2" style="display: none;">
		<td align="right">技术文章</td>
		<td>
			<div>
				<label>技术文章名称</label><input type="text" name="tech_title"  placeholder="技术文章名称"/>
			</div>
		</td>
	</tr>
	
	<tr id="tr3" style="display: none;">
		<td align="right">售后服务类型</td>
		<td>
			<div>
				<select name="service">
					<option value="0">请选择</option>
					<option value="1">服务流程</option>
					<option value="2">定期校准</option>
				</select>
			</div>
		</td>
	</tr>
	
	<tr id="upload">
		<td align="right">上传文件</td>
		<td>
			<a href="javascript:void(0)" id="selectFileBtn">上传附件</a>
			<div id="attachList" class="clear"></div>
		</td>
	</tr>

	<tr>
		<td colspan="2"><input type="submit"  value="上传文件"/></td>
	</tr>
</table>
</form>
<script type="text/javascript">
function change_cate(){
	var cate = $("#down_cate").val();
	var pro = $("#pro").val();
	for(i=1;i<=3;i++){
		var trInfo = document.getElementById('tr' + (i));
		if(i==cate){
			trInfo.style.display = '';
		}else{
			trInfo.style.display = 'none';
		}
		if(cate==1&&pro==2){
			var upload = document.getElementById('upload');
			upload.style.display = 'none';

			//链接显示
			var soft = document.getElementById('soft');
			soft.style.display = '';
		}else{
			//文档上传显示
			var upload = document.getElementById('upload');
			upload.style.display = '';

			//链接不显示
			var soft = document.getElementById('soft');
			soft.style.display = 'none';
		}
	}
}

function change_pro(){
	var pro = $("#pro").val();
	if(pro==2){
		//文档上传不显示
		var upload = document.getElementById('upload');
		upload.style.display = 'none';

		//链接显示
		var soft = document.getElementById('soft');
		soft.style.display = '';
	}else{
		//文档上传显示
		var upload = document.getElementById('upload');
		upload.style.display = '';

		//链接不显示
		var soft = document.getElementById('soft');
		soft.style.display = 'none';
	}
}
</script>

</body>
</html>