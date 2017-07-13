<?php 
require_once 'include.php';
//得到数据详情
$id = $_REQUEST['id'];
$news = getOneNews($id);

//点击量+1
update("news", array("view_times"=>$news['view_times']+1),"id={$id}");

$newsAll = fetchAll("select id,author,title,content,last_changed from news order by last_changed");
for ($i=0;$i<count($newsAll);$i++){
	if ($id == $newsAll[$i]['id']) {
		if ($i==0) {
			$prev['href']="";
			$prev['content']="当前是第一篇";
			$next['href']="newsItem.php?id={$newsAll[$i+1]['id']}";
			$next['content']="{$newsAll[$i+1]['title']}";
		}elseif ($i == count($newsAll)-1){
			$prev['href']="newsItem.php?id={$newsAll[$i-1]['id']}";
			$prev['content']="{$newsAll[$i-1]['title']}";
			$next['href']="";
			$next['content']="当前是最后一篇";
		}else {
			$prev['href']="newsItem.php?id={$newsAll[$i-1]['id']}";
			$prev['content']="{$newsAll[$i-1]['title']}";
			$next['href']="newsItem.php?id={$newsAll[$i+1]['id']}";
			$next['content']="{$newsAll[$i+1]['title']}";
		}
		
	}
}

?>
<!doctype html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="utf-8">
<title>研鼎-新闻详情</title>
<link type="text/css" rel="stylesheet" href="styles/reset.css">
<link type="text/css" rel="stylesheet" href="styles/main.css">
<script type="text/javascript" src="scripts/search.js"></script>
</head>
<body>
	<?php include 'head.php';?>
	<div class="news_list_top"></div>
	<div class="news_list_content" style="overflow:hidden">
		<div class="news_list_left">
			<div class="nlf_top" style="position:absolute;">
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
				<span style="margin-left: 135px;width:790px;margin-top:-60px;">&nbsp;&nbsp;&gt;&gt;&nbsp;&nbsp;<?php echo $news['title'];?></span>
			</div>
			
			<div class="news_item">
				<div class="news_item_title"><?php echo $news['title'];?></div>
				<div class="news_item_desc">
					<?php echo date('Y-m-d',$news['last_changed']);?>&nbsp;&nbsp;
					发布人：<?php echo $news['author'];?>&nbsp;&nbsp;
					阅读次数：<?php echo $news['view_times'];?>次&nbsp;&nbsp;
					<a href="newsList.php">返回列表</a>
				</div>
				<div class="news_item_content">
					<?php echo $news['content'];?>
				</div>
			</div>
			
			<div class="news_item_nav">
				<div class="news_item_prev">上一篇：<a href="<?php echo $prev['href'];?>"><?php echo $prev['content'];?></a></div>
				<div class="news_item_next">下一篇：<a href="<?php echo $next['href'];?>"><?php echo $next['content'];?></a></div>
			</div>
			
		</div>
	</div>
	<?php include 'bottom.php';?>
</body>
</html>