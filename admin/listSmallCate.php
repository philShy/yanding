<?php 
require_once '../include.php';
checkLogined();
if(isset($_SESSION['adminId'])){
	$adminId = $_SESSION['adminId'];
}elseif(isset($_COOKIE['adminId'])){
	$adminId = $_COOKIE['adminId'];
}
$user = getAdminById($adminId);

$_REQUEST['big_cId'] = empty($_REQUEST['big_cId'])?0:$_REQUEST['big_cId'];
// var_dump($_REQUEST['big_cId']);
$where = $page_where ="";
if (!empty($_REQUEST['big_cId'])&&$_REQUEST['big_cId']!=-1) {
	$big_cId = substr($_REQUEST['big_cId'], 0,3);
	$where .= " and b.id = {$big_cId}";
	$page_where .= "big_cId={$_REQUEST['big_cId']}";
}
if (!empty($_REQUEST['small_cName'])) {
	$where .= " and s.small_cName like '%{$_REQUEST['small_cName']}%' ";
	$page_where .= "small_cName={$_REQUEST['small_cName']}";
}
$page=$_REQUEST['page']?(int)$_REQUEST['page']:1;
$sql="select s.id,s.small_cName,b.big_cName from small_cate s join big_cate b on s.big_cId=b.id where 1 {$where}";
$totalRows=getResultNum($sql);
$pageSize=10;
$totalPage=ceil($totalRows/$pageSize);
if($page<1||$page==null||!is_numeric($page))$page=1;
if($page>=$totalPage)$page=$totalPage;
$offset=($page-1)*$pageSize;
$sql="select s.id,s.small_cName,b.big_cName from small_cate s join big_cate b on s.big_cId=b.id {$where} order by s.id limit {$offset},{$pageSize}";
$rows=fetchAll($sql);
if(!$rows){
	alertMes("sorry,没有分类,请添加!","addSmallCate.php");
	exit;
}

?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
<link rel="stylesheet" href="styles/backstage.css">
<script type="text/javascript" src="./scripts/jquery-1.6.4.js"></script>
<script>
var BigCate;
$(function(){
    $.get(
        "getAllCate.php", 
        function(obj) {
       	 BigCate = obj;
            var sb = new StringBuffer();
            data= $.parseJSON(obj);
            $.each(data, function(i, val) {
                if(val.item_code.substr(3, 3) == '000'){
                	if (<?php echo $_REQUEST['big_cId'];?>) {
                		if(val.item_code==<?php echo (int)$_REQUEST['big_cId'];?>){
                            sb.append("<option value='"+val.item_code+"' selected='selected'>"+val.item_name+"</option>");
                        }else{
                        	sb.append("<option value='"+val.item_code+"'>"+val.item_name+"</option>");
                        }
                	}else{
                    	sb.append("<option value='"+val.item_code+"'>"+val.item_name+"</option>");
                    } 
                    
                }
            });
            $("#chooseBigCate").after(sb.toString());
        }
    );
});
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
</head>
<body>
<div class="details">
   <div class="details_operation clearfix">
   <?php if($user['limits'] == 1):?>
       <div class="bui_select">
           <input type="button" value="添&nbsp;&nbsp;加" class="add"  onclick="addSmallCate()">
       </div>
   <?php endif;?>
       <div class="fr">
			<div class="text">
				<span>大类名称</span> 
				<div class="bui_select">
					<select name="big_cId" id="big_cId" class="select">
						<option value="-1" id="chooseBigCate">请选择</option>
					</select>
				</div>
			</div>
			<div class="text">
				<span>小类名称</span> 
				<input type="text" value="<?php echo $_REQUEST['small_cName'];?>" class="search" id="small_cName">
			</div>
			<div class="fr"><input type="button" value="搜索" class="btn" onclick="search()"> </div>
		</div> 
   </div>
   <!--表格-->
   <table class="table" cellspacing="0" cellpadding="0">
        <thead>
             <tr>
                 <th width="15%">编号</th>
                 <th width="30%">商品小类</th>
                 <th width="30%">商品大类</th>
                 <?php if($user['limits'] == 1):?>
                 <th>操作</th>
                 <?php endif;?>
             </tr>
        </thead>
        <tbody>
        <?php  foreach($rows as $row):?>
            <tr>
               <!--这里的id和for里面的c1 需要循环出来-->
               <td><input type="checkbox" id="c1" class="check"><label for="c1" class="label"><?php echo $row['id'];?></label></td>
               <td><?php echo $row['small_cName'];?></td>
               <td><?php echo $row['big_cName']?></td>
               <?php if($user['limits'] == 1):?>
               <td align="center"><input type="button" value="修改" class="btn" onclick="editSmallCate(<?php echo $row['id'];?>)"><input type="button" value="删除" class="btn"  onclick="delSmallCate(<?php echo $row['id'];?>)"></td>                  
               <?php endif;?>
            </tr>
            <?php endforeach;?>
            <?php if($totalRows>$pageSize):?>
            <tr>
               <td colspan="4"><?php echo showPage($page, $totalPage,$page_where);?></td>
            </tr>
            <?php endif;?>
        </tbody>
    </table>
</div>
<script type="text/javascript">
	function editSmallCate(id){
		window.location="editSmallCate.php?id="+id;
	}
	function delSmallCate(id){
		if(window.confirm("您确定要删除吗？删除之后不能恢复哦！！！")){
			window.location="doAdminAction.php?act=delSmallCate&id="+id;
		}
	}
	function addSmallCate(){
		window.location="addSmallCate.php";
	}
	function search(){
		var big_cId=document.getElementById("big_cId").value;
		var small_cName=document.getElementById("small_cName").value;
		window.location="listSmallCate.php?big_cId="+big_cId+"&small_cName="+small_cName;
	}
</script>
</body>
</html>