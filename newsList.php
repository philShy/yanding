<?php 
require_once 'include.php';
checkBrowser();
//得到数据库中所有新闻
$sql = "select * from news";
$totalRows=getResultNum($sql);
$pageSize=4;
$totalPage=ceil($totalRows/$pageSize);
$page = $_REQUEST['page']?(int)$_REQUEST['page']:1;
if($page<1||$page==null||!is_numeric($page))$page=1;
if($page>=$totalPage)$page=$totalPage;
$offset=($page-1)*$pageSize;
$sql = "select * from news order by last_changed desc";
$rows1=fetchAll($sql);
if ($rows1) {
	foreach ($rows1 as $row1){
		if (strlen($row1['title']) > 15){
			$row1['abstract_title'] = msubstr($row1['title'],0,15);
		}
		$rows[] = $row1;
	}
}
$sql2="select * from news order by last_changed desc limit {$offset},{$pageSize}";
$newsInfo2 = fetchAll($sql2);
if ($newsInfo2) {
	foreach ($newsInfo2 as $news){
		if (strlen($news['abstract_content']) > 200){
			$news['abstract_content'] = msubstr($news['abstract_content'],0,200) .'...';
		}
		$rows2[] = $news;
	}
}

?>
<!doctype html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="utf-8">
<title>研鼎-新闻</title>
<link type="text/css" rel="stylesheet" href="styles/reset.css">
<link type="text/css" rel="stylesheet" href="styles/main.css">
<script type="text/javascript" src="scripts/jquery-2.1.1.js"></script>
<script type="text/javascript" src="scripts/search.js"></script>
</head>
<body>
	<?php include 'head.php';?>

	<div class="news_list_top"></div>
	<div class="news_list_content" style="overflow:hidden;">
		<div class="news_list_left">
			<div class="nlf_top"  style="position:absolute;">
				<img alt="" src="images/news/news_ltop.png" style="position:absolute;z-index:999;">
			</div>
			<div class="nlf_center"><span>公司新闻</span></div>
			<div class="nlf_bottom">
				<img alt="" src="images/news/news_lbottom.png">
			</div>
		</div>
		<div class="news_list_right">
			<div class="news_list_title">
				<a href="index.php"><img alt="" src="images/news/news_rtop.png"></a>
				<a href="newsList.php"><span>&gt;&gt;&nbsp;&nbsp;公司新闻</span></a>
			</div>
			
			<div class="news_list_bimg">
				<ul>
				<?php for ($i=0;$i<3;$i++):?>
					<li class="news_list_item">
						<a class="news_list_link" href="newsItem.php?id=<?php echo $rows[$i]['id'];?>">
							<img src="admin/news/<?php echo $rows[$i]['image1']?>">
							<div class="news_list_banner"></div>
							<div class="news_hover">
								<div><?php echo $rows[$i]['abstract_title'];?></div>
								<div class="news_hover_more">查看详情</div>
							</div>
						</a>
					</li>
				<?php endfor;?>
				</ul>
			</div>
			
			<div class="news_list">
				<ul>
					<?php foreach ($rows2 as $row):?>
					<li>
						<a href="newsItem.php?id=<?php echo $row['id'];?>">
							<h3><?php echo $row['title'];?></h3>
							<div class="news_list_abstract"> 
								<img alt="" src="admin/news/<?php echo $row['image1'];?>">
								<div class="abstract_content"><?php echo $row['abstract_content']?></div>
								<div class="abstract_time"><?php echo date('Y-m-d',$row['last_changed']);?></div>
							</div>
						</a>
					</li>
					<?php endforeach;?>
					<?php if($totalRows>$pageSize):?>
		        	<div class="news_page">
		        		<?php echo newsPage($page, $totalPage);?>
		        	</div>
		       		 <?php endif;?>  
				</ul>
			</div>
		</div>
	</div>
	<?php include 'bottom.php';?>
<script type="text/javascript">
	$(function(){
		for(var i=0;i<3;i++){
			if(i%3==2){
				$(".news_list_item").eq(i).css("margin-right","0");
			}
		}
	})
</script>
</body>
</html>