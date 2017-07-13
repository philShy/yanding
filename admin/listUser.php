<?php 
require_once '../include.php';
checkLogined();
$where = $page_where ="";
if (!empty($_REQUEST['dutyId'])&&$_REQUEST['dutyId']>0) {
	$where .= " and dutyId ={$_REQUEST['dutyId']}";
	$page_where .= "dutyId={$_REQUEST['dutyId']}&";
}
if (!empty($_REQUEST['nickname'])) {
	$where .= " and nickname ='{$_REQUEST['nickname']}'";
	$page_where .= "nickname={$_REQUEST['nickname']}&";
}
if (!empty($_REQUEST['user_email'])) {
	$where .= " and user_email ='{$_REQUEST['user_email']}'";
	$page_where .= "user_email={$_REQUEST['user_email']}&";
}
$page=$_REQUEST['page']?(int)$_REQUEST['page']:1;
$sql="select * from user where 1 {$where}";
$totalRows=getResultNum($sql);
$pageSize=16;
$totalPage=ceil($totalRows/$pageSize);
if($page<1||$page==null||!is_numeric($page))$page=1;
if($page>=$totalPage)$page=$totalPage;
$offset=($page-1)*$pageSize;
$sql="select * from user where 1 {$where} order by regtime desc limit {$offset},{$pageSize}";
$rows=fetchAll($sql);
$duty = fetchAll("select id,duty_name from user_duty");
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
   		<div class="bui_select">
			<input type="button" value="导&nbsp;&nbsp;出" class="exprot" onclick="exportUser()">
		</div>
       <div class="fr">
			<div class="text">
				<span>职责</span> 
				<div class="bui_select">
					<select name="duty" id=dutyId class="select">
						<option value="-1">请选择</option>
						<?php foreach ($duty as $_duty):?>
						<option value="<?php echo $_duty['id']?>" <?php echo $_duty['id']==$_REQUEST['dutyId']?"selected='selected'":null;?>><?php echo $_duty['duty_name'];?></option>
						<?php endforeach;?>
					</select>
				</div>
			</div>
			<div class="text">
				<span>昵称</span> 
				<input type="text" value="<?php echo $_REQUEST['nickname'];?>" class="search" id="nickname">
			</div>
			<div class="text">
				<span>邮箱</span> 
				<input type="text" value="<?php echo $_REQUEST['user_email'];?>" class="search" id="user_email">
			</div>
			<div class="fr"><input type="button" value="搜索" class="btn" onclick="search()"> </div>
		</div> 
   </div>
   <!--表格-->
   <table class="table" cellspacing="0" cellpadding="0">
        <thead>
             <tr>
                 <th width="6%">编号</th>
                 <th width="8%">姓名</th>
                 <th width="8%">昵称</th>
                 <th width="12%">邮箱</th>
                 <th width="10%">手机号码</th>
                 <th width="10%">固定电话</th>
                 <th width="14%">公司</th>
                 <th width="12%">职责</th>
                 <th width="6%">是否激活</th>
                 <th width="12%">注册时间</th>
             </tr>
        </thead>
        <tbody>
        <?php  foreach($rows as $row):?>
            <tr>
               <!--这里的id和for里面的c1 需要循环出来-->
               <td><input type="checkbox" id="c1" class="check"><label for="c1" class="label"><?php echo $row['id'];?></label></td>
               <td><?php echo $row['user_name'];?></td>
               <td><?php echo $row['nickname']?></td>
               <td><?php echo $row['user_email']?></td>
               <td><?php echo $row['user_mobile']?></td>
               <td><?php echo $row['user_telephone']?></td>
               <td><?php echo $row['company']?></td>
               <td>
               		<?php $duty = fetchOne("select duty_name from user_duty where id={$row['dutyId']}");
               			echo $duty['duty_name'];
               		?>
               </td>
               <td>
               		<?php echo $row['active']==1?"是":"否";
               		?>
               </td>
               <td><?php echo date('Y-m-d H:i:s',$row['regtime']);?></td>
            </tr>
            <?php endforeach;?>
            <?php if($totalRows>$pageSize):?>
            <tr>
               <td colspan="10"><?php echo showPage($page, $totalPage,$page_where);?></td>
            </tr>
            <?php endif;?>
        </tbody>
    </table>
</div>
<script type="text/javascript">
	function search(){
		var dutyId=document.getElementById("dutyId").value;
		var nickname=document.getElementById("nickname").value;
		var user_email=document.getElementById("user_email").value;
		window.location="listUser.php?dutyId="+dutyId+"&nickname="+nickname+"&user_email="+user_email;
	}
	function exportUser(){
		window.location="doAdminAction.php?act=exportUser";
			
	}
</script>
</body>
</html>