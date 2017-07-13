<?php 
require_once 'include.php';

$sql1 = "select * from conference where actClass=0 {$where}";
$totalRows1=getResultNum($sql1);
$pageSize1=5;
$totalPage1=ceil($totalRows1/$pageSize1);
$page1 = $_REQUEST['page1']?(int)$_REQUEST['page1']:1;
if($page1<1||$page1==null||!is_numeric($page1))$page1=1;
if($page1>=$totalPage1)$page1=$totalPage1;
$offset1=($page1-1)*$pageSize1;

$sql11="select * from conference where actClass=0 {$where}  order by startDate desc limit {$offset1},{$pageSize1}";
$yanth = fetchAll($sql11);
// var_dump($sql11);
// var_dump($yanth);

$sql2 = "select * from conference where actClass=1 {$where}";
$totalRows2=getResultNum($sql2);
$pageSize2=5;
$totalPage2=ceil($totalRows2/$pageSize2);
$page2 = $_REQUEST['page']?(int)$_REQUEST['page']:1;
if($page2<1||$page2==null||!is_numeric($page2))$page2=1;
if($page2>=$totalPage2)$page2=$totalPage2;
$offset2=($page2-1)*$pageSize2;

$sql22="select * from conference where actClass=1 {$where} order by startDate desc limit {$offset2},{$pageSize2}";
$zhanh = fetchAll($sql22);
?>
<!doctype html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="utf-8">
<title>研鼎-市场活动</title>
<link type="text/css" rel="stylesheet" href="styles/reset.css">
<link type="text/css" rel="stylesheet" href="styles/main.css">
<script type="text/javascript" src="scripts/search.js"></script>
</head>
<body>
	<?php include 'head.php';?>
	<div class="market_list_top"></div>
	<div class="after_list_content" style="overflow: hidden">
		<div class="after_list_left">
			<div class="elf_top" style="position:absolute;">
				<img alt="" src="images/service/market_ltop.png" style="position:absolute;z-index:9000;">
			</div>
			<div class="lafter_menu">
				<ul id="emp_menu">
					<li class="elf_center check" onclick="thisMenu(0)">展会</li>
					<li class="elf_center" onclick="thisMenu(1)">研讨会</li>
				</ul>
			</div>
			<div class="lafter_bottom">
				<img alt="" src="images/news/news_lbottom.png">
			</div>
		</div>
		<div class="after_list_right">
			<div class="emp_list_title" style="margin-bottom: 0">
				<a href="index.php"><img alt="" src="images/news/news_rtop.png"></a>
				<a href="serviceList.php"><span style="width: 115px;">&gt;&gt;&nbsp;我们的服务</span></a>
				<span class="person_emp" id="span0" style="width:170px;">&gt;&gt;&nbsp;市场活动-展会</span>
				<span class="person_idea" id="span1" style="display:none;width:170px;">&gt;&gt;&nbsp;市场活动-研讨会</span>
			</div>
			
			<div class="market_process" id="emp0">
				<ul>
				<?php foreach ($zhanh as $_zhanh):?>
					<li>
						<a href="marketItem.php?id=<?php echo $_zhanh['id'];?>">
							<?php if ($_zhanh['endDate']>time()):?>
							<div class="zjsj_pre"><span>预 告</span></div>
							<?php else :?>
							<div class="zjsj_end"><span style="top:-30px;left:-20px;">已结束</span></div>
							<?php endif;?>
							<div class="market_content_img">
								<img alt="" src="admin/market/<?php echo $_zhanh['image'];?>">
							</div>
							<div class="market_content">
								<h3><?php echo $_zhanh['title'];?></h3>
								<p>开始时间：<?php echo date("Y-m-d H:i:s",$_zhanh['startDate']);?></p>
								<p>地点：<?php echo $_zhanh['address'];?></p>
								<p>主办单位：<?php echo $_zhanh['host'];?></p>
							</div>
						</a>
					</li>
				<?php endforeach;?>
				<?php if($totalRows2>$pageSize2):?>
		        	<div class="news_page">
		        		<?php echo newsPage($page2, $totalPage2);?>
		        	</div>
		       		 <?php endif;?>
				</ul>
			</div>
			
			<div class="market_process" id="emp1"  style="display:none">
				<ul>
				<?php foreach ($yanth as $_yanth):?>
					<li>
						<a href="marketItem.php?id=<?php echo $_yanth['id'];?>&type=yanth">
							<?php if ($_yanth['endDate']>time()):?>
							<div class="zjsj_pre"><span>预 告</span></div>
							<?php else :?>
							<div class="zjsj_end"><span style="top:-30px;left:-20px;">已结束</span></div>
							<?php endif;?>
							<div class="market_content_img">
								<img alt="" src="admin/market/<?php echo $_yanth['image'];?>">
							</div>
							<div class="market_content">
								<h3><?php echo $_yanth['title'];?></h3>
								<p>开始时间：<?php echo date("Y-m-d H:i:s",$_yanth['startDate']);?></p>
								<p>地点：<?php echo $_yanth['address'];?></p>
								<p>主办单位：<?php echo $_yanth['host'];?></p>
							</div>
						</a>
					</li>
				<?php endforeach;?>
				<?php if($totalRows1>$pageSize1):?>
		        	<div class="news_page">
		        		<?php echo marketPage($page1, $totalPage1,'yanth');?>
		        	</div>
		       		 <?php endif;?>
				</ul>
			</div>
		</div>
	</div>
	<?php include 'bottom.php';?>
	
<script type="text/javascript">
window.onload = function (){
	type = <?php echo $_REQUEST['type']=="yanth"?1:0;?>;
	if(type){
		thisMenu(1);
	}
}
//点击左侧菜单
function thisMenu(id){
    var thisMenu = document.getElementById("emp_menu").getElementsByTagName("li");
    for(i=0;i<thisMenu.length;i++){
        if(i==id){
        	thisMenu[i].style.color="#333333";
        	thisMenu[i].style.borderRight="3px solid #4ba0fa";
        }
        else{
        	thisMenu[i].style.color="#808080";
        	thisMenu[i].style.borderRight="none";
        }

		var empInfo = document.getElementById('emp' + (i));
		empInfo.style.display = 'none';

		var spanInfo = document.getElementById('span' + (i));
		spanInfo.style.display = 'none';
    }
	var div = document.getElementById('emp' + id);
	div.style.display = 'block';
	var span = document.getElementById('span' + id);
	span.style.display = 'block';
}
</script>
</body>
</html>