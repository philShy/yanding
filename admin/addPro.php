<?php 
require_once '../include.php';
checkLogined();

$bra_cates = getAllBraCate();
if (!$bra_cates) {
	alertMes("没有相应品牌分类，请先添加品牌", "addBraCate.php");
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>-.-</title>
<link href="./styles/global.css"  rel="stylesheet"  type="text/css" media="all" />
<script type="text/javascript" charset="utf-8" src="../plugins/kindeditor/kindeditor.js"></script>
<script type="text/javascript" charset="utf-8" src="../plugins/kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript" src="../scripts/jquery-2.1.1.js"></script>
<script type="text/javascript" src="../scripts/jquery.validate.min.js"></script>
<script type="text/javascript" src="../scripts/messages_zh.js"></script>
<script type="text/javascript">
KindEditor.ready(function(K) {
    window.editor = K.create('#editor_id');
});
KindEditor.ready(function(K) {
    window.editor = K.create('#editor_id1');
});

$(document).ready(function(){
//添加附件
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
$("#attachList").on('click','.attachItem a',function(obj,i){
	$(this).parents('.attachItem').prev('input').remove();
	$(this).parents('.attachItem').remove();
});

});


var BigCate;
$(function(){
//load test3.php
$.get(
    "getAllCate.php", 
    function(obj) {
   	 BigCate = obj;
        var sb = new StringBuffer();
        data= $.parseJSON(obj);
        $.each(data, function(i, val) {
            if(val.item_code.substr(3, 3) == '000'){
                sb.append("<option value='"+val.item_code+"'>"+val.item_name+"</option>");
            }
        });
        $("#chooseBigCate").after(sb.toString());
            }
        );
    });
　 	// 大类变化时 处理小类
function changeCate(){
var sCate = $("#small_cId");
if(sCate.children().length > 1){
    sCate.empty();
}
if($("#chooseSmallCate").length == 0){
    sCate.append("<option id='chooseSmallCate' value='-1'>请选择小类</option>");
}
var sb = new StringBuffer();
data= $.parseJSON(BigCate);
$.each(data, function(i, val) {
    if(val.item_code.substr(0, 3) == $("#big_cId").val().substr(0, 3) && val.item_code.substr(3, 3) != '000'){
        sb.append("<option value='"+val.item_code+"'>"+val.item_name+"</option>");
    }
});
$("#chooseSmallCate").after(sb.toString());
}


function StringBuffer(str){    
var arr = [];    
str = str || "";
var size = 0 ;  // 存放数组大小
arr.push(str);
// 追加字符串
this.append = function(str1) {        
    arr.push(str1);        
    return this;    
};
// 返回字符串
this.toString = function(){        
    return arr.join("");    
};
// 清空  
this.clear = function(key){  
    size = 0 ;  
    arr = [] ;  
}
// 返回数组大小  
this.size = function(){  
    return size ;  
}
// 返回数组  
this.toArray = function(){  
    return buffer ;  
}
// 倒序返回字符串  
this.doReverse = function(){  
    var str = buffer.join('') ;   
    str = str.split('');    
    return str.reverse().join('');  
}
};
</script>
<style type="text/css">
label.error
{
color:Red;
} 
</style>
</head>
<body>
<h3>添加商品</h3>
<form action="doAdminAction.php?act=addPro" method="post" enctype="multipart/form-data" id="pro_info">
<table width="70%"  border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
	<tr>
		<td align="right">商品名称</td>
		<td><input type="text" name="pName"  placeholder="请输入商品名称" required/></td>
	</tr>
	<tr>
		<td align="right">商品统称</td>
		<td><input type="text" name="pNum"  placeholder="请输入商品统称" required/></td>
	</tr>
	<tr>
		<td align="right">关联商品统称</td>
		<td><input type="text" name="rePNum"  placeholder="请输入关联商品统称"/>多个统称以逗号(英文输入)隔开</td>
	</tr>
	<tr>
		<td align="right">商品型号/料号</td>
		<td>
			<div>
				<input type="button" value="添加" id="addMod"/>
			</div>
			<div class="modList" id="modList"></div>
		</td>
	</tr>
	<tr>
		<td align="right">商品大分类</td>
		<td>
			<select name="big_cId" id="big_cId" onchange="changeCate();" min="1">
				<option value="-1" id="chooseBigCate">请选择大类</option>
			</select>
		</td>
	</tr>
	<tr>
		<td align="right">商品小分类</td>
		<td>
	　　　　　　<select name="small_cId" id="small_cId" style="float: left;" min="1">
				<option value="-1>" id="chooseSmallCate">请选择小类</option>
			</select>
　　　　</td>
	</tr>
	<tr>
		<td  align="right">品牌分类</td>
		<td>
		<select name="bra_cId">
			<?php foreach($bra_cates as $bra_cate):?>
				<option value="<?php echo $bra_cate['id'];?>"><?php echo $bra_cate['bra_cName'];?></option>
			<?php endforeach;?>
		</select>
		</td>
	</tr>
	<tr>
		<td>展示编号</td>
		<td>
			<select name="pShow">
				<option value="0">0</option>
				<option value="1">1</option>
				<option value="2">2</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>推荐编号</td>
		<td>
			<select name="pRecommend">
			<?php for($i=0;$i<=16;$i++):?>
				<option value="<?php echo $i;?>"><?php echo $i;?></option>
			<?php endfor;?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="right">商品简介</td>
		<td>
			<textarea name="pAbstract" style="width:99%;height:150px;"  maxlength="100" placeholder="最多输入100字"></textarea>
		</td>
	</tr>
	<tr>
		<td align="right">商品描述</td>
		<td>
			<textarea name="pDesc" id="editor_id" style="width:100%;height:150px;"></textarea>
		</td>
	</tr>
	<tr>
		<td align="right">商品规格说明书</td>
		<td>
			<textarea name="pStandard" id="editor_id1" style="width:100%;height:150px;"></textarea>
		</td>
	</tr>
	<tr>
		<td align="right">商品图像</td>
		<td>
			<a href="javascript:void(0)" id="selectFileBtn">添加附件</a>
			<div id="attachList" class="clear"></div>
		</td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit"  value="发布商品"/></td>
	</tr>
</table>
</form>
<script type="text/javascript">
$(function() {
	$('#pro_info').validate({
		rules : {
			big_cId:{
			min:1
			},
			small_cId:{
			min:1
			},
		},
		messages:{
			big_cId:{
			min:'必选',
			},
			small_cId:{
			min:'必选',
			}
		}
	});
});
$(function(){
	//添加型号、料号
	$("#addMod").click(function(){
		$modField = $("<div class='modItem'><input type='text' class='model' name='model[]' placeholder='请输入商品型号' required/><input type='text' class='partNum' name='partNum[]' placeholder='请输入厂商料号' required/><input type='button' class='check' value='验证'/><input type='button' class='delete' value='删除'/></div>");
		$("#modList").append($modField);
	});
	//验证型号、料号
	$("#modList").on('click','.modItem .check',function(obj,i){
		var model = $(this).parents('.modItem').children('.model').val();
	    var partNum = $(this).parents('.modItem').children('.partNum').val();
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
	});
	//删除型号、料号
	$("#modList").on("click",".modItem .delete",function(e){
		//$(this).value(e.data.mytext); 
		$(this).parents('.modItem').remove();
	});
});
</script>
</body>
</html>