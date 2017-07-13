<?php 
require_once 'include.php';
checkBrowser();
$tech = getOneTech($_REQUEST['id']);

//点击量+1
update("technical_article", array("view_times"=>$tech['view_times']+1),"id={$_REQUEST['id']}");

$techFile = fetchAll("select f.filePath from file f join download d on f.did=d.id where d.down_cate=2 and d.tech_title='{$tech['title']}'");
?>
<!doctype html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="utf-8">
<title>研鼎-技术文章与白皮书详情</title>
<link type="text/css" rel="stylesheet" href="styles/reset.css">
<link type="text/css" rel="stylesheet" href="styles/main.css">
<script type="text/javascript" src="scripts/jquery-2.1.1.js"></script>
<script type="text/javascript" src="scripts/search.js"></script>
</head>
<body>
	<?php include 'head.php';?>
	<div class="tech_list_top"></div>
	<div class="tech_item_index">
		<a href="index.php"><img alt="" src="images/news/news_rtop.png"></a>
		<a href="serviceList.php"><span>&gt;&gt;&nbsp;&nbsp;我们的服务</span></a>
		<a href="technicalList.php"><span>&gt;&gt;&nbsp;&nbsp;技术文章与白皮书</span></a>
		<span>&gt;&gt;&nbsp;&nbsp;<?php echo $tech['title'];?></span>
	</div>
	<div class="tech_item_content">
		<h3><?php echo $tech['title'];?></h3>
		<div class="tech_item_title">
			<div class="tech_item_desc">
				<span>最后更新时间：<?php echo date("Y-m-d",$tech['last_changed']);?></span>
				<span>作者：外滩强哥</span>
				<a href="technicalList.php">【返回列表】</a>
			</div>
			<div class="view_times">阅读次数：<?php echo $tech['view_times'];?>次</div>
		</div>
		<div class="tech_item_con">
			<?php echo $tech['content'];?>
		</div>
		<div class="tech_item_down">
			<ul style="overflow: hidden;">
				<?php foreach ($techFile as $file):?>
				<li><?php echo explode(".",$file['filePath'])[0];?><a href="download.php?filename=<?php echo $file['filePath'];?>">&nbsp;&nbsp;&nbsp;下载</a></li>
				<?php endforeach;?>
			</ul>
		</div>
		<div class="tech_item_back" id="tech_item_back">
			<a href="#"></a>
		</div>
	</div>
	<?php include 'bottom.php';?>
<script type="text/javascript">

$(document).ready(function(){
	var osTop = document.documentElement.scrollTop || document.body.scrollTop;
	$("#tech_item_back").hide();
	$(function () {
		$(window).scroll(function(){
			if ($(window).scrollTop()>100){
				$("#tech_item_back").fadeIn(500);
			}
			else{
				$("#tech_item_back").fadeOut(500);
			}
		});

		$("#tech_item_back").click(function(){
			$('body,html').animate({scrollTop:0},100);
			return false;
		});
	});
});

</script>
</body>
</html>