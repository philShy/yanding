<?php 
require_once '../include.php';
checkLogined();

$where = $page_where = "";
if (!empty($_REQUEST['client_name'])) {
	$where .= "where client_name like '%{$_REQUEST['client_name']}%'";
	$page_where .= "client_name={$_REQUEST['client_name']}";
}
$page=$_REQUEST['page']?(int)$_REQUEST['page']:1;
$sql="select id,client_name from client {$where}";
$totalRows=getResultNum($sql);
$pageSize=12;
$totalPage=ceil($totalRows/$pageSize);
if($page<1||$page==null||!is_numeric($page))$page=1;
if($page>=$totalPage)$page=$totalPage;
$offset=($page-1)*$pageSize;
$sql="select id,client_name,client_img from client {$where} order by id asc limit {$offset},{$pageSize}";
$rows=fetchAll($sql);
if(!$rows){
	alertMes("sorry,没有客户,请添加!","addClient.php");
	exit;
}

?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
<link rel="stylesheet" href="styles/backstage.css">
<link rel="stylesheet" href="scripts/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
<script src="scripts/jquery-ui/js/jquery-1.10.2.js"></script>
<script src="scripts/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
<script src="scripts/jquery-ui/js/jquery-ui-1.10.4.custom.min.js"></script>
</head>
<body>
<div class="details">
   <div class="details_operation clearfix">
       <div class="bui_select">
          <input type="button" value="添&nbsp;&nbsp;加" class="add"  onclick="addClient()">
       </div>
       <div class="fr">
			<div class="text">
				<span>客户名称</span> 
				<input type="text" value="<?php echo $_REQUEST['client_name'];?>" class="search" id="client_name">
			</div>
			<div class="fr"><input type="button" value="搜索" class="btn" onclick="search()"> </div>
		</div>                     
   </div>
   <!--表格-->
   <table class="table" cellspacing="0" cellpadding="0">
      <thead>
          <tr>
             <th width="15%">编号</th>
             <th width="30%">客户名称</th>
             <th width="40%">客户图片</th>
             <th>操作</th>
          </tr>
      </thead>
      <tbody>
       <?php  foreach($rows as $row):?>
         <tr>
         <!--这里的id和for里面的c1 需要循环出来-->
             <td><input type="checkbox" id="c1" class="check"><label for="c1" class="label"><?php echo $row['id'];?></label></td>
             <td><?php echo $row['client_name'];?></td>
             <td><img style="width: 110px;height:60px;" alt="" src="client/<?php echo $row['client_img'];?>"></td>
             <td align="center">
	             <input type="button" value="修改" class="btn" onclick="editClient(<?php echo $row['id'];?>)">
	             <input type="button" value="删除" class="btn"  onclick="delClient(<?php echo $row['id'];?>)">	             
             </td>
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
	function editClient(id){
		window.location="editClient.php?id="+id;
	}
	function delClient(id){
		if(window.confirm("您确定要删除吗？删除之后不能恢复哦！！！")){
			window.location="doAdminAction.php?act=delClient&id="+id;
		}
	}
	function addClient(){
		window.location="addClient.php";
	}
	function search(){
		var client_name=document.getElementById("client_name").value;
		window.location="listClient.php?client_name="+client_name;
	}
</script>
</body>
</html>