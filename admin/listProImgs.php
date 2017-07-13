<?php
require_once '../include.php';
checkLogined();

$where = $page_where = "";
if ($_REQUEST['pName']!="") {
	$where .= " and pName like '%{$_REQUEST['pName']}%'";
	$page_where .= "pName={$_REQUEST['pName']}";
}
//得到数据库中所有商品
$sql = "select id,pName from product where 1 {$where}";
$totalRows=getResultNum($sql);
$pageSize=8;
$totalPage=ceil($totalRows/$pageSize);
$page = $_REQUEST['page']?(int)$_REQUEST['page']:1;
if($page<1||$page==null||!is_numeric($page))$page=1;
if($page>=$totalPage)$page=$totalPage;
$offset=($page-1)*$pageSize;

$sql = "select id,pName from product where 1 {$where} order by id asc limit {$offset},{$pageSize}";
$rows=fetchAll($sql);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>-.-</title>
<link rel="stylesheet" href="styles/backstage.css">
</head>

<body>

	<div class="details">
		<div class="details_operation clearfix">
			<div class="fr">
				<div class="text">
					<span>商品名称</span> 
					<input type="text" value="<?php echo $_REQUEST['pName'];?>" class="search" id="pName">
				</div>
				<div class="fr"><input type="button" value="搜索" class="btn" onclick="search()"> </div>
			</div>
		</div>
		<!--表格-->
		<table class="table" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<th width="10%">编号</th>
					<th width="20%">商品名称</th>
					<th>商品图片</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
            	<?php foreach($rows as $row):?>
            	<tr>
					<!--这里的id和for里面的c1 需要循环出来-->
					<td>
						<input type="checkbox" id="c<?php echo $row['id'];?>" class="check" value=<?php echo $row['id'];?>>
						<label for="c1" class="label"><?php echo $row['id'];?></label>
					</td>

					<td><?php echo $row['pName']; ?></td>
					<td>
	                    <?php
		                    $proImgs = getImgsByProId ( $row ['id'] );
		                    foreach ( $proImgs as $img ) :
	                    ?>
                        <img style="max-height:70px;max-width:70px;" src="uploads/<?php echo $img['albumPath'];?>" alt="" /> &nbsp;&nbsp;
                        <?php endforeach;?>
             		</td>
					<td>
						<input type="button" value="修改" class="btn" onclick="editProImgs(<?php echo $row['id'];?>)">
					</td>
				</tr>
                <?php  endforeach;?>
                <?php if($totalRows>$pageSize):?>
                <tr>
                     <td colspan="5"><?php echo showPage($page, $totalPage,$page_where);?></td>
                </tr>
                <?php endif;?> 
			</tbody>
		</table>
	</div>
	
	<script type="text/javascript">
		function editProImgs(id){
			window.location='editProImgs.php?id='+id;
		}
		function search(){
			var pName=document.getElementById("pName").value;
			window.location="listProImgs.php?pName="+pName;
		}
 	</script>
</body>
</html>