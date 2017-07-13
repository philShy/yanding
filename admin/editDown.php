<?php
require_once '../include.php';
checkLogined();
$id = $_REQUEST['id'];
$down = getDownById($id);
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
<form action="doAdminAction.php?act=editDown&id=<?php echo $down['id'];?>" method="post" enctype="multipart/form-data">
<table width="70%"  border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
	<tr>
		<td align="right">下载内容分类</td>
		<td>
			<select name="down_cate" onchange="change_cate()" id="down_cate";>
			<?php for($i=1;$i<=3;$i++):?>
				<option value="<?php echo $i;?>" <?php echo $i==$down['down_cate']?"selected='selected'":null; ?>>
				<?php 
				if ($i==1) {
					echo "产品";
				}elseif ($i==2){
					echo "技术文章";
				}else{
					echo "售后服务";
				}
				?>
				</option>
			<?php endfor;?>
			</select>
		
		</td>
	</tr>
	<tr id="tr1" <?php echo $down['down_cate']==1?"style='display:'":"style='display:none'";?>>
		<td align="right">产品类型</td>
		<td>
			<div>
				<select name="product" onchange="change_pro()" id="pro">
				<?php for($i=0;$i<=2;$i++):?>
					<option value="<?php echo $i;?>" <?php echo $i==$down['product']?"selected='selected'":null; ?>>
					<?php 
					if ($i==1) {
						echo "文档";
					}elseif ($i==2){
						echo "软件";
					}else{
						echo "请选择";
					}
					?>
					</option>
				<?php endfor;?>
				</select>
			</div>
			
			<div>
				<label>对应产品统称</label><input type="text" name="pNum"  value="<?php echo $down['pNum'];?>"/>多个统称以逗号(英文输入)隔开
			</div>
			
			<div id="soft"  <?php echo $down['product']==2?"style='display:'":"style='display:none'";?>>
				<ul style="list-style-type: none;margin:0;padding:0;">
					<li><label>链接</label><input type="text" name="soft_link"  value="<?php echo $down['soft_link'];?>"/></li>
					<li><label>密码</label><input type="text" name="soft_password"  value="<?php echo $down['soft_password'];?>"/></li>
				</ul>
			</div>
		</td>
	</tr>
	
	<tr id="tr2" <?php echo $down['down_cate']==2?"style='display:'":"style='display:none'";?>>
		<td align="right">技术文章</td>
		<td>
			<div>
				<label>技术文章名称</label><input type="text" name="tech_title"  value="<?php echo $down['tech_title'];?>"/>
			</div>
		</td>
	</tr>
	
	<tr id="tr3" <?php echo $down['down_cate']==3?"style='display:'":"style='display:none'";?>>
		<td align="right">售后服务类型</td>
		<td>
			<div>
				<select name="service">
				<?php for($i=0;$i<=2;$i++):?>
					<option value="<?php echo $i;?>" <?php echo $i==$down['service']?"selected='selected'":null; ?>>
					<?php 
					if ($i==1) {
						echo "服务流程";
					}elseif ($i==2){
						echo "定期校准";
					}else{
						echo "请选择";
					}
					?>
					</option>
				<?php endfor;?>
				</select>
			</div>
		</td>
	</tr>
	<tr>
		<td align="right">文档删除</td>
		<td>
			<ul style="margin:0;padding:0;">
				<?php
				    $files = getFileByDid($down['id'] );
				    foreach ( $files as $file ) :
		        ?>
		        <li style="width:70px;height:100px;float:left;margin-right:20px;list-style:none;">
					<div><?php echo $file['filePath'];?></div>
					<div align= "center">
						<input type="button" value="删除" class="btn" onclick="delFile(<?php echo $file['id'];?>,<?php echo $down['id'];?>)">
					</div>
				</li>
			</ul>
	        <?php endforeach;?>
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
	}else if(pro==1){
		//文档上传显示
		var upload = document.getElementById('upload');
		upload.style.display = '';

		//链接不显示
		var soft = document.getElementById('soft');
		soft.style.display = 'none';
	}
}
function delFile(fileId,did){
	if(window.confirm("您确认要删除吗？添加一次不容易")){
		window.location='doAdminAction.php?act=delFile&fileId='+fileId+"&did="+did;
	}
}

</script>

</body>
</html>