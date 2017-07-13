<?php 
require_once '../include.php';
checkLogined();
if(isset($_SESSION['adminId'])){
	$adminId = $_SESSION['adminId'];
}elseif(isset($_COOKIE['adminId'])){
	$adminId = $_COOKIE['adminId'];
}
$user = getAdminById($adminId);

$where = $page_where ="";
if (!empty($_REQUEST['tableId'])&&$_REQUEST['tableId']>0) {
	$where .= " and t.id ={$_REQUEST['tableId']}";
	$page_where .= "tableId={$_REQUEST['tableId']}&";
}
if (!empty($_REQUEST['username'])) {
	$where .= " and o.username ='{$_REQUEST['username']}'";
	$page_where .= "username={$_REQUEST['username']}&";
}
$page=$_REQUEST['page']?(int)$_REQUEST['page']:1;
$sql="select o.id from operation_log o 
      join tableinfo t on o.tableId=t.id 
      join crudinfo c on o.crudId=c.id where 1 {$where}";
$totalRows=getResultNum($sql);
$pageSize=16;
$totalPage=ceil($totalRows/$pageSize);
if($page<1||$page==null||!is_numeric($page))$page=1;
if($page>=$totalPage)$page=$totalPage;
$offset=($page-1)*$pageSize;
$sql="select o.*,t.tableCname,c.crudCname from operation_log o 
      join tableinfo t on o.tableId=t.id 
      join crudinfo c on o.crudId=c.id where 1{$where} order by o.time desc limit {$offset},{$pageSize}";
$rows=fetchAll($sql);
$table = fetchAll("select id,tableCname from tableinfo");
?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
<link rel="stylesheet" href="styles/backstage.css">
</head>
<body>
<div class="details">
   <div class="details_operation clearfix">
       <div class="fr">
			<div class="text">
				<span>数据表</span> 
				<div class="bui_select">
					<select name="table" id="tableId" class="select">
						<option value="-1">请选择</option>
						<?php foreach ($table as $_table):?>
						<option value="<?php echo $_table['id']?>" <?php echo $_table['id']==$_REQUEST['tableId']?"selected='selected'":null;?>><?php echo $_table['tableCname'];?></option>
						<?php endforeach;?>
					</select>
				</div>
			</div>
			<div class="text">
				<span>用户名</span> 
				<input type="text" value="<?php echo $_REQUEST['username'];?>" class="search" id="username">
			</div>
			<div class="fr"><input type="button" value="搜索" class="btn" onclick="search()"> </div>
		</div> 
   </div>
   <!--表格-->
   <table class="table" cellspacing="0" cellpadding="0">
        <thead>
             <tr>
                 <th width="10%">编号</th>
                 <th width="10%">用户名</th>
                 <th width="10%">数据表</th>
                 <th width="10%">操作</th>
                 <th width="10%">操作信息id</th>
                 <th width="10%">ip</th>
                 <th width="10%">时间</th>
                 <?php if($user['limits'] == 1):?>
                 <th width="10%">操作</th>
                 <?php endif;?>
             </tr>
        </thead>
        <tbody>
        <?php  foreach($rows as $row):?>
            <tr>
               <!--这里的id和for里面的c1 需要循环出来-->
               <td><input type="checkbox" id="c1" class="check"><label for="c1" class="label"><?php echo $row['id'];?></label></td>
               <td><?php echo $row['username'];?></td>
               <td><?php echo $row['tableCname']?></td>
               <td><?php echo $row['crudCname']?></td>
               <td><?php echo $row['infoId']?></td>
               <td><?php echo $row['ip']?></td>
               <td><?php echo date('Y-m-d H:i:s',$row['time']);?></td>
               <?php if($user['limits'] == 1):?>
               <td align="center"><input type="button" value="删除" class="btn"  onclick="delOperate(<?php echo $row['id'];?>)"></td>                  
               <?php endif;?>
            </tr>
            <?php endforeach;?>
            <?php if($totalRows>$pageSize):?>
            <tr>
               <td colspan="8"><?php echo showPage($page, $totalPage,$page_where);?></td>
            </tr>
            <?php endif;?>
        </tbody>
    </table>
</div>
<script type="text/javascript">
	function delOperate(id){
		if(window.confirm("您确定要删除吗？删除之后不能恢复哦！！！")){
			window.location="doAdminAction.php?act=delOpera&id="+id;
		}
	}
	function search(){
		var tableId=document.getElementById("tableId").value;
		var username=document.getElementById("username").value;
		window.location="listOperation.php?tableId="+tableId+"&username="+username;
	}
</script>
</body>
</html>