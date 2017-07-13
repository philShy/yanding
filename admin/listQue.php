<?php 
require_once '../include.php';
checkLogined();

//得到数据库中所有招聘信息
$sql = "select * from question";
$totalRows=getResultNum($sql);
$pageSize=10;
$totalPage=ceil($totalRows/$pageSize);
$page = $_REQUEST['page']?(int)$_REQUEST['page']:1;
if($page<1||$page==null||!is_numeric($page))$page=1;
if($page>=$totalPage)$page=$totalPage;
$offset=($page-1)*$pageSize;
$sql = "select * from question order by id desc limit {$offset},{$pageSize}";
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
	<div class="details">
		<!--表格-->
		<table class="table" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
	             <th width="10%">编号</th>
	             <th width="10%">姓名</th>
	             <th width="15%">电话</th>
	             <th width="15%">邮箱</th>
	             <th width="15%">商品名称</th>
	             <th width="15%">提问时间</th>
	             <th>操作</th>
	          	</tr>
			</thead>
			<tbody>
                <?php foreach($rows as $row):?>
                <tr>
					<!--这里的id和for里面的c1 需要循环出来-->
					<td><input type="checkbox" id="c1" class="check" value=<?php echo $row['id'];?>><label for="c1" class="label"><?php echo $row['id'];?></label></td>
					<td><?php echo $row['username']; ?></td>
					<td><?php echo $row['phone']; ?></td>
					<td><?php echo $row['email'];?></td>
					<td><?php echo $row['pName'];?></td>
					<td><?php echo date("Y-m-d H:i:s",$row['time']);?></td>
                    
					<td align="center">
						<input type="button" value="详情" class="btn" onclick="showDetail(<?php echo $row['id'];?>,'<?php echo $row['username'];?>')">
						<input type="button" value="删除" class="btn" onclick="delQues(<?php echo $row['id'];?>)">
						<div id="showDetail<?php echo $row['id'];?>" style="display: none;">
							<table class="table" cellspacing="0" cellpadding="0">
								<tr>
									<td width="20%" align="right">姓名</td>
									<td><?php echo $row['username'];?></td>
								</tr>
								<tr>
									<td width="20%" align="right">电话</td>
									<td><?php echo $row['phone'];?></td>
								</tr>
								<tr>
									<td width="20%" align="right">邮箱</td>
									<td><?php echo $row['email'];?></td>
								</tr>
								<tr>
									<td width="20%" align="right">商品名称</td>
									<td><?php echo $row['pName'];?></td>
								</tr>
								<tr>
									<td width="20%" align="right">提问时间</td>
									<td><?php echo date("Y-m-d",$row['time']);?></td>
								</tr>
								<tr>
									<td width="20%" align="right">具体提问内容</td>
									<td><?php echo $row['remark'];?></td>
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
	      title:"提问人姓名："+t,//对话框标题
	      show:"slide",
	      hide:"explode"
	});
}

function delQues(id){
	if(window.confirm("您确认要删除用户提问信息吗？")){
		window.location='doAdminAction.php?act=delQues&id='+id;
	}
}
</script>
</body>
</html>