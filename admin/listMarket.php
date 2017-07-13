<?php 
require_once '../include.php';
checkLogined();

$where = $page_where = "";
if ($_REQUEST['actClass']!='') {
	$page_where .= "actClass={$_REQUEST['actClass']}&";
	$where .= " and actClass={$_REQUEST['actClass']}";
}

if ($_REQUEST['title']!="") {
	$where .= " and title like '%{$_REQUEST['title']}%'";
	$page_where .= "title={$_REQUEST['title']}&";
}
//得到数据库中所有商品
$sql = "select * from conference where 1 {$where}";
$totalRows=getResultNum($sql);
$pageSize=10;
$totalPage=ceil($totalRows/$pageSize);
$page = $_REQUEST['page']?(int)$_REQUEST['page']:1;
if($page<1||$page==null||!is_numeric($page))$page=1;
if($page>=$totalPage)$page=$totalPage;
$offset=($page-1)*$pageSize;
$sql = "select * from conference where 1 {$where} limit {$offset},{$pageSize}";
$rows=fetchAll($sql);

$actClass = array(
		0=>(array('value'=>'','name'=>'-请选择-')),
		1=>(array('value'=>'0','name'=>'研讨会')),
		2=>(array('value'=>'1','name'=>'展会')),
);
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
					onclick="addMarket()">
			</div>
			
			<div class="fr">
				<div class="text">
					<span>活动类别：</span>
					<div class="bui_select">
						<select name="actClass" id="actClass" class="select">
						<?php foreach ($actClass as $act):?>
							<option value="<?php echo $act['value']?>" <?php echo $act['value']==$_REQUEST['actClass']?"selected='selected'":null;?>><?php echo $act['name'];?></option>
						<?php endforeach;?>
						</select>
					</div>
				</div>
				
				<div class="text">
					<span>活动名称</span> 
					<input type="text" value="<?php echo $_REQUEST['title'];?>" class="search" id="title">
				</div>
				<div class="fr"><input type="button" value="搜索" class="btn" onclick="search()"> </div>
			</div>
			
		</div>
		<!--表格-->
		<table class="table" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<th width="7%">编号</th>
					<th width="6%">活动类别</th>
					<th width="20%">活动名称</th>
					<th width="10%">活动起始时间</th>
					<th width="10%">活动终止时间</th>
					<th width="10%">承办单位</th>
					<th width="10%">协办单位</th>
					<th width="8%">联系人</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
                <?php foreach($rows as $row):?>
                <tr>
					<!--这里的id和for里面的c1 需要循环出来-->
					<td><input type="checkbox" id="c1" class="check" value=<?php echo $row['id'];?>><label for="c1" class="label"><?php echo $row['id'];?></label></td>
					<td><?php echo $row['actClass']==0?"研讨会":"展会";?></td>
					<td><?php echo $row['title']; ?></td>
					<td><?php echo date("Y-m-d H:i:s",$row['startDate'])?></td>
					<td><?php echo date("Y-m-d H:i:s",$row['endDate'])?></td>
					<td><?php echo $row['host'];?></td>
					<td><?php echo $row['organizer']; ?></td>
					<td><?php echo $row['person'];?></td>
                    
					<td align="center">
						<input type="button" value="详情" class="btn" onclick="showDetail(<?php echo $row['id'];?>,'<?php echo $row['pName'];?>')">
						<input type="button" value="修改" class="btn" onclick="editMarket(<?php echo $row['id'];?>)">
						<input type="button" value="删除" class="btn" onclick="delMarket(<?php echo $row['id'];?>)">
						<div id="showDetail<?php echo $row['id'];?>" style="display: none;">
							<table class="table" cellspacing="0" cellpadding="0">
								<tr>
									<td width="20%" align="right">活动类别</td>
									<td><?php echo $row['actClass']==0?"研讨会":"展会";?></td>
								</tr>
								<tr>
									<td width="20%" align="right">活动名称</td>
									<td><?php echo $row['title'];?></td>
								</tr>
								<tr>
									<td width="20%" align="right">活动起始时间</td>
									<td><?php echo date("Y-m-d",$row['startDate']);?></td>
								</tr>
								<tr>
									<td width="20%" align="right">活动终止时间</td>
									<td><?php echo date("Y-m-d",$row['endDate']);?></td>
								</tr>
								<tr>
									<td width="20%" align="right">活动地址</td>
									<td><?php echo $row['address'];?></td>
								</tr>
								<tr>
									<td width="20%" align="right">主办单位</td>
									<td><?php echo $row['host'];?></td>
								</tr>
								<tr>
									<td width="20%" align="right">协办单位</td>
									<td><?php echo $row['organizer'];?></td>
								</tr>
								<tr>
									<td width="20%" align="right">每人费用</td>
									<td><?php echo $row['price'];?></td>
								</tr>
								<tr>
									<td width="20%" align="right">联系人</td>
									<td><?php echo $row['person'];?></td>
								</tr>
								<tr>
									<td width="20%" align="right">联系电话</td>
									<td><?php echo $row['phone'];?></td>
								</tr>
								<tr>
									<td width="20%" align="right">联系邮箱</td>
									<td><?php echo $row['email'];?></td>
								</tr>
								<tr>
									<td width="20%" align="right">活动图片</td>
									<td>
                        				<?php 
                        					echo "<img src='market/{$row['image']}' alt=''/>&nbsp;";
                        				?>
			                        </td>
								</tr>
							</table>
							<span style="display: block; width: 80%;font-size:12px;border-bottom:2px solid #fb874d;"> <h3>活动详情</h3>
			                	<?php echo $row['detail'];?>
			                </span>
							<span style="display: block; width: 80%;font-size:12px;border-bottom:2px solid #fb874d;"> <h3>活动议程</h3>
			                	<?php echo $row['agenda'];?>
			                </span>
						</div>
					</td>
				</tr>
                <?php endforeach;?> 
                <?php if($totalRows>$pageSize):?>
                <tr>
                     <td colspan="11"><?php echo showPage($page, $totalPage,$page_where);?></td>
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
	      title:"活动名称："+t,//对话框标题
	      show:"slide",
	      hide:"explode"
	});
}

function addMarket(){
	window.location='addMarket.php';
}

function editMarket(id){
	window.location='editMarket.php?id='+id;
}

function delMarket(id){
	if(window.confirm("您确认要删除吗？添加一次不容易")){
		window.location='doAdminAction.php?act=delMarket&id='+id;
	}
}
function search(){
	var actClass=document.getElementById("actClass").value;
	var title=document.getElementById("title").value;
	window.location="listMarket.php?actClass="+actClass+"&title="+title;
}
</script>
</body>
</html>