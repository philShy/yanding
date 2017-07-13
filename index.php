<?php 
require_once 'include.php';
checkBrowser();
//得到数据库中所有商品
$sql = "select p.id,p.pName,p.pNum,p.rePNum,p.price,p.pDesc,p.pStandard,p.pubTime,p.pShow,p.pRecommend,
        bi.big_cName,s.small_cName,br.bra_cName from product as p 
		join big_cate bi on p.big_cId=bi.id 
		join small_cate s on p.small_cId=s.id
        join brand_cate br on p.bra_cId=br.id 
		where p.pRecommend>0";
$rows=fetchAll($sql);

$newsInfo1 = fetchAll("select id,title,last_changed,abstract_content,image1 from news order by last_changed desc");
if ($newsInfo1) {
	foreach ($newsInfo1 as $news){
		if (strlen($news['abstract_content']) > 35){
			 $news['abstract_content'] = msubstr($news['abstract_content'],0,35) .'...';
		}
		if (strlen($news['title']) > 18){
			$news['title'] = msubstr($news['title'],0,18);
		}
		$newsInfo[] = $news;
	}
}

$show = fetchAll("select p.id,p.pName,p.pNum,br.bra_cName from product p join brand_cate br on p.bra_cId=br.id where p.pShow>0 order by p.pShow asc");

//得到数据库中所有商品大分类
$bigCates = getAllBigCate();
?>
<!doctype html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="utf-8">
<title>上海研鼎信息技术有限公司</title>
<link type="text/css" rel="stylesheet" href="styles/reset.css">
<link type="text/css" rel="stylesheet" href="styles/main.css">
<script type="text/javascript" src="scripts/jquery-2.1.1.js"></script>
<script type="text/javascript" src="scripts/slider.js"></script>
<script type="text/javascript" src="scripts/common.js"></script>
<script type="text/javascript" src="scripts/search.js"></script>
</head>

<body>
	<?php include 'head.php';?>
	<div id="banner_tabs" class="flexslider">
		<ul class="slides">
			<li>
				<a title="" href="productClassify.php?big_cId=38"> <img alt="" src="images/38.png"></a>
			</li>
			<li>
				<a title="" href="productClassify.php?big_cId=39"> <img alt="" src="images/39.png"></a>
			</li>
			<li>
				<a title="" href="productClassify.php?big_cId=41"> <img alt="" src="images/41.png"></a>
			</li>
			<li>
				<a title="" href="productClassify.php?big_cId=43"> <img alt="" src="images/43.png"></a>
			</li>
		</ul>
		<ul class="flex-direction-nav">
			<li><a class="flex-prev" href="javascript:;">Previous</a></li>
			<li><a class="flex-next" href="javascript:;">Next</a></li>
		</ul>
		<ol id="bannerCtrl" class="flex-control-nav flex-control-paging">
			<li><a>1</a></li>
			<li><a>2</a></li>
			<li><a>3</a></li>
			<li><a>4</a></li>
		</ol>
	</div>

	<div class="third_part">
		<div class="index_news">
			<div class="index_news_title">
				<span class="english_title">最新资讯/</span> <span class="chi_title">NEWS</span>
			</div>
			<div>
				<span class="index_news_more"><a href="newsList.php">More&gt;&gt;</a></span>
			</div>
			<div class="index_news_content">
				<ul style="margin-bottom: 14px;">
					<li class="first_news_small" style="margin-right: 10px;">
						<a href="newsItem.php?id=<?php echo $newsInfo['0']['id'];?>">
							<img alt="" src="admin/news/<?php echo $newsInfo['0']['image1'];?>">
							<div class="first_newsBanner">
								<div class="first_news_banner"></div>
								<div class="news_title first_news_title">
									<?php echo $newsInfo[0]['title'];?><br> 
									<?php echo date('Y-m-d',$newsInfo[0]['last_changed']);?>
								</div>
								<div class="news_content first_news_content">
									<?php echo $newsInfo[0]['abstract_content'];?>
								</div>
							</div>
						</a>
					</li>
					<li class="second_news_small">
						<a href="newsItem.php?id=<?php echo $newsInfo['1']['id'];?>">
							<img alt="" src="admin/news/<?php echo $newsInfo['1']['image1'];?>">
							<div class="second_newsBanner">
								<div class="second_news_banner"></div>
								<div class="news_title second_news_title">
									<?php echo $newsInfo[1]['title'];?><br>
									<?php echo date('Y-m-d',$newsInfo[1]['last_changed']);?>
								</div>
								<div class="news_content second_news_content">
									<?php echo $newsInfo[1]['abstract_content'];?>
								</div>
							<div class="first_newsBanner">
						</a>
					</li>
				</ul>
				<ul>
					<li class="second_news_small" style="margin-right: 10px;">
						<a href="newsItem.php?id=<?php echo $newsInfo['2']['id'];?>">
							<img alt="" src="admin/news/<?php echo $newsInfo['2']['image1'];?>">
							<div class="second_newsBanner">
								<div class="second_news_banner"></div>
								<div class="news_title second_news_title">
									<?php echo $newsInfo[2]['title'];?><br>
									<?php echo date('Y-m-d',$newsInfo[2]['last_changed']);?>
								</div>
								<div class="news_content second_news_content">
									<?php echo $newsInfo[2]['abstract_content'];?>
								</div>
							<div class="first_newsBanner">
						</a>
					</li>
					<li class="first_news_small">
						<a href="newsItem.php?id=<?php echo $newsInfo['3']['id'];?>">
							<img alt="" src="admin/news/<?php echo $newsInfo['3']['image1'];?>">
							<div class="first_newsBanner">
								<div class="first_news_banner"></div>
								<div class="news_title first_news_title">
									<?php echo $newsInfo[3]['title'];?><br>
									<?php echo date('Y-m-d',$newsInfo[3]['last_changed']);?>
								</div>
								<div class="news_content first_news_content">
									<?php echo $newsInfo[3]['abstract_content'];?>
								</div>
							<div class="first_newsBanner">
						</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="index_big_product">
			<div class="first_big_pro">
				<div class="index_pro_title">产品展示</div>
				<div>
					<span class="index_pro_more1"><a href="productList.php">More&gt;&gt;</a></span>
				</div>
				<div class="indexPro">
					<div class="index_pro_detail">
						<div class="index_pro_name"  style="margin-top: 20px;">
							<h3>商品名称</h3>
							<div><?php echo $show[0]['pName'];?></div>
						</div>
						<div class="index_pro_firm">
							<h3>商品厂商</h3>
							<div><?php echo $show[0]['bra_cName']?></div>
						</div>
						<div class="index_pro_version">
							<h3>商品统称</h3>
							<div><?php echo $show[0]['pNum'];?></div>
						</div>
						<div class="index_pro_more">
							<a href="proDetails.php?id=<?php echo $show[0]['id'];?>">详&nbsp;情</a>
						</div>
					</div>
					<div class="index_big_img">
						<?php $img=getProImgById($show[0]['id']);?>
						<span><a href="proDetails.php?id=<?php echo $show[0]['id'];?>"><img alt="" src="admin/uploads/<?php echo $img['albumPath'];?>"></a></span>
					</div>
				</div>
			</div>

			<div class="second_big_pro">
				<div class="index_pro_detail">
					<div class="index_pro_name" style="margin-top: 20px;">
						<h3>商品名称</h3>
						<div><?php echo $show[1]['pName'];?></div>
					</div>
					<div class="index_pro_firm">
						<h3>商品厂商</h3>
						<div><?php echo $show[1]['bra_cName']?></div>
					</div>
					<div class="index_pro_version">
						<h3>商品统称</h3>
						<div><?php echo $show[1]['pNum'];?></div>
					</div>
					<div class="index_pro_more">
						<a href="proDetails.php?id=<?php echo $show[1]['id'];?>">详&nbsp;情</a>
					</div>
				</div>
				<div class="index_second_big_img">
					<?php $img=getProImgById($show[1]['id']);?>
					<span><a href="proDetails.php?id=<?php echo $show[1]['id'];?>"><img alt="" src="admin/uploads/<?php echo $img['albumPath'];?>"></a></span>
				</div>
			</div>

		</div>
	</div>

	<div class="fouth_part">
		<div class="fouthPart">
			<?php for ($i=1;$i<=4;$i++):?>
			<ul class="index_shop_list" id="page<?php echo $i;?>" style="display:none;">
				<?php foreach ($rows as $key=>$row):
					if ($key>=$i*4-4&&$key<$i*4):
					$proImg=getProImgById($row['id']);
				?>
				<li class="index_shop_item">
					<div class="index_shop_img">
						<a href="proDetails.php?id=<?php echo $row['id'];?>"
							target="_blank">
							<div class="index_shop_image">
								<img src="admin/uploads/<?php echo $proImg['albumPath'];?>" alt="">
							</div>
							<div class="index_shop_name">
								<h6><?php echo $row['pName'];?></h6>
								<h6><?php echo $row['pNum'];?></h6>
							</div>
						</a>
					</div>
					<div class="index_shop_link">
						<a class="enquiry" href="contactUs.php?pName=<?php echo $row['pName'];?>">询价</a>
					</div>
				</li>
				<?php 
				endif;
				endforeach;
				?> 
			</ul>
			<?php endfor;?>
        	<div class="index_page">
        		<?php for ($j=4;$j>=1;$j--):?>
        			<b id="b<?php echo $j;?>" onclick="thisPage(<?php echo $j;?>)"><?php echo $j;?></b>
        		<?php endfor;?>
        	</div>
        </div>
	</div>

	<div class="fifth_part">
		<div class="index_link_title">
			<span>友情链接</span>
		</div>
		<div class="index_link">
			<ul>
				<li><a href="http://www.52rd.com/" target="_blank"><img alt="" src="images/52rd.jpg">我爱研发网</a></li>
				<li><a href="http://www.rdbuy.com/" target="_blank"><img alt="" src="images/rdbuy_new.png">研鼎商城</a></li>
			</ul>
		</div>
	</div>
	
	<?php include 'bottom.php';?>
</body>
<script type="text/javascript">
	window.onload = function (){
		var page1 = document.getElementById('page1');
		page1.style.display = 'block';

		var b = document.getElementById('b1');
		b.style.background = '#4ba0fa';
		b.style.color = '#fff';
	}	
	//点击推荐商品底部数字
	function thisPage(id){
	    for(i=1;i<=4;i++){
			var page = document.getElementById('page' + (i));
			page.style.display = 'none';

			var bInfo = document.getElementById('b' + (i));
	    	bInfo.style.background = '#fff';
	    	bInfo.style.color = '#c1c1c1';
	    }
		var pageInfo = document.getElementById('page' + id);
		pageInfo.style.display = 'block';


    	var bInfo = document.getElementById('b' + (id));
    	bInfo.style.background = '#4ba0fa';
    	bInfo.style.color = '#fff';
	}
			
	$(function(){
		for(var i=0;i<16;i++){
			if(i%4==2){
				$(".index_shop_item").eq(i).css("margin-right","26px");
			}
			if(i%4==3){
				$(".index_shop_item").eq(i).css("margin-right","0");
			}
		}
	})
	</script>
</html>
