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
<script type="text/javascript" src="../scripts/jquery-2.1.1.js"></script>
<title>Insert title here</title>
</head>
<body>
<h3>修改商品型号/料号</h3>
<table width="70%" border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
	<tr height="30px;">
		<td align="right">商品名称</td>
		<td><?php echo $row['pName'];?></td>
	</tr>
	<tr height="30px;">
		<td align="right">商品统称</td>
		<td><?php echo $row['pNum'];?></td>
	</tr>
	<tr>
		<td align="right">商品型号/料号操作</td>
		<td>
			<ul style="margin:0;padding:0;">
				<?php
				    $models = getModelsByPid( $row ['id'] );
				    foreach ( $models as $model ) :
		        ?>
		        <li style="height:50px;padding-top:10px;border-bottom:1px solid #4ba0fa;list-style:none;" class="modItem">
		        	<?php if(($_REQUEST['edit']==1)&&($_REQUEST['modId']==$model['id'])):?>
					<form action="doAdminAction.php?act=editModel&id=<?php echo $model['id'];?>&proId=<?php echo $row['id'];?>" method="post">
			        	<div style="float:left;">型号:<input class="model" type="text" name="model" value="<?php echo $model['model'];?>" /><br>料号:<input class="partNum" type="text" name="partNum" value="<?php echo $model['partNum'];?>" /></div>
						<div style="float:right;">
							<input type="button" value="验证" onclick="check(this);">
							<input type="submit" value="保存">
							<input type="button" value="取消" onclick="cancel(<?php echo $row['id'];?>)">
						</div>
					</form>
		        	<?php else :?>
					<div style="float:left;"><label>型号:<?php echo $model['model'];?></label><br><label>料号<?php echo $model['partNum'];?></label></div>
					<div style="float:right;">
						<input type="button" value="删除" onclick="delmodel(<?php echo $model['id'];?>,<?php echo $row['id'];?>)">
						<input type="button" value="编辑" onclick="editAct(<?php echo $model['id'];?>,<?php echo $row['id'];?>)">
						<input type="button" value="上移" onclick="moveUp(<?php echo $model['id'];?>,<?php echo $row['id'];?>)" style="display: <?php echo $model['arrange']>1?'':'none';?>">
					</div>
		        	<?php endif;?>
				</li>
			</ul>
	        <?php endforeach;?>
        </td>
	</tr>
	<tr>
		<td align="right">商品型号/料号添加操作</td>
		<td>
			<div>
				<input type="button" value="添加" onclick="addModel(this);"/>
			</div>
			<form action="doAdminAction.php?act=addModels&proId=<?php echo $row['id'];?>" method="post">
				<div class="modItem">
					<input class="model" type="text" name="model[]"/>
					<input class="partNum" type="text" name="partNum[]"/>
					<input type="button" value="验证" onclick="checkItem(this)">
					<input type="button" value="删除" onclick="delItem(this)">
				</div>
				<div>
					<input type="submit" class="submit" value="提交">
				</div>
			</form>
		</td>
	</tr>
</table>
<script type="text/javascript">
	function delmodel(id,proId){
		if(window.confirm("您确认要删除吗？添加一次不容易")){
			window.location='doAdminAction.php?act=delModel&id='+id+'&proId='+proId;
		}
	}
	function editAct(id,proId){
		window.location='editModels.php?id='+proId+'&modId='+id+'&edit=1';
	}
	function moveUp(id,proId){
		window.location='doAdminAction.php?act=moveUp&id='+id+'&proId='+proId;
	}
	function cancel(){
		window.location='editModels.php?id=<?php echo $_REQUEST['id']?>';
	}
	function addModel(obj){
		$modField = $('<div class="modItem"><input class="model" type="text" name="model[]"/><input class="partNum" type="text" name="partNum[]"/><input type="button" value="验证" onclick="checkItem(this)"><input type="button" value="删除" onclick="delItem(this)"></div>');
		$(obj).parent('div').next('form').find('div:last-child').before($modField);
	}
	function checkItem(obj){
		var model = $(obj).parent('.modItem').children('.model').val();
	    var partNum = $(obj).parent('.modItem').children('.partNum').val();
	    $.post("checkModel.php",{model:model,partNum:partNum},function(data,status){
	    	if(status=='success'){//这里返回的success表示请求成功，单不表述你的逻辑处理成功
	            if(data==-1){
	                alert('型号和料号没有填写');
	            }else if(data==-2){
	                alert('型号没有填写');
	            }else if(data==-3){
	                alert('料号没有填写');
	            }else if(data==-4){
	                alert('型号已经存在');
	            }else if(data==-5){
	                alert('料号已经存在');
	            }else{
					alert('型号和料号都合规则');
	            }
	       }
	    });
	}
	function delItem(obj){
		$(obj).parent('.modItem').remove();
	}
	function check(obj){
		var model = $(obj).parents('.modItem').find('.model').val();
	    var partNum = $(obj).parents('.modItem').find('.partNum').val();
	    $.post("checkModel.php",{model:model,partNum:partNum},function(data,status){
	    	if(status=='success'){//这里返回的success表示请求成功，单不表述你的逻辑处理成功
	            if(data==-1){
	                alert('型号和料号没有填写');
	            }else if(data==-2){
	                alert('型号没有填写');
	            }else if(data==-3){
	                alert('料号没有填写');
	            }else if(data==-4){
	                alert('型号已经存在');
	            }else if(data==-5){
	                alert('料号已经存在');
	            }else{
					alert('型号和料号都合规则');
	            }
	       }
	    });
	}
</script>
</body>
</html>