<?php 
require_once '../include.php';
checkLogined();
$row = getMarketById($_REQUEST['id']);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>-.-</title>
<link href="./styles/global.css"  rel="stylesheet"  type="text/css" media="all" />
<link href="./styles/jedate/jquery.ui.css" rel="stylesheet" type="text/css" />
<link href="./styles/jedate/css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="utf-8" src="../plugins/kindeditor/kindeditor.js"></script>
<script type="text/javascript" charset="utf-8" src="../plugins/kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript" src="./scripts/jquery-1.6.4.js"></script>
<script type="text/javascript" src="../scripts/jquery.validate.min.js"></script>
<script type="text/javascript" src="../scripts/messages_zh.js"></script>
<script type="text/javascript" src="../plugins/datePicker/WdatePicker.js"></script>
<script>
        KindEditor.ready(function(K) {
                window.editor = K.create('#editor_id');
        });
        KindEditor.ready(function(K) {
            window.editor = K.create('#editor_id1');
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
        window.onload = function (){
		    $(".must").after("<span style='color:red'>*</span>");
		}
</script>
</head>
<body>
<h3>添加市场活动</h3>
<form action="doAdminAction.php?act=editMarket&id=<?php echo $_REQUEST['id'];?>" method="post" enctype="multipart/form-data">
<table width="70%"  border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
	<tr>
		<td align="right">活动类型</td>
		<td>
			<select name="actClass">
				<?php for($i=0;$i<2;$i++):?>
				<option value="<?php echo $i;?>" <?php echo $i==$row['actClass']?"selected='selected'":null; ?>>
				<?php 
				if ($i==0) {
					echo "研讨会";
				}elseif ($i==1){
					echo "展会";
				}
				?>
				</option>
			<?php endfor;?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="right">活动标题</td>
		<td><input style="width:380px;" type="text" name="title" value="<?php echo $row['title']?>" class="must" maxlength="35" required/></td>
	</tr>
	<tr>
		<td align="right">活动起始时间</td>
		<td>
			<input type="text" name="startDate" class="Wdate" onClick="WdatePicker({lang:'zh-cn',dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php echo date("Y-m-d H:i:s",$row['startDate']);?>"/>
		</td>
	</tr>
	<tr>
		<td align="right">活动终止时间</td>
		<td>
			<input type="text" name="endDate" class="Wdate" onClick="WdatePicker({lang:'zh-cn',dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php echo date("Y-m-d H:i:s",$row['endDate']);?>"/>
		</td>
	</tr>
	<tr>
		<td align="right">活动地点</td>
		<td><input style="width:380px;" type="text" name="address" value="<?php echo $row['address']?>" class="must" required/></td>
	</tr>
	<tr>
		<td align="right">主办单位</td>
		<td><input style="width:380px;" type="text" name="host" value="<?php echo $row['host']?>"/></td>
	</tr>
	<tr>
		<td align="right">协办单位</td>
		<td><input style="width:380px;" type="text" name="organizer" value="<?php echo $row['organizer']?>"/></td>
	</tr>
	<tr>
		<td align="right">每人费用</td>
		<td><input style="width:380px;" type="text" name="price" value="<?php echo $row['price']?>"/><span style="color: #333333;font-size:12px;">如免费，填写0</span></td>
	</tr>
	<tr>
		<td align="right">联系人</td>
		<td><input style="width:380px;" type="text" name="person" value="<?php echo $row['person']?>"/></td>
	</tr>
	<tr>
		<td align="right">电话</td>
		<td><input style="width:380px;" type="text" name="phone" value="<?php echo $row['phone']?>"/></td>
	</tr>
	<tr>
		<td align="right">邮箱</td>
		<td><input style="width:380px;" type="email" name="email" value="<?php echo $row['email']?>"/></td>
	</tr>
	<tr>
		<td align="right">活动详情</td>
		<td>
			<textarea name="detail" id="editor_id"><?php echo $row['detail']?></textarea>
		</td>
	</tr>
	<tr>
		<td align="right">活动议程</td>
		<td>
			<textarea name="agenda" id="editor_id1"><?php echo $row['agenda']?></textarea>
		</td>
	</tr>
	<tr>
		<td align="right">活动图片</td>
		<td>
			<a href="javascript:void(0)" id="selectFileBtn">添加图片</a>
			<div id="attachList" class="clear"></div>
		</td>
	</tr>

	<tr>
		<td colspan="2"><input type="submit"  value="发布活动"/></td>
	</tr>
</table>
</form>
</body>
<script type="text/javascript" src="./scripts/jquery.ui.js"></script>
<script type="text/javascript" charset="utf-8" src="../plugins/jedate/moment.min.js"></script>
<script type="text/javascript" charset="utf-8" src="../plugins/jedate/stay.js"></script>
</html>