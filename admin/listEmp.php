<?php 
require_once '../include.php';
checkLogined();

//得到数据库中所有招聘信息
$sql = "select id,position,location,num,duty,requirement,startDate,endDate from employee";
$totalRows=getResultNum($sql);
$pageSize=10;
$totalPage=ceil($totalRows/$pageSize);
$page = $_REQUEST['page']?(int)$_REQUEST['page']:1;
if($page<1||$page==null||!is_numeric($page))$page=1;
if($page>=$totalPage)$page=$totalPage;
$offset=($page-1)*$pageSize;
$sql = "select id,position,location,num,duty,requirement,startDate,endDate from employee limit {$offset},{$pageSize}";
$rows=fetchAll($sql);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>-.-</title>
<link rel="stylesheet" href="styles/backstage.css">
<link rel="stylesheet" href="scripts/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
<script src="scripts/jquery-ui/js/jquery-1.10.2.js"></script>
<script src="scripts/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
<script src="scripts/jquery-ui/js/jquery-ui-1.10.4.custom.min.js"></script>
</head>

<body>
	<div id="showDetail" style="display: none;"></div>
	<div class="details">
		<div class="details_operation clearfix">
			<div class="bui_select">
				<input type="button" value="添&nbsp;&nbsp;加" class="add"
					onclick="addEmp()">
			</div>
		</div>
		<!--表格-->
		<table class="table" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
	             <th width="10%">编号</th>
	             <th width="20%">职位名称</th>
	             <th width="10%">工作地点</th>
	             <th width="10%">招聘人数</th>
	             <th width="15%">招聘起始时间</th>
	             <th width="15%">招聘终止时间</th>
	             <th>操作</th>
	          	</tr>
			</thead>
			<tbody>
                <?php foreach($rows as $row):?>
                <tr>
					<!--这里的id和for里面的c1 需要循环出来-->
					<td><input type="checkbox" id="c1" class="check" value=<?php echo $row['id'];?>><label for="c1" class="label"><?php echo $row['id'];?></label></td>
					<td><?php echo $row['position']; ?></td>
					<td><?php echo $row['location']; ?></td>
					<td><?php echo $row['num'];?></td>
					<td><?php echo date("Y-m-d",$row['startDate']);?></td>
					<td><?php echo date("Y-m-d",$row['endDate']);?></td>
                    
					<td align="center">
						<input type="button" value="详情" class="btn" onclick="showDetail(<?php echo $row['id'];?>,'<?php echo $row['position'];?>')">
						<input type="button" value="修改" class="btn" onclick="editEmp(<?php echo $row['id'];?>)">
						<input type="button" value="删除" class="btn" onclick="delEmp(<?php echo $row['id'];?>)">
						<div id="showDetail<?php echo $row['id'];?>" style="display: none;">
							<table class="table" cellspacing="0" cellpadding="0">
								<tr>
									<td width="20%" align="right">职位名称</td>
									<td><?php echo $row['position'];?></td>
								</tr>
								<tr>
									<td width="20%" align="right">工作地点</td>
									<td><?php echo $row['location'];?></td>
								</tr>
								<tr>
									<td width="20%" align="right">招聘起始时间</td>
									<td><?php echo date("Y-m-d",$row['startDate']);?></td>
								</tr>
								<tr>
									<td width="20%" align="right">招聘终止时间</td>
									<td><?php echo date("Y-m-d",$row['endDate']);?></td>
								</tr>
								<tr>
									<td width="20%" align="right">岗位职责</td>
									<td><?php echo $row['duty'];?></td>
								</tr>
								<tr>
									<td width="20%" align="right">任职要求</td>
									<td><?php echo $row['requirement'];?></td>
								</tr>
							</table>
						</div>
					</td>
				</tr>
                <?php endforeach;?> 
                <?php if($totalRows>$pageSize):?>
                <tr>
                     <td colspan="11"><?php echo showPage($page, $totalPage);?></td>
                </tr>
                <?php endif;?>    
         	</tbody>
		</table>
	</div>
<script type="text/javascript">
function showDetail(id,t){
	$("#showDetail"+id).dialog({
		  height:"auto",
	      width: "auto",
	      position: {my: "center", at: "center",  collision:"fit"},
	      modal:false,//是否模式对话框
	      draggable:true,//是否允许拖拽
	      resizable:true,//是否允许拖动
	      title:"职位名称："+t,//对话框标题
	      show:"slide",
	      hide:"explode"
	});
}

function addEmp(){
	window.location='addEmp.php';
}

function editEmp(id){
	window.location='editEmp.php?id='+id;
}

function delEmp(id){
	if(window.confirm("您确认要删除吗？添加一次不容易")){
		window.location='doAdminAction.php?act=delEmp&id='+id;
	}
}
</script>
</body>
</html>