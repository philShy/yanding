<?php 
require_once '../include.php';
checkLogined();
$id=$_REQUEST['id'];
$row=getProById($id);
?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="./styles/global.css"  rel="stylesheet"  type="text/css" media="all" />
<script type="text/javascript" src="./scripts/jquery-1.6.4.js"></script>
<title>Insert title here</title>
</head>
<body>
<h3>修改产品图片</h3>
<form action="doAdminAction.php?act=editProImgs&id=<?php echo $id;?>" method="post" enctype="multipart/form-data">
<table width="70%" border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
	<tr height="30px;">
		<td align="right">商品名称</td>
		<td><?php echo $row['pName'];?></td>
	</tr>
	<tr>
		<td align="right">商品图片操作</td>
		<td>
			<ul style="margin:0;padding:0;">
				<?php
				    $proImgs = getImgsByProId ( $row ['id'] );
				    foreach ( $proImgs as $img ) :
		        ?>
		        <li style="width:120px;height:100px;float:left;list-style:none;">
					<div align="center"><img style="height:70px;width:80px;" src="uploads/<?php echo $img['albumPath'];?>" alt="" /></div>
					<div>
						<input type="button" value="删除" onclick="delProImg(<?php echo $img['id'];?>,<?php echo $row['id'];?>)">
						<input type="button" value="上移" onclick="moveUpImg(<?php echo $img['id'];?>,<?php echo $row['id'];?>)" style="display: <?php echo $img['arrange']>1?'':'none';?>">
					</div>
				</li>
			</ul>
	        <?php endforeach;?>
        </td>
	</tr>
	<tr>
		<td align="right">商品图像添加</td>
		<td>
			<a href="javascript:void(0)" id="selectFileBtn">添加附件</a>
			<div id="attachList" class="clear"></div>
		</td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit"  value="提交"/></td>
	</tr>
</table>
</form>
<script type="text/javascript">
	function delProImg(imgId,proId){
		if(window.confirm("您确认要删除吗？添加一次不容易")){
			window.location='doAdminAction.php?act=delProImg&imgId='+imgId+"&proId="+proId;
		}
	}
	function moveUpImg(id,proId){
		window.location='doAdminAction.php?act=moveUpImg&id='+id+'&proId='+proId;
	}
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
</body>
</html>