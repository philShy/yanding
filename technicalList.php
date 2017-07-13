<?php 
require_once 'include.php';
//得到数据库中所有技术文章

$search = $_REQUEST['search'];

$where = $page_where = "";
if ($search!="") {
	$where .= " and title like '%{$search}%'";
	$page_where .= "search={$search}";
}

$sql = "select * from technical_article where 1 {$where}";
$totalRows=getResultNum($sql);
$pageSize=5;
$totalPage=ceil($totalRows/$pageSize);
$page = $_REQUEST['page']?(int)$_REQUEST['page']:1;
if($page<1||$page==null||!is_numeric($page))$page=1;
if($page>=$totalPage)$page=$totalPage;
$offset=($page-1)*$pageSize;

$sql2="select * from technical_article where 1 {$where} limit {$offset},{$pageSize}";
$rows2 = fetchAll($sql2);
?>
<!doctype html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="utf-8">
<title>研鼎-技术文章与白皮书</title>
<link type="text/css" rel="stylesheet" href="styles/reset.css">
<link type="text/css" rel="stylesheet" href="styles/main.css">
<script type="text/javascript" src="scripts/search.js"></script>
</head>
<body>
	<?php include 'head.php';?>
	<div class="tech_list_top"></div>
	<div class="tech_list_content">
		<div class="tech_list_left">
			<div class="clf_top">
				<img alt="" src="images/service/technical_ltop.png">
			</div>
			<div class="clf_center"><span>技术文章与白皮书</span></div>
			<div class="clf_bottom" style="height:400px;"><img alt="" src="images/news/news_lbottom.png"></div>
		</div>
		<div class="tech_list_right">
			<div class="tech_list_title">
				<a href="index.php"><img alt="" src="images/news/news_rtop.png"></a>
				<a href="serviceList.php"><span>&gt;&gt;&nbsp;&nbsp;我们的服务</span></a>
				<span style="margin-left: 160px;width:180px;margin-top:-60px;">&gt;&gt;&nbsp;&nbsp;技术文章与白皮书</span>
				<form target="_blank" method="get" action="technicalList.php">
					<input maxlength="20" size="15" name="search" placeholder="请输入关键字" value="<?php echo $search;?>" class="techLis_search_text">
					<input type="submit" value="" class="techLis_submit">
				</form>
			</div>
			
			<div class="tech_list">
				<ul>
					<?php foreach ($rows2 as $row):?>
					<li>
						<a href="technicalItem.php?id=<?php echo $row['id'];?>"><img alt="" src="admin/tech/<?php echo $row['image'];?>"></a>
						<div class="tech_list_abstract"> 
							<a href="technicalItem.php?id=<?php echo $row['id'];?>"><h3><?php echo $row['title'];?></h3></a>
							<div class="abstract_content"><?php echo mb_substr($row['abstract_content'],0,130);?></div>
						</div>
					</li>
					<?php endforeach;?>
					<?php if($totalRows>$pageSize):?>
		        	<div class="news_page">
		        		<?php echo newsPage($page, $totalPage,$page_where);?>
		        	</div>
		       		 <?php endif;?>  
				</ul>
			</div>
		</div>
	</div>
	<?php include 'bottom.php';?>
</body>
</html>