<?php 
require_once 'include.php';
$maInfo = getMarketById($_REQUEST['id']);

//点击量+1
update("conference", array("view_times"=>$maInfo['view_times']+1),"id={$_REQUEST['id']}");
?>
<!doctype html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="utf-8">
<title>研鼎-市场活动详情</title>
<link type="text/css" rel="stylesheet" href="styles/reset.css">
<link type="text/css" rel="stylesheet" href="styles/main.css">
<script type="text/javascript" src="scripts/search.js"></script>
</head>
<body>
	<?php include 'head.php';?>
	<div class="tech_list_top"></div>
	<div class="tech_item_index">
		<a href="index.php"><img alt="" src="images/news/news_rtop.png"></a>
		<a href="serviceList.php"><span>&gt;&gt;&nbsp;&nbsp;我们的服务</span></a>
		<?php if ($_REQUEST['type']=="yanth") :?>
			<a href="marketAct.php?type=yanth"><span>&gt;&gt;&nbsp;&nbsp;市场活动-研讨会</span></a>
		<?php else :?>
			<a href="marketAct.php"><span>&gt;&gt;&nbsp;&nbsp;市场活动-展会</span></a>
		<?php endif;?>
		<span>&gt;&gt;&nbsp;&nbsp;<?php echo $maInfo['title'];?></span>
	</div>
	<div class="market_item_content">
		<h3><?php echo $maInfo['title'];?></h3>
		<div class="market_item_title">
			阅读人次：<?php echo $maInfo['view_times']?>次&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="marketAct.php<?php echo $_REQUEST['type']=='yanth'?'?type=yanth':'';?>">【返回列表】</a>
		</div>
		<div class="market_item_con">
			<div class="market_item_basic">
				<h4>>基本信息</h4>
				<table>
					<tr>
						<td>活动名称：</td>
						<td><?php echo $maInfo['title']?></td>
					</tr>
					<tr>
						<td>开始时间：</td>
						<td><?php echo date("Y-m-d H:i:s",$maInfo['startDate'])?></td>
					</tr>
					<tr>
						<td>结束时间：</td>
						<td><?php echo date("Y-m-d H:i:s",$maInfo['endDate']);?></td>
					</tr>
					<tr>
						<td>活动地点：</td>
						<td><?php echo $maInfo['address'];?></td>
					</tr>
					<tr>
						<td>主办单位:</td>
						<td><?php echo $maInfo['host'];?></td>
					</tr>
				</table>
			</div>
			<div class="market_item_contact">
				<h4>>联系人</h4>
				<table>
					<tr>
						<td>联系人：</td>
						<td><?php echo $maInfo['person'];?></td>
					</tr>
					<tr>
						<td>联系电话：</td>
						<td><?php echo $maInfo['phone'];?></td>
					</tr>
					<tr>
						<td>联系邮箱：</td>
						<td><?php echo $maInfo['email'];?></td>
					</tr>
				</table>
			</div>
			
			<div class="market_item_detail">
				<h4>>活动详情</h4>
				<div><?php echo $maInfo['detail']?></div>
			</div>
			
			<div class="market_item_agenda">
				<h4>>活动议程</h4>
				<div><?php echo $maInfo['agenda']?></div>
			</div>
			
			
		</div>
		
	</div>
	<?php include 'bottom.php';?>

</body>
</html>