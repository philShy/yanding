<?php 
require_once '../include.php';
checkLogined();
if(isset($_SESSION['adminId'])){
	$adminId = $_SESSION['adminId'];
}elseif(isset($_COOKIE['adminId'])){
	$adminId = $_COOKIE['adminId'];
}
$user = getAdminById($adminId);

$where = $page_where = "";
if (!empty($_REQUEST['big_cName'])) {
	$where .= "where big_cName like '%{$_REQUEST['big_cName']}%'";
	$page_where .= "big_cName={$_REQUEST['big_cName']}";
}
$page=$_REQUEST['page']?(int)$_REQUEST['page']:1;
$sql="select id,big_cName,albumPath from big_cate {$where}";
$totalRows=getResultNum($sql);
$pageSize=10;
$totalPage=ceil($totalRows/$pageSize);
if($page<1||$page==null||!is_numeric($page))$page=1;
if($page>=$totalPage)$page=$totalPage;
$offset=($page-1)*$pageSize;
$sql="select id,big_cName,albumPath from big_cate {$where} order by id asc limit {$offset},{$pageSize}";
$rows=fetchAll($sql);
if(!$rows){
	alertMes("sorry,没有分类,请添加!","addBigCate.php");
	exit;
}

?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
<link rel="stylesheet" href="styles/backstage.css">
<script src="scripts/jquery-ui/js/jquery-1.10.2.js"></script>
</head>
<body>
<div class="details">
   <div class="details_operation clearfix">
   <?php if($user['limits']==1):?>
       <div class="bui_select">
          <input type="button" value="添&nbsp;&nbsp;加" class="add"  onclick="addBigCate()">
       </div>
   <?php endif;?>
       <div class="fr">
			<div class="text">
				<span>大类名称</span> 
				<input type="text" value="<?php echo $_REQUEST['big_cName'];?>" class="search" id="big_cName">
			</div>
			<div class="fr"><input type="button" value="搜索" class="btn" onclick="search()"> </div>
		</div>                     
   </div>
   <!--表格-->
   <table class="table" cellspacing="0" cellpadding="0">
      <thead>
          <tr>
             <th width="15%">编号</th>
             <th width="35%">分类</th>
             <th width="25%">图片</th>
             <?php if($user['limits']==1):?>
             <th>操作</th>
             <?php endif;?>
          </tr>
      </thead>
      <tbody>
       <?php  foreach($rows as $row):?>
         <tr>
         <!--这里的id和for里面的c1 需要循环出来-->
             <td><input type="checkbox" id="c1" class="check"><label for="c1" class="label"><?php echo $row['id'];?></label></td>
             <td><?php echo $row['big_cName'];?></td>
             <td><img style="background-color: #4ca0f8;" alt="" src="bigCate/<?php echo $row['albumPath'];?>"></td>
             <?php if($user['limits']==1):?>
             <td align="center"><input type="button" value="修改" class="btn" onclick="editBigCate(<?php echo $row['id'];?>)"><input type="button" value="删除" class="btn"  onclick="delBigCate(<?php echo $row['id'];?>)"></td>
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
	function editBigCate(id){
		window.location="editBigCate.php?id="+id;
	}
	function delBigCate(id){
		if(window.confirm("您确定要删除吗？删除之后不能恢复哦！！！")){
			window.location="doAdminAction.php?act=delBigCate&id="+id;
		}
	}
	function addBigCate(){
		window.location="addBigCate.php";
	}

	function search(){
		var big_cName=document.getElementById("big_cName").value;
		window.location="listBigCate.php?big_cName="+big_cName;
	}
</script>
</body>
</html>