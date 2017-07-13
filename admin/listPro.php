<?php 
require_once '../include.php';
checkLogined();

$where = $page_where = "";
if ($_REQUEST['isShow']!='') {
	$page_where .= "isShow={$_REQUEST['isShow']}&";
	if ($_REQUEST['isShow']==1) {
		$where .= " and pShow > 0";
	}elseif ($_REQUEST['isShow']==0) {
		$where .= " and pShow = 0";
	}
}

if ($_REQUEST['isRecommend']!='') {
	$page_where .= "isRecommend={$_REQUEST['isRecommend']}&";
	if ($_REQUEST['isRecommend']==1) {
		$where .= " and pRecommend > 0";
	}elseif ($_REQUEST['isRecommend']==0) {
		$where .= " and pRecommend = 0";
	}
}

if ($_REQUEST['pName']!="") {
	$where .= " and pName like '%{$_REQUEST['pName']}%'";
	$page_where .= "pName={$_REQUEST['pName']}&";
}
if ($_REQUEST['pNum']!="") {
	$where .= " and pNum like '%{$_REQUEST['pNum']}%'";
	$page_where .= "pNum={$_REQUEST['pNum']}&";
}
//得到数据库中所有商品
$sql = "select p.id,p.pName,p.pNum,p.rePNum,p.price,pAbstract,p.pDesc,p.pStandard,p.pubTime,p.pShow,p.pRecommend,
        bi.big_cName,s.small_cName,br.bra_cName from product as p 
		join big_cate bi on p.big_cId=bi.id 
		join small_cate s on p.small_cId=s.id
        join brand_cate br on p.bra_cId=br.id where 1 {$where}";
$totalRows=getResultNum($sql);
$pageSize=8;
$totalPage=ceil($totalRows/$pageSize);
$page = $_REQUEST['page']?(int)$_REQUEST['page']:1;
if($page<1||$page==null||!is_numeric($page))$page=1;
if($page>=$totalPage)$page=$totalPage;
$offset=($page-1)*$pageSize;
$sql = "select p.id,p.pName,p.pNum,p.rePNum,p.price,pAbstract,p.pDesc,p.pStandard,p.pubTime,p.pShow,p.pRecommend,
        bi.big_cName,s.small_cName,br.bra_cName from product as p 
		join big_cate bi on p.big_cId=bi.id 
		join small_cate s on p.small_cId=s.id
        join brand_cate br on p.bra_cId=br.id where 1 {$where} limit {$offset},{$pageSize}";
$rows=fetchAll($sql);

$isRec = array(
	0=>(array('value'=>'','name'=>'-请选择-')),
	1=>(array('value'=>'1','name'=>'是')),
	2=>(array('value'=>'0','name'=>'否')),	
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
					onclick="addPro()">
			</div>
			
			<div class="fr">
				<div class="text">
					<span>是否展示：</span>
					<div class="bui_select">
						<select name="isShow" id="isShow" class="select">
						<?php foreach ($isRec as $_isRec):?>
							<option value="<?php echo $_isRec['value'];?>" <?php echo $_isRec['value']==$_REQUEST['isShow']?"selected='selected'":null;?>><?php echo $_isRec['name'];?></option>
						<?php endforeach;?>
						</select>
					</div>
				</div>
				<div class="text">
					<span>是否推荐：</span>
					<div class="bui_select">
						<select name="isRecommend" id="isRecommend" class="select">
						<?php foreach ($isRec as $_isRec):?>
							<option value="<?php echo $_isRec['value'];?>" <?php echo $_isRec['value']==$_REQUEST['isRecommend']?"selected='selected'":null;?>><?php echo $_isRec['name'];?></option>
						<?php endforeach;?>
						</select>
					</div>
				</div>
				<div class="text">
					<span>商品名称</span> 
					<input type="text" value="<?php echo $_REQUEST['pName'];?>" class="search" id="pName">
				</div>
				<div class="text">
					<span>商品统称</span> 
					<input type="text" value="<?php echo $_REQUEST['pNum'];?>" class="search" id="pNum">
				</div>
				<div class="fr"><input type="button" value="搜索" class="btn" onclick="search()"> </div>
			</div>
			
		</div>
		<!--表格-->
		<table class="table" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<th width="7%">编号</th>
					<th width="20%">商品中文名称</th>
					<th width="10%">商品统称</th>
					<th width="15%">商品大类</th>
					<th width="10%">商品小类</th>
					<th width="10%">商品品牌</th>
					<th width="10%">上架时间</th>
					<th width="7%">展示编号</th>
					<th width="7%">推荐编号</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
                <?php foreach($rows as $row):?>
                <tr>
					<!--这里的id和for里面的c1 需要循环出来-->
					<td><input type="checkbox" id="c1" class="check" value=<?php echo $row['id'];?>><label for="c1" class="label"><?php echo $row['id'];?></label></td>
					<td><?php echo $row['pName']; ?></td>
					<td><?php echo $row['pNum'];?></td>
					<td><?php echo $row['big_cName']; ?></td>
					<td><?php echo $row['small_cName'];?></td>
					<td><?php echo $row['bra_cName'];?></td>
					<td><?php echo date("Y-m-d H:i:s",$row['pubTime'])?></td>
					<td><?php echo $row['pShow']?></td>
                    <td><?php echo $row['pRecommend'];?></td>
                    
					<td align="center">
						<input type="button" value="详情" class="btn" onclick="showDetail(<?php echo $row['id'];?>,'<?php echo $row['pName'];?>')">
						<input type="button" value="修改" class="btn" onclick="editPro(<?php echo $row['id'];?>)">
						<input type="button" value="删除" class="btn" onclick="delPro(<?php echo $row['id'];?>)">
						<div id="showDetail<?php echo $row['id'];?>" style="display: none;">
							<table class="table" cellspacing="0" cellpadding="0">
								<tr>
									<td width="20%" align="right">商品中文名称</td>
									<td><?php echo $row['pName'];?></td>
								</tr>
								<tr>
									<td width="20%" align="right">商品统称</td>
									<td><?php echo $row['pNum'];?></td>
								</tr>
								<tr>
									<td width="20%" align="right">商品型号/料号</td>
									<td>
									<ul>
										<?php $model = getModelsByPid($row['id']);
										foreach ($model as $_model):?>
										<li>型号：<?php echo $_model['model']?> &nbsp;&nbsp;&nbsp; 料号：<?php echo $_model['partNum'];?></li>
										<?php endforeach;?>
									</ul>	 
									</td>
								</tr>
								<tr>
									<td width="20%" align="right">商品大类</td>
									<td><?php echo $row['big_cName'];?></td>
								</tr>
								<tr>
									<td width="20%" align="right">商品小类</td>
									<td><?php echo $row['small_cName'];?></td>
								</tr>
								<tr>
									<td width="20%" align="right">商品品牌</td>
									<td><?php echo $row['bra_cName'];?></td>
								</tr>
								<tr>
									<td width="20%" align="right">商品图片</td>
									<td>
                        				<?php 
                        				$images=getImgsByProId($row['id']);
                        				foreach($images as $img){
                        					echo "<img src='uploads/image_50/{$img['albumPath']}' alt=''/>&nbsp;";
                        				}
                        				?>
			                        </td>
								</tr>
													
                    
								<tr>
									<td width="20%" align="right">展示编号</td>
									<td><?php echo $row['pShow']?></td>
								</tr>
								<tr>
									<td width="20%" align="right">推荐编号</td>
									<td><?php echo $row['pRecommend'];?></td>
								</tr>
							</table>
							<span style="display: block; width: 80%;font-size:12px;border-bottom:2px solid #fb874d;"> <h3>商品简介</h3>
			                	<?php echo $row['pAbstract'];?>
			                </span>
							<span style="display: block; width: 80%;font-size:12px;border-bottom:2px solid #fb874d;"> <h3>商品描述</h3>
			                	<?php echo $row['pDesc'];?>
			                </span>
			                <span style="display: block; width: 80%;font-size:12px;"> <h3>商品规格</h3>
			                	<?php echo $row['pStandard'];?>
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
	      title:"商品名称："+t,//对话框标题
	      show:"slide",
	      hide:"explode"
	});
}

function addPro(){
	window.location='addPro.php';
}

function editPro(id){
	window.location='editPro.php?id='+id;
}

function delPro(id){
	if(window.confirm("您确认要删除吗？添加一次不容易")){
		window.location='doAdminAction.php?act=delPro&id='+id;
	}
}
function search(){
	var isRecommend=document.getElementById("isRecommend").value;
	var isShow=document.getElementById("isShow").value;
	var pName=document.getElementById("pName").value;
	var pNum=document.getElementById("pNum").value;
	window.location="listPro.php?isRecommend="+isRecommend+"&isShow="+isShow+
					"&pName="+pName+"&pNum="+pNum;
}
</script>
</body>
</html>